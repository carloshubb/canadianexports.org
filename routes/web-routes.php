<?php

use App\Http\Controllers\Api\Admin\BannerController;
use App\Http\Controllers\Api\Admin\EventController as AdminEventController;
use App\Http\Controllers\Api\Web\FinancingProgramController;
use App\Http\Controllers\Api\Admin\MediaController;
use App\Http\Controllers\Api\Web\{
    AccountSettingController,
    BecomeSponsorController,
    HelperController,
    PaymentController,
    SignupController,
    EventSignupController,
    BusinessCategoryController,
    CommentsController,
    ContactForRateController,
    ContactUsController,
    CronJobController,
    SponsorController,
    EventController,
    ScamAlertController,
    FaqExporterController,
    FaqImporterController,
    ExportingFairController,
    HomeController,
    InfoLetterController,
    InquiryController,
    SearchController,
    TestimonialSettingController,
    SuccessStoriesSettingController,
    RatesSettingController,
    ArticleController
};
use App\Http\Controllers\Web\ArticlePageController;
use App\Models\Customer;
use App\Models\Language;
use App\Services\PaypalService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cron-job'], function () {
    Route::get('/info-letter-subscribe-emails', [CronJobController::class, 'infoLetterSubscribeEmails']);
    Route::get('/holiday-emails', [CronJobController::class, 'holiday_emails']);
    Route::get('/membership-expiry-emails', [CronJobController::class, 'membership_expiry_emails']);
});
// Paypal webhook
Route::get('/subscription/success/coffee-wall', [PaymentController::class, 'paypalSuccessResponseCoffeeWall'])->name('paypal.subscription.success.coffee_wall');
Route::get('/subscription/cancel/coffee-wall', [PaymentController::class, 'paypalCancelResponseCoffeeWall'])->name('paypal.cancel');
Route::get('/subscription/success/sponsor', [PaymentController::class, 'paypalSuccessResponseSponsor'])->name('paypal.subscription.success.sponsor');
Route::get('/subscription/cancel/sponsor', [PaymentController::class, 'paypalCancelResponseSponsor'])->name('paypal.cancel.sponsor');
Route::get('/subscription/success', [PaymentController::class, 'paypalSuccessResponse'])->name('paypal.subscription.success');
Route::get('/subscription/cancel', [PaymentController::class, 'paypalCancelResponse'])->name('paypal.subscription.cancel');

Route::group(['middleware' => ['share.variable', 'user.status']], function () {
    Route::get('/accept-cookies', [HelperController::class, 'acceptCookies'])->name('accept-cookies');
    Route::post('/logged-in-user', [SignupController::class, 'loggedInUser']);
    Route::post('/get-logged-in-user', [SignupController::class, 'getLoggedInUser']);


    Route::post('/event-signup', [EventSignupController::class, 'signup'])->name('web.event-signup.signup');
    Route::post('/event-signup-payment', [EventSignupController::class, 'signupPayment'])->name('web.event-signup.payment');
    Route::post('/event-signup-email-validation', [EventSignupController::class, 'emailValidation'])->name('web.event-signup.signup-email-validation');

    Route::get('/{abbreviation?}/user/forgot-password', [SignupController::class, 'showForgotPassword'])->name('web.password.request')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());

    Route::post('/user/forgot-password', [SignupController::class, 'forgotPassword'])->name('web.password.reset');

    Route::get('/{abbreviation?}/user/resend-verification-email', [SignupController::class, 'showResendVerificationEmail'])->name('web.resend-verification-email.request')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());

    Route::post('/user/resend-verification-email', [SignupController::class, 'resendVerificationEmail'])->name('web.resend-verification-email.reset');

    Route::group(['prefix' => 'user'], function () {
        Route::post('/logout', [SignupController::class, 'logout'])->name('web.user.logout');
        Route::post('/delete-profile', [SignupController::class, 'deleteProfile'])->name('web.user.delete-profile');
    });

    Route::get('/{abbreviation?}/category/{slug}', [BusinessCategoryController::class, 'index'])->name('user.business-category.index')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/sponsor-detail/{slug}', [SponsorController::class, 'show'])->name('user.sponsor-detail.show')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/profile/{slug}', [BusinessCategoryController::class, 'show'])->name('user.business-category.show')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/event/{id}', [EventController::class, 'show'])->name('user.event.show')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/exporting-fair/{id}', [ExportingFairController::class, 'show'])->name('user.exporting-fair.show')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::post('/profile/send-message', [BusinessCategoryController::class, 'sendMessage'])->name('user.business-category.send-message');
    Route::post('/become-sponsor/send-message', [BecomeSponsorController::class, 'sendMessage'])->name('user.become-sponsor.send-message');
    Route::post('/become-sponsor/process-payment', [BecomeSponsorController::class, 'processSponsorPayment'])->name('user.become-sponsor.process-payment');
    Route::get('/search/business-directory', [HomeController::class, 'businessDirectorySearch'])->name('business_directory_search');
    Route::post('/become-sponsor/update-profile', [BecomeSponsorController::class, 'updateProfile'])->name('user.become-sponsor.update-profile');
    
    // Sponsor Profile Management (requires authentication)
    Route::middleware(['auth:customers'])->group(function () {
        Route::get('/sponsor/profile', [BecomeSponsorController::class, 'getSponsorProfile'])->name('sponsor.profile');
        Route::post('/sponsor/update-profile', [BecomeSponsorController::class, 'updateSponsorProfile'])->name('sponsor.update-profile');
    });
    Route::post('/financing-program/send-message', [FinancingProgramController::class, 'sendMessage'])->name('user.financing-program.send-message');
    Route::post('/contact-for-rates/send-message', [ContactForRateController::class, 'sendMessage'])->name('user.contact-for-rates.send-message');
    Route::post('/rates/send-message', [RatesSettingController::class, 'sendMessage'])->name('user.rates.send-message');
    Route::post('/scam-alert/send-message', [ScamAlertController::class, 'sendMessage'])->name('user.scam-alert.send-message');
    Route::post('/success-stories/send-message', [SuccessStoriesSettingController::class, 'sendMessage'])->name('user.success-stories.send-message');
    Route::post('/testimonial/send-message', [TestimonialSettingController::class, 'sendMessage'])->name('user.testimonial.send-message');
    Route::post('/faq-exporter/send-message', [FaqExporterController::class, 'sendMessage'])->name('user.faq-exporter.send-message');
    Route::post('/faq-importer/send-message', [FaqImporterController::class, 'sendMessage'])->name('user.faq-importer.send-message');
    Route::post('/sponsor/send-message', [SponsorController::class, 'sendMessage'])->name('user.sponsor.send-message');
    Route::post('/contact/send-message', [ContactUsController::class, 'sendMessage'])->name('user.contact-us.send-message');
    Route::post('/comments/send-message', [CommentsController::class, 'sendMessage'])->name('user.comments.send-message');
    Route::post('/info-letter/send-message', [InfoLetterController::class, 'sendMessage'])->name('user.info-letter.send-message');
    Route::get('/{abbreviation?}/search', [SearchController::class, 'index'])->name('user.search.index')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::post('/remove-exports-from-search', [SearchController::class, 'removeExportsFromSearch'])->name('user.search.removeExportsFromSearch')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/advance-search', [SearchController::class, 'advanceSearch'])->name('user.search.advanceSearch')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/i2b-search', [SearchController::class, 'i2BSearch'])->name('user.search.i2BSearch')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/event-search', [SearchController::class, 'eventSearch'])->name('user.search.eventSearch')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());

    Route::group(['prefix' => 'pages'], function () {
        Route::get('/how-these-business-categories-came-about', function () {
            return view('front.pages.how-these-business-categories-came-about');
        })->name('web.pages.how-these-business-categories-came-about');
    });

    // Articles pages (frontend)
    Route::get('/{abbreviation?}/articles', [ArticlePageController::class, 'index'])->name('web.articles.index')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());
    Route::get('/{abbreviation?}/articles/{slug}', [ArticlePageController::class, 'show'])->name('web.articles.show')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());

    

    Route::group(['prefix' => 'user', 'middleware' => ['auth.user']], function () {
        Route::post('/login', [SignupController::class, 'login'])->name('web.user.login');
    });
    Route::post('/user/reactive-customer-account', [SignupController::class, 'reactiveCustomerAccount'])->name('web.user.reactive-customer-account');
    Route::get('/{abbreviation?}/user/review-confirmation', [PaymentController::class, 'index'])->name('user.payment.index')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray())->middleware('auth.user');


    Route::group(['prefix' => '{abbreviation?}/user', 'middleware' => ['auth.user']], function () {
        Route::get('/create-business-profile', [AccountSettingController::class, 'createBusinessProfile'])->name('user.create-business-profile');
        Route::get('/profile-settings', [AccountSettingController::class, 'index'])->name('user.profile-settings.index');
        Route::get('/sponsor-settings', [AccountSettingController::class, 'sponsorIndex'])->name('user.sponsor-settings.index');
        Route::get('/sponsor-settings/add', [AccountSettingController::class, 'sponsorAdd'])->name('user.sponsor-settings.add');
        Route::get('/sponsor-settings/{id}', [AccountSettingController::class, 'sponsorEdit'])->name('user.sponsor-settings.edit');
        Route::get('/media-setting', [AccountSettingController::class, 'mediaSettingView'])->name('user.media-setting.index');
        Route::get('/buissness-settings', [AccountSettingController::class, 'buissnessSettingView'])->name('user.buissness-settings.index');
        Route::get('/social-media-settings', [AccountSettingController::class, 'socialMediaSettingView'])->name('user.social-media-settings.index');
    })->whereIn('abbreviation', Language::pluck('abbreviation')->toArray());

    Route::get('/get-profile-packages', [HelperController::class, 'getProfilePackages']);
    Route::get('/set-language/{language}', [HelperController::class, 'setLanguage'])->name('web.set-lang');
    Route::get('/{language}/become-sponser',[BannerController::class,'becomeSponsor'])->name('web.become-sponsor');

    Route::get('sponsers',[BannerController::class,'getBannerListingSetting']);

    Route::name('web.')->group(function () {
        Route::apiResource('events', AdminEventController::class);
    });

    Route::get('/get-registration-packages', [HelperController::class, 'getRegistrationPackages']);
    Route::get('/get-coffee-wall-packages', [HelperController::class, 'getCoffeeWallPackages']);
    Route::get('/get-coffee-wall-beneficiaries', [HelperController::class, 'getCoffeeWallBeneficiaries']);
    Route::get('/get-coffee-wall-faqs', [HelperController::class, 'getCoffeeWallFaqs']);
    Route::post('/book-a-stand', [EventController::class, 'bookAStand'])->name('user.event.book-a-stand');
    Route::post('/process-payment', [HelperController::class, 'processPayment']);
    Route::post('/process-payment/{id}', [HelperController::class, 'editProcessPayment']);
    Route::post('/process-registration-payment', [PaymentController::class, 'processRegistrationPayment']);
    Route::post('/process-upgrade-account', [PaymentController::class, 'processUpgradeAccount']);
    Route::post('/process-i2b-package-payment', [PaymentController::class, 'processI2bPackagePayment']);
    Route::post('/save-inquiry', [InquiryController::class, 'savePremiumInquiry']);
    Route::post('/save-package-inquiry', [InquiryController::class, 'savePackageInquiry']);

    Route::group(['prefix' => 'media'], function () {
        Route::post('/process', [MediaController::class, 'process']);
        Route::post('/revert', [MediaController::class, 'revert']);
        Route::get('/load', [MediaController::class, 'load']);
        Route::post('image_again_upload', [MediaController::class, 'uploadImage']);
    });

    Route::get('/{abbreviation?}/coffee-on-the-wall', [HomeController::class, 'coffeeOnWall'])->name('coffee_on_wall');
    Route::post('/coffee-on-the-wall-store', [HomeController::class, 'coffeeOnWallStore'])->name('coffee_on_wall.store');

    Route::get('/update-new-user-status/{email}/{id}', [SignupController::class, 'updateNewUserStatus'])->name('front.update-new-user-status');
    Route::get('/customer-verify-email/{email}/{id}', [SignupController::class, 'customerVerifyEmail'])->name('front.customer-verify-email');
    Route::get('/confirm-unsubscribe', [HelperController::class, 'confirmUnsubscribe'])->name('front.confirm-unsubscribe');
    Route::post('/confirm-unsubscribe', [HelperController::class, 'unsubscribeInfoLetter'])->name('front.unsubscribe-info-letter');
    Route::get('/confirm-unsubscribe-holiday', [HelperController::class, 'confirmUnsubscribeHoliday'])->name('front.confirm-unsubscribe-holiday');
    Route::post('/unsubscribe-holiday', [HelperController::class, 'unsubscribeHoliday'])->name('front.unsubscribe-holiday');
    Route::get('/customer-reactive-email/{email}/{id}', [SignupController::class, 'customerReactiveEmail'])->name('front.customer-reactive-email');
    Route::post('/update-customer-reactive-email', [SignupController::class, 'updateCustomerReactiveEmail'])->name('front.update-customer-reactive-email');
    // Route::get('/{slug?}', [HomeController::class, 'index'])->name('front.index');
    Route::get('/{abbreviation?}/{slug?}', [HomeController::class, 'index_abbreviation'])->name('front.index')->whereIn('abbreviation', Language::pluck('abbreviation')->toArray())->middleware('auth.user');
    Route::get('/clear-cache', function () {
        Cache::flush();
    });
    Route::get('/test-email', function () {
        $data = [
            "company_name" => "Xelent Solutions",
            "name" => "Umar aslam",
            "email" => "umaraslam1163@gmail.com",
            "country" => "Pakistan",
        ];

        return new \App\Mail\InfoLetterMail($data);
    });
});
