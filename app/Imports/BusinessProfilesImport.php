<?php

namespace App\Imports;

use App\Traits\FileUploadTrait;
use App\Models\BusinessCategoryDetail;
use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use Maatwebsite\Excel\Events\AfterImport;
use App\Models\ImportTempFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class BusinessProfilesImport implements ToModel, WithChunkReading, WithEvents, ShouldQueue
{
    use RemembersChunkOffset;
    use RegistersEventListeners;
    use FileUploadTrait;
    /**
     * @param Collection $collection
     */

    public function model(array $rows)
    {
        $this->getChunkOffset();

        Log::info("Company name => " . $rows[0]);
        if (!in_array($rows[1], ['Monthly', 'Quarterly', 'Semi-annual', 'Annual'])) {
            Log::info("Company name => " . $rows[0] . " Package duration doesn't match");
            return null;
        }
        if (!isset($rows[2])) {
            Log::info("Company name => " . $rows[0] . " Registration package (Free, Premium, Featured) is required");
            return null;
        }
        if (!in_array($rows[2], ['Free', 'Featured', 'Premium'])) {
            Log::info("Company name => " . $rows[0] . " value must be from (Free, Premium, Featured)");
            return null;
        }
        $package = getRegistrationPackageByType(strtolower($rows[2]));
        if (!isset($package)) {
            Log::info("Company name => " . $rows[0] . " Selected package does not exist");
            return null;
        }
        if (!isset($rows[3])) {
            Log::info("Company name => " . $rows[0] . " auto renew does not exist");
            return null;
        }
        if (!in_array($rows[3], ['yes', 'no'])) {
            Log::info("Company name => " . $rows[0] . " auto renew values must be yes, no");
            return null;
        }
        if (!isset($rows[6])) {
            Log::info("Company name => " . $rows[0] . " customer email is required");
            return null;
        }
        if (Customer::where('email', $rows[6])->exists()) {
            Log::info("Company name => " . $rows[0] . " customer email must be unique");
            return null;
        }
        if (!isset($rows[9])) {
            Log::info("Company name => " . $rows[0] . " Company e-mail is required");
            return null;
        }
        if (CustomerProfile::where('company_email', $rows[9])->exists()) {
            Log::info("Company name => " . $rows[0] . " Company e-mail must be unique");
            return null;
        }

        $businessCategoryArray = [];
        if (isset($rows[8])) {
            $businessCategoriesNames = explode(',', $rows[8]);
            foreach ($businessCategoriesNames as $key => $businessCategoriesName) {
                $businessCategoriesName = trim($businessCategoriesName);
                $businessCategoryDetail = BusinessCategoryDetail::where('name', 'LIKE', '%' . $businessCategoriesName . '%')->first();
                if ($businessCategoryDetail) {
                    $businessCategoryArray[] = $businessCategoryDetail->business_category_id;
                }
            }
        }

        if (count($businessCategoryArray) == 0) {
            Log::info("Company name => " . $rows[0] . " no business profile found");
            return null;
        }

        // if (!isset($rows[27])) {
        //     return null;
        // }

        if ($rows[1] == 'Monthly') {
            $months = 1;
        } else if ($rows[1] == 'Quarterly') {
            $months = 3;
        } else if ($rows[1] == 'Semi-annual') {
            $months = 6;
        } else if ($rows[1] == 'Annual') {
            $months = 12;
        }

        $package_validity = date('Y-m-d', strtotime('+' . $months . ' months'));
        $paymentFrequency = "monthly";
        if ($package->package_type == 'free') {
            $packagePrice = 0;
        } else if ($package->package_type == 'featured' || $package->package_type == 'premium') {
            if ($rows[1] == 'Monthly') {
                $packagePrice = $package->monthly_price;
                $paymentFrequency = "monthly";
            } else if ($rows[1] == 'Quarterly') {
                $packagePrice = $package->quarterly_price * 3;
                $paymentFrequency = "quarterly";
            } else if ($rows[1] == 'Semi-annual') {
                $packagePrice = $package->semi_annually_price * 6;
                $paymentFrequency = "semi_annually";
            } else if ($rows[1] == 'Annual') {
                $packagePrice = $package->annually_price * 12;
                $paymentFrequency = "annually";
            }
        }

        $customer = Customer::create([
            'name' => (isset($rows[4]) ? $rows[4] . ' - ' : '') . ($rows[5] ?? ''),
            'email' => $rows[6],
            'password' => isset($rows[7]) ? Hash::make($rows[7]) : Hash::make(rand(10, 10000)),
            'is_auto_renew' => $rows[3] == 'yes' ? 1 : 0,
            // 'is_auto_renew' => 0,
            'is_active' => 1,
            'type' => 'customer',
            'active_email_url' => null,
            'registration_package_id' => $package->id,
            'package_price' => $packagePrice,
            'package_subscribed_date' => date('Y-m-d'),
            'package_expiry_date' => $package_validity,
            'is_package_amount_paid' => 1,
            'events_allowed' => isset($package) ? $package->events_allowed : 0,
            'events_remaining' => isset($package) ? $package->events_allowed : 0,
            'images_allowed' => isset($package) ? $package->images_allowed : 0,
            'payment_frequency' => $paymentFrequency ?? null,
        ]);


        $customerProfile = CustomerProfile::create([
            'company_name' => $rows[0] ?? null,
            'slug' => $rows[0] ? $this->generateUniqueSlug($rows[0]) : null,
            'company_email' => $rows[9] ?? null,
            'address' => (isset($rows[10]) ? $rows[10] . "\n" : '') . (isset($rows[11]) ? $rows[11] . "\n" : '') . (isset($rows[12]) ? $rows[12] . "\n" : '') . (isset($rows[13]) ? $rows[13] . "\n" : '') . (isset($rows[14]) ? $rows[14] . "\n" : ''),
            'phone' => $rows[15] ?? null,
            'website' => $rows[16] ?? null,
            'short_description' => $rows[17] ?? null,
            'description' => $rows[18] ?? null,
            'keywords' => $rows[19] ?? null,
            'customer_id' => $customer->id,
        ]);

        foreach ($businessCategoryArray as $business_category_id) {
            if (CustomerBusinessCategory::whereCustomerId($customer->id)->count() >= 3) {
                continue;
            }
            CustomerBusinessCategory::create([
                'business_category_id' => $business_category_id,
                'customer_id' => $customer->id,
                'customer_profile_id' => $customerProfile->id,
            ]);
        }

        $customerMedia = CustomerMedia::create([
            "title" => $rows[20] ?? null,
            "description" => $rows[21] ?? null,
            "video" => $rows[23] ?? null,
            "video_frame" => getVideoHtmlAttribute($rows[23]),
            "customer_id" => $customer->id,
            'customer_profile_id' => $customerProfile->id,
        ]);



        ImportTempFile::create([
            "logo" => $rows[22] ?? null,
            "image1" => $rows[24] ?? null,
            "image2" => $rows[25] ?? null,
            "image3" => $rows[26] ?? null,
            "image4" => $rows[27] ?? null,
            'customer_media_id' => $customerMedia->id ?? null,
        ]);

        CustomerSocialMedia::create([
            "facebook" => $rows[28] ?? null,
            "twitter" => $rows[29] ?? null,
            "youtube" => $rows[30] ?? null,
            "linked_in" => $rows[31] ?? null,
            "social_media5" => $rows[32] ?? null,
            "customer_id" => $customer->id,
            'customer_profile_id' => $customerProfile->id,
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }

    protected function generateUniqueSlug($initialSlug): string
    {
        $slug = Str::slug($initialSlug);
        $count = 1;

        while (CustomerProfile::where('slug', $slug)->exists()) {
            $slug = Str::slug($initialSlug . '-' . $count);
            $count++;
        }

        return $slug;
    }



    public static function afterImport(AfterImport $event)
    {
        \Artisan::call("process:import-temp-files");
    }
}
