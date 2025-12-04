<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\PackageResource;
use App\Models\Package;
use App\Models\PackageDetail;
use App\Models\PackageFeature;
use App\Services\Package\PayPalService;
use App\Services\Package\StripeService;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $packages = Package::query();

        $packages = $this->whereClause($packages);
        $packages = $this->loadRelations($packages);
        $packages = $this->sortingAndLimit($packages);

        return $this->apiSuccessResponse(PackageResource::collection($packages), 'Data Get Successfully!');
    }


    public function show(Package $package)
    {
        if (isset($_GET['withPackageDetail']) && $_GET['withPackageDetail'] == '1') {
            $package = $package->loadMissing('packageDetail');
        }
        if (isset($_GET['withPackageFeature']) && $_GET['withPackageFeature'] == '1') {
            $package = $package->loadMissing('packageFeature');
        }

        return $this->apiSuccessResponse(new PackageResource($package), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $languages = getAllLanguages();

        $data = $this->validateData($request, $languages);

        $this->validate(
            $request,
            $data['validationRule'],
            $data['errorMessages']
        );

        $isPackageExists = Package::where('type', $request->type)->where('package_type', $request->package_type)->exists();
        if ($isPackageExists) {
            return $this->errorResponse("Package has been already created.");
        }


        DB::beginTransaction();
        try {
            $package = Package::create($this->packageData($request));

            $this->storePackageDetail($request, $languages, $package);

            $stripeService = new StripeService();
            $stripeService->createOrUpdatePackage($package, $request);

            $paypalService = new PayPalService();
            $paypalService->createOrUpdatePackage($request, $package);

            if ($request->is_default == true) {
                $this->removeDefaultPackage($package, $request->type);
            }

            DB::commit();

            return $this->apiSuccessResponse(new PackageResource($package), 'Package has been added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            $exceptionMessage = $e->getMessage() ?? null;
            if ($exceptionMessage) {
                return $this->errorResponse($e->getMessage());
            }
        }

        return $this->errorResponse();
    }

    public function update(Request $request, Package $package)
    {
        $languages = getAllLanguages();

        $data = $this->validateData($request, $languages);

        $this->validate(
            $request,
            $data['validationRule'],
            $data['errorMessages']
        );

        $isPackageExists = Package::where('id', '!=', $package->id)->where('type', $request->type)->where('package_type', $request->package_type)->exists();
        if ($isPackageExists) {
            return $this->errorResponse("Package has been already created.");
        }

        DB::beginTransaction();
        try {
            $oldPackage = Package::whereId($package->id)->first();
            
            $package->update($this->packageData($request));
            
            $this->storePackageDetail($request, $languages, $package);
            
            $stripeService = new StripeService();
            $stripeService->createOrUpdatePackage($oldPackage, $request, true);

            $paypalService = new PayPalService();
            $paypalService->createOrUpdatePackage($request, $oldPackage);

            if ($request->is_default == true) {
                $this->removeDefaultPackage($package, $request->type);
            }

            DB::commit();

            return $this->apiSuccessResponse(new PackageResource($package), 'Package has been updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            $exceptionMessage = $e->getMessage() ?? null;
            if ($exceptionMessage) {
                return $this->errorResponse($e->getMessage());
            }
        }

        return $this->errorResponse();
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted successfully.');
    }

    protected function loadRelations($packages)
    {
        $defaultLang = getDefaultLanguage(0);
        $packages = $packages->with(['packageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withPackageDetail']) && $_GET['withPackageDetail'] == '1') {
            $packages = $packages->with('packageDetail');
        }
        if (isset($_GET['withPackageFeature']) && $_GET['withPackageFeature'] == '1') {
            $packages = $packages->with('packageFeature');
        }
        if (isset($_GET['getPackagesOnly']) && $_GET['getPackagesOnly'] == '1') {
            return $packages->whereIn('package_type', ['free', 'featured', 'premium']);
        }
        if (isset($_GET['getProfilePackagesOnly']) && $_GET['getProfilePackagesOnly'] == '1') {
            $packages = $packages->where('type', 'profile');
        }
        return $packages;
    }

    protected function sortingAndLimit($packages)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'price', 'is_default', 'package_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $packages = $packages->addSelect(['package_name' => PackageDetail::whereColumn('packages.id', 'package_detail.package_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $packages = $packages->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $packages->get();
        }

        return $packages->paginate($limit);
    }

    protected function whereClause($packages)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $packages = $packages->whereHas('packageDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $packages;
    }

    protected function validateData($request, $languages)
    {
        $data['validationRule'] = [];
        $data['errorMessages'] = [];
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $data['validationRule'] = array_merge($data['validationRule'], ['name.name_' . $language->id => [$requiredVal, 'string']]);
            $data['errorMessages'] = array_merge($data['errorMessages'], ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);

            $data['validationRule'] = array_merge($data['validationRule'], ['short_description.short_description_' . $language->id => ['nullable', 'string']]);
            $data['errorMessages'] = array_merge($data['errorMessages'], ['short_description.short_description_' . $language->id . '.required' => 'Short description in ' . $language->name . ' is required.']);
        }
        $data['validationRule'] = array_merge($data['validationRule'], ['type' => ['required', 'in:profile,event']]);
        $data['validationRule'] = array_merge($data['validationRule'], ['package_type' => ['required', 'in:free,featured,premium']]);
        $data['validationRule'] = array_merge($data['validationRule'], ['is_default' => ['boolean']]);
        $data['validationRule'] = array_merge($data['validationRule'], ['events_allowed' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);

        if ($request->type && $request->type == 'event') {
            $data['validationRule'] = array_merge($data['validationRule'], ['event_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
        } else {
            if (isset($request->package_type) && in_array($request->package_type, ['featured', 'premium'])) {
                $data['validationRule'] = array_merge($data['validationRule'], ['monthly_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
                $data['validationRule'] = array_merge($data['validationRule'], ['quarterly_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
                $data['validationRule'] = array_merge($data['validationRule'], ['semi_annual_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
                $data['validationRule'] = array_merge($data['validationRule'], ['annual_price' => ['required', 'regex:/^\d+(\.\d{1,6})?$/']]);
            }
        }
        return $data;
    }

    protected function storePackageDetail($request, $languages, $package)
    {
        PackageFeature::wherePackageId($package['id'])->delete();

        foreach ($languages as $language) {
            $packageDetail = PackageDetail::whereLanguageId($language->id)->wherePackageId($package['id'])->first();

            $packageData = [
                'package_id' => $package['id'],
                'language_id' => $language->id,
                'name' => $request['name']['name_' . $language->id] ?? null,
                'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
            ];

            if ($packageDetail) {
                $packageDetail->update($packageData);
            } else {
                PackageDetail::create($packageData);
            }


            $features = $request['features']['features_' . $language->id] ?? null;
            if ($features) {
                foreach ($features as $key => $feature) {
                    PackageFeature::create([
                        'package_id' => $package['id'],
                        'language_id' => $language->id,
                        'name' => $feature,
                    ]);
                }
            }
        }
    }

    protected function packageData($request)
    {
        return [
            'type' => $request->type,
            'package_type' => $request->package_type,
            // 'sorting_order' => 0,
            'is_default' => $request->is_default,
            'events_allowed' => $request->events_allowed,
            'images_allowed' => $request->images_allowed,
            'monthly_price' => $request->monthly_price ?? 0,
            'quarterly_price' => $request->quarterly_price ?? 0,
            'semi_annual_price' => $request->semi_annual_price ?? 0,
            'annual_price' => $request->annual_price ?? 0,
            'event_price' => $request->event_price ?? 0,
        ];
    }
}
