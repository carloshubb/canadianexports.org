<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BannerResource;
use App\Mail\SponsorCredentialsMail;
use App\Models\Banner;
use App\Models\Customer;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    // public function index()
    // {
    //     $banners = Banner::query();

    //     $banners = $this->whereClause($banners);
    //     $banners = $this->loadRelations($banners);
    //     $banners = $this->sortingAndLimit($banners);

    //     return $this->apiSuccessResponse(BannerResource::collection($banners), 'Data Get Successfully!');
    // }
    public function index()
    {
        $banners = Banner::query();

        // Add customer_id filter if provided
        if (request()->has('customer_id')) {
            $banners = $banners->where('customer_id', request('customer_id'));
        }

        $banners = $this->whereClause($banners);
        $banners = $this->loadRelations($banners);
        $banners = $this->sortingAndLimit($banners);

        return $this->apiSuccessResponse(BannerResource::collection($banners), 'Data Get Successfully!');
    }


    public function show(Banner $banner)
    {

        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $banner = $banner->loadMissing('media');
        }
        if (isset($_GET['withMediaImage']) && $_GET['withMediaImage'] == '1') {
            $banner = $banner->loadMissing('mediaImage');
        }

        return $this->apiSuccessResponse(new BannerResource($banner), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $rules = [
            'type' => ['required', 'in:banners,sponsor'],
            'url' => ['required', new ValidUrl()],
            'media_id' => ['required', 'string'],
            'image' => ['required', 'string'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'contact_number' => ['required', 'string'],
            'appointment' => ['required', 'in:yes,no'],
            'time_to_call' => ['required', 'in:am,pm'],
            'business_name' => ['required', 'string'],
            'small_business_description' => ['required', 'string'],
            'detail_description' => ['required', 'string'],
            'is_visible' => ['sometimes', 'boolean'],
        ];
        $niceNames['media_id'] = 'logo';
        $niceNames['image'] = 'featured image';
        $this->validate($request, $rules, [], $niceNames);
        $media = json_decode($request->media_id, 1);

        $files = $this->moveFile($media, 'media/banners', ($request->type == 'banners' ? 'banners' : 'sponsor'));
        if (isset($request->image)) {
            $media = json_decode($request->image, 1);
            $files2 = $this->moveFile($media, 'media/banners', ($request->type == 'banners' ? 'banners' : 'sponsor'));
        }
        // if ($request->type == 'sponsor') {
        //     $randomPassword = Str::random(8);
        //     $customer = Customer::create([
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'business_name' => $request->business_name,
        //         'is_active' => 1,
        //         'password' => Hash::make($randomPassword),
        //         'type' => $request->type,
        //         'verify_customer_email' => 1,
        //         'is_package_amount_paid' => 1,
        //     ]);
        // }else {
        //     $customer = null;
        // }
        $customer = Customer::where('email', $request->email)->first();

        $randomPassword = Str::random(8);
        if ($request->type == 'sponsor') {
            if (!$customer) {
                $customer = Customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'business_name' => $request->business_name,
                    'is_active' => 1,
                    'password' => Hash::make($randomPassword),
                    'type' => 'sponsor',
                    'verify_customer_email' => 1,
                    'is_package_amount_paid' => 1,
                ]);
                $data = ['name' => $request->name, 'email' => $request->email, 'password' => $randomPassword];
                Mail::to($request->email)->send(new SponsorCredentialsMail($data));
            }
        }

        $existingSponsor = Banner::where('type', 'sponsor')
            ->where('email', $request->email)
            ->where('business_name', $request->business_name)
            ->first();

        if ($existingSponsor) {
            return $this->errorResponse('Sponsor with this email and business name already exists.', 422);
        } else {
            $banner = Banner::create([
                'type' => $request->type,
                'media_id' => (!empty($files) && is_array($files) && isset($files[0])) ? $files[0]->id : null,
                'url' => $request->url,
                'image' => (!empty($files2) && is_array($files2) && isset($files2[0])) ? $files2[0]->id : null,
                'customer_id' => isset($customer) ? $customer->id : null,
                // 'image' => isset($files2, $files2[0]) ? $files2[0]->id : null,
                // 'customer_id' => $customer->id ?? null,
                'business_name' => $request->business_name,
                'slug' => $this->generateUniqueSlug($request->business_name),
                'small_business_description' => $request->small_business_description,
                'detail_description' => $request->detail_description,
                'contact_number' => $request->contact_number,
                'message' => $request->message,
                'time_to_call' => $request->time_to_call,
                'appointment' => $request->appointment,
                'appointment_date' => $request->appointment_date,
                'is_visible' => $request->is_visible ?? 0,
                'is_active' => $request->is_active ?? 'inactive',
            ]);
        }
        if ($banner && $customer) {
            $data = ['name' => $request->name, 'email' => $request->email, 'password' => $randomPassword];
            Log::info(['data' => $data]);
            Mail::to($request->email)->send(new SponsorCredentialsMail($data));
        }


        if ($banner) {
            return $this->apiSuccessResponse(new BannerResource($banner), 'Banner has been added successfully.');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Banner $banner)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\Banner,id'],
            'type' => ['required', 'in:banners,sponsor'],
            'url' => ['required', new ValidUrl()],
            'media_id' => ['required', 'string'],
            'image' => ['required', 'string'],
            'contact_number' => ['required', 'string'],
            'appointment' => ['required', 'in:yes,no'],
            'time_to_call' => ['required', 'in:am,pm'],
            'business_name' => ['required', 'string'],
            'small_business_description' => ['required', 'string'],
            'detail_description' => ['required', 'string'],
            'is_visible' => ['sometimes', 'boolean'],
        ];
        $niceNames['media_id'] = 'logo';
        $niceNames['image'] = 'featured image';
        $this->validate($request, $rules, [], $niceNames);
        if (isset($request->media_id) && !is_array($request->media_id)) {
            $media = json_decode($request->media_id, 1);
            $files = $this->moveFile($media, 'media/banners', ($request->type == 'banners' ? 'banners' : 'sponsor'));
        }
        if (isset($request->image) && !is_array($request->image)) {
            $media = json_decode($request->image, 1);
            $files2 = $this->moveFile($media, 'media/banners', ($request->type == 'banners' ? 'banners' : 'sponsor'));
        }

        $existingSponsor = Banner::where('type', 'sponsor')
            ->where('email', $request->email)
            ->where('business_name', $request->business_name)
            ->where('id', '!=', $request->id)
            ->first();

        if ($existingSponsor) {
            return $this->errorResponse('Sponsor with this email and business name already exists.', 422);
        } else {
            $result = Banner::whereId($request->id)->update([
                'type' => $request->type,
                'url' => $request->url,
                'media_id' => !isset($request->media_id) ? null : (isset($files, $files[0]) ? $files[0]->id : $banner->media_id),
                'image' => isset($files2, $files2[0]) ? $files2[0]->id : $banner->image,
                'business_name' => $request->business_name,
                'slug' => $this->generateUniqueSlug($request->business_name),
                'small_business_description' => $request->small_business_description,
                'detail_description' => $request->detail_description,
                'is_visible' => $request->is_visible,
                'contact_number' => $request->contact_number,
                'message' => $request->message,
                'time_to_call' => $request->time_to_call,
                'appointment' => $request->appointment,
                'appointment_date' => $request->appointment_date,
                'is_visible' => $request->is_visible,
                'is_active' => $request->is_active ?? 'inactive',
            ]);

            if ($result) {
                return $this->apiSuccessResponse(new BannerResource($banner), 'Banner has been updated successfully.');
            }
        }
    }


    public function destroy(Request $request, Banner $banner)
    {
        if ($banner->delete()) {
            return $this->apiSuccessResponse(new BannerResource($banner), 'Banner has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($banners)
    {
        if (isset($_GET['withMedia']) && $_GET['withMedia'] == '1') {
            $banners = $banners->with('media');
        }
        if (isset($_GET['withMediaImage']) && $_GET['withMediaImage'] == '1') {
            $banners = $banners->loadMissing('mediaImage');
        }
        return $banners;
    }

    protected function sortingAndLimit($banners)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $banners->orderBy('is_default', 'desc')->orderBy('name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'native_name', 'business_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $banners = $banners->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $banners->paginate($limit);
    }

    protected function whereClause($banners)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $banners = $banners->where('business_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $banners;
    }

    protected function generateUniqueSlug($initialSlug): string
    {
        $slug = Str::slug($initialSlug);
        $count = 1;

        while (Banner::where('slug', $slug)->exists()) {
            $slug = Str::slug($initialSlug . '-' . $count);
            $count++;
        }

        return $slug;
    }
    public function getBannerListingSetting()
    {
        $customerId = Auth::user()->id;
        $banners = Banner::where('customer_id', $customerId)->get();

        return view('banners.index', compact('banners'));
    }

    public function becomeSponsor($lang)
    {
        $customerId = Auth::user()->id;
        $banners = Banner::where('customer_id', $customerId)->get();

        return view('banners.index', compact('banners'));
    }
}
