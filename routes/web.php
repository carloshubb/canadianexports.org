<?php

use App\Http\Controllers\StripeWebHookController;
use App\Http\Controllers\TempImportFileController;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Models\ImportTempFile;
use App\Models\RegistrationPackage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('/dashboard', function () {
//     return view('admin.app');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/web-routes.php';


// Route::get('/delete-business-profile', function(){
//     $ids = Customer::where('type', 'customer')->pluck('id');
//     CustomerProfile::whereNotIn('customer_id', $ids)->delete();
//     CustomerBusinessCategory::whereNotIn('customer_id', $ids)->delete();
//     $test_id = CustomerMedia::whereNotIn('customer_id', $ids)->pluck('id');
//     ImportTempFile::whereIn('customer_media_id', $test_id)->delete();
//     CustomerMedia::whereNotIn('id', $test_id)->delete();
//     CustomerSocialMedia::whereNotIn('customer_id', $ids)->delete();
//     Customer::where('type', 'customer')->delete();
// });

Route::post('/stripe/webhook', [StripeWebHookController::class, 'index'])->name('stripe.webhook');
// Route::get('/import/files', [TempImportFileController::class, 'index'])->name('import.files');
// Route::get('/cron/job/run-queue', function(){
//     \Artisan::call("queue:listen");
// });
// Route::get('/cron/job/import-temp-files', function(){
//     \Artisan::call("process:import-temp-files");
// });

// Route::get('/convert-data-to-new-db', function () {
//     $oldBusinessCategories = DB::connection('mysql2')->table('categories')->get();
//     Schema::disableForeignKeyConstraints();
//     DB::connection('mysql')->table('business_category_detail')->truncate();
//     DB::connection('mysql')->table('business_categories')->truncate();
//     DB::connection('mysql')->table('customers')->truncate();
//     DB::connection('mysql')->table('customer_profile')->truncate();
//     DB::connection('mysql')->table('customer_business_categories')->truncate();
//     DB::connection('mysql')->table('customer_media')->truncate();
//     DB::connection('mysql')->table('customer_social_media')->truncate();
//     Schema::enableForeignKeyConstraints();
//     $lang = getDefaultLanguage();
//     foreach ($oldBusinessCategories as $key => $oldBusinessCategory) {
//         $slug = checkSlug(Str::slug($oldBusinessCategory->name_en));
//         $businessCategory = BusinessCategory::create([
//             'id' => $oldBusinessCategory->id,
//             'slug' => $slug
//         ]);

//         BusinessCategoryDetail::create([
//             'business_category_id' => $businessCategory->id,
//             'language_id' => $lang->id,
//             'name' => $oldBusinessCategory->name_en,
//             'slug' => $slug,
//         ]);
//     }

//     $user = User::first();
//     $regPackage = RegistrationPackage::where('is_default', 1)->first();

//     if (!$regPackage) {
//         return 'please set one registration package as default.';
//     }

//     $customer = Customer::where('email', $user->email)->first();

//     if (!$customer) {
//         $customer = Customer::create([
//             'name' => $user->name,
//             'email' => $user->email,
//             'password' => $user->password,
//             'type' => 'customer',
//             'is_active' => '1',
//             'registration_package_id' => isset($regPackage->id) ? $regPackage->id : null,
//             'package_price' => isset($regPackage->discount_price) && $regPackage->discount_price > 0 ? $regPackage->discount_price : (isset($regPackage->price) ? $regPackage->price : 0),
//             'free_subscription_days' => isset($regPackage->free_subscription_days) ? $regPackage->free_subscription_days : 0,
//             'package_subscribed_date' => date('Y-m-d'),
//             'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($regPackage) ? $regPackage->package_validity_months : 0) . ' months')),
//             'events_allowed' => isset($regPackage->events_allowed) ? $regPackage->events_allowed : 0,
//             'events_remaining' => isset($regPackage->events_allowed) ? $regPackage->events_allowed : 0,
//             'i2b_allowed' => isset($regPackage->i2b_allowed) ? $regPackage->i2b_allowed : 0,
//             'i2b_remaining' => isset($regPackage->i2b_allowed) ? $regPackage->i2b_allowed : 0,
//             'images_allowed' => isset($regPackage->images_allowed) ? $regPackage->images_allowed : 0,
//             'is_package_amount_paid' => 1,
//         ]);
//     } else {
//         $customer->update([
//             'name' => $user->name,
//             'email' => $user->email,
//             'password' => $user->password,
//             'type' => 'customer',
//             'is_active' => '1',
//             'registration_package_id' => isset($regPackage->id) ? $regPackage->id : null,
//             'package_price' => isset($regPackage->discount_price) && $regPackage->discount_price > 0 ? $regPackage->discount_price : (isset($regPackage->price) ? $regPackage->price : 0),
//             'free_subscription_days' => isset($regPackage->free_subscription_days) ? $regPackage->free_subscription_days : 0,
//             'package_subscribed_date' => date('Y-m-d'),
//             'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($regPackage) ? $regPackage->package_validity_months : 0) . ' months')),
//             'events_allowed' => isset($regPackage->events_allowed) ? $regPackage->events_allowed : 0,
//             'events_remaining' => isset($regPackage->events_allowed) ? $regPackage->events_allowed : 0,
//             'i2b_allowed' => isset($regPackage->i2b_allowed) ? $regPackage->i2b_allowed : 0,
//             'i2b_remaining' => isset($regPackage->i2b_allowed) ? $regPackage->i2b_allowed : 0,
//             'images_allowed' => isset($regPackage->images_allowed) ? $regPackage->images_allowed : 0,
//             'is_package_amount_paid' => 1,
//         ]);
//     }


//     $oldProfiles = DB::connection('mysql2')->table('profiles')->get();

//     foreach ($oldProfiles as $key => $oldProfile) {

//         $customerProfile = CustomerProfile::create([
//             'company_name' => $oldProfile->company_name,
//             'company_email' => $oldProfile->company_email,
//             'short_description' => $oldProfile->short_description,
//             'description' => $oldProfile->description,
//             'phone' => $oldProfile->phone,
//             'website' => $oldProfile->site,
//             'keywords' => $oldProfile->key_word,
//             'address' => $oldProfile->address,
//             'customer_id' => $customer->id
//         ]);


//         $oldCategoryProfiles = DB::connection('mysql2')->table('category_profile')->where('profile_id', $oldProfile->id)->get();

//         foreach ($oldCategoryProfiles as $oldCategoryProfile) {
//             $isBusinessCategoryExist = BusinessCategory::whereId($oldCategoryProfile->category_id)->exists();
//             if ($isBusinessCategoryExist) {
//                 CustomerBusinessCategory::create([
//                     'business_category_id' => $oldCategoryProfile->category_id,
//                     'customer_id' => $customer->id,
//                     'customer_profile_id' => $customerProfile->id,
//                 ]);
//             }
//         }

//         CustomerMedia::create([
//             "logo" => null,
//             "video" => null,
//             "video_frame" => null,
//             "customer_id" => null,
//             'customer_profile_id' => $customerProfile->id,
//         ]);

//         $oldSocialMedia = DB::connection('mysql2')->table('social_media')->where('profile_id', $oldProfile->id)->first();

//         if ($oldSocialMedia) {
//             CustomerSocialMedia::create([
//                 "facebook" => $oldSocialMedia->facebook,
//                 "twitter" => $oldSocialMedia->twitter,
//                 "youtube" => $oldSocialMedia->youtube,
//                 "linked_in" => $oldSocialMedia->linked_in,
//                 "customer_id" => null,
//                 'customer_profile_id' => $customerProfile->id,
//             ]);
//         }
//     }

//     return 1;
// });

Route::view('/admin/{any}', 'admin.app')
    ->middleware(['auth', 'auth:sanctum'])
    ->where('any', '.*');

if (env('APP_ENV') != 'local') {
    URL::forceScheme('https');
}
