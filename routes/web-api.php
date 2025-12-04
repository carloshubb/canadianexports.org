<?php

use App\Http\Controllers\Api\Admin\BannerController;
use App\Http\Controllers\Api\Admin\EventController as AdminEventController;
use App\Http\Controllers\Api\Admin\MediaController;
use App\Http\Controllers\Api\Web\{
    SignupController,
    HelperController,
    AccountSettingController,
    CustomerPaymentMethodController,
    RecaptchaController,
    FinancingProgramController,
    TestimonialSettingController,
    SuccessStoriesSettingController,
    BecomeSponsorController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;

Route::group(['prefix' => 'web'], function () {
    Route::group(['prefix' => 'media'], function () {
        Route::post('/process', [MediaController::class, 'process']);
        Route::post('/revert', [MediaController::class, 'revert']);
        Route::get('/load', [MediaController::class, 'load']);
        Route::post('image_again_upload', [MediaController::class, 'uploadImage']);
    });
    Route::post('/get-customer-details', [TestimonialSettingController::class, 'getCustomerDetails']);
    Route::post('/get-customer-details', [SuccessStoriesSettingController::class, 'getCustomerDetails']);


    Route::post('/signup', [SignupController::class, 'signup']);
    Route::post('/social-media', [AccountSettingController::class, 'updateSocialMedia']);
    Route::post('/update-profile-setting', [AccountSettingController::class, 'updateProfileSetting']);
    Route::post('/cancel-subscription', [AccountSettingController::class, 'cancelSubscription']);
    Route::post('/resume-subscription', [AccountSettingController::class, 'resumeSubscription']);
    Route::get('/get-captcha-error', [HelperController::class, 'getCaptchaError']);
    Route::post('/verifyRecaptcha', [RecaptchaController::class, 'verifyRecaptcha']);
    Route::get('/get-business-profile-limit-error', [HelperController::class, 'getBusinessProfileLimitError']);
    Route::get('/get-password-miss-match-error', [HelperController::class, 'getPasswordMissMatchError']);
    Route::post('/visitor-stats', [HelperController::class, 'visitorStats'])->name('web.api.visitor-stats');   Route::post('/upgrade-package', [AccountSettingController::class, 'upgradePackage']);
    Route::post('/user-profile', [AccountSettingController::class, 'updateUserProfile']);
    Route::post('/bussiness-profile', [AccountSettingController::class, 'updateBusinessProfile']);
    Route::post('/media-setting', [AccountSettingController::class, 'updateMediaSetting']);
    Route::get('/event-listing-setting', [HelperController::class, 'getEventListingSetting']);
    Route::get('/sponser-listing-setting', [HelperController::class, 'getSponserListingSetting']);
    Route::get('/banner-listing-setting', [BannerController::class, 'getBannerListingSetting']);
    Route::get('/get-static-setting', [HelperController::class, 'getStaticSetting']);
    Route::get('/get-billing-discounts', [HelperController::class, 'getBillingDiscounts']);
    Route::get('/get-registration-packages', [HelperController::class, 'getRegistrationPackages']);
    Route::get('/get-business-categories', [HelperController::class, 'getBusinessCategories']);
    Route::get('/get-reg-page-setting', [HelperController::class, 'getRegPageSetting']);
    Route::post('/check-customer-email', [HelperController::class, 'checkCustomerEmail']);
    Route::post('/check-customer-profile-email', [HelperController::class, 'checkCustomerProfileEmail']);
    Route::get('/customer-payment-methods', [CustomerPaymentMethodController::class, 'index']);
    Route::apiResource('events', AdminEventController::class);
    Route::apiResource('sponsers', BannerController::class);
    Route::get('/business-categories', [FinancingProgramController::class, 'getBusinessCategories']);
    
    // Sponsor routes
    Route::post('/become-sponsor/process-payment', [BecomeSponsorController::class, 'processSponsorPayment']);
    Route::get('/get-coffee-wall-beneficiaries', [HelperController::class, 'getCoffeeWallBeneficiaries']);
    Route::get('/get-sponsor-amounts', [HelperController::class, 'getSponsorAmounts']);
});

Route::get('/create-event-restriction', [HelperController::class, 'CreateEventRestriction'])->name('create_event_restriction');


Route::group(['prefix' => 'web', 'middleware' => ['auth.user']], function () {
    Route::get('/user', function (Request $request) {
        $user = auth()->guard('customers')->user();
        return response()->json(['data' => $user, 'status' => 'Success']);
    });
    
    // Sponsor profile routes (require authentication)
    Route::get('/sponsor/profile', [BecomeSponsorController::class, 'getSponsorProfile']); // Get all sponsorships
    Route::get('/sponsor/profile/{id}', [BecomeSponsorController::class, 'getSponsorById']); // Get specific sponsorship
    Route::post('/sponsor/update-profile', [BecomeSponsorController::class, 'updateSponsorProfile']);
});
