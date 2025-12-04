<?php

use App\Http\Controllers\Api\Admin\{
    AboutUsPageSettingController,
    SponsorPageSettingController,
    AdminAccountController,
    AdvertiserFormController,
    AdvertiserSettingController,
    AuthController,
    BannerController,
    BecomeSponsorSettingController,
    BillingPeriodDiscountController,
    BusinessCategoryController,
    BusinessDirectoryController,
    BusinessProfileController,
    BusinessProfileStatsController,
    CloseAccountSettingController,
    CoffeeWalletsController,
    CoffeeWallPackageController,
    CoffeeWallBeneficiaryController,
    CoffeeWallFaqController,
    SponsorAmountController,
    CommentsSettingController,
    ContactFormController,
    ContactForRateSettingController,
    ContactUsSettingController,
    ScamAlertSettingController,
    TestimonialSettingController,
    SuccessStoriesSettingController,
    FaqExporterSettingController,
    FaqImporterSettingController,
    DashboardController,
    EmailSettinController,
    ErrorController,
    EventController,
    FooterSettingController,
    HomePageSettingController,
    I2bController,
    InfoLetterSettingController,
    IssueController,
    LanguageController,
    EventSignupSettingController,
    EventCreateSettingController,
    EventListingSettingController,
    SponserListingSettingController,
    SponsorController,
    ExportingFairController,
    ExportingFairSettingController,
    GeneralSettingController,
    LoginPageSettingController,
    MediaController,
    MenuController,
    RegistrationPackageController,
    PackageController,
    PageController,
    RegPageSettingController,
    TestimonialController,
    FinancingProgramController,
    SuccessStoriesController,
    FaqController,
    FinancingProgramSettingController,
    ForgetPageSettingController,
    HolidayEmailController,
    I2BSettingController,
    EventSettingController,
    InfoLetterController,
    OneMoreThingController,
    OneMoreThingSettingController,
    OnlineBusinessDirectorySettingController,
    RatesSettingController,
    StaticTranslationController,
    UserController,
    WidgetController,
    ArticlesController,
    ArticleSectionsController
};
use App\Http\Resources\Admin\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\EmailTemplateController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        $user = new UserResource($request->user());
        return response()->json(['data' => $user, 'status' => 'Success']);
    });
    Route::post('send-email', [InfoLetterSettingController::class, 'sendEmail']);
    Route::post('send-email/stats', [BusinessProfileStatsController::class, 'sendEmails']);
    Route::post('financingPrograms/send-email', [FinancingProgramController::class, 'sendEmail']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::apiResource('holiday-emails', HolidayEmailController::class);
    Route::apiResource('banners', BannerController::class);
    Route::apiResource('sponsors', SponsorController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::apiResource('business_directories', BusinessDirectoryController::class);
    Route::apiResource('testimonials', TestimonialController::class);
    Route::put('testimonials/{id}/status', [TestimonialController::class, 'updateStatus']);
    Route::apiResource('successStories', SuccessStoriesController::class);
    Route::put('successStories/{id}/status', [SuccessStoriesController::class, 'updateStatus']);
    Route::apiResource('financingPrograms', FinancingProgramController::class);
    Route::apiResource('faqs', FaqController::class);
    Route::apiResource('widgets', WidgetController::class);
    Route::get('email-setting', [EmailSettinController::class, 'index']);
    Route::post('email-setting', [EmailSettinController::class, 'store']);
    Route::post('update-activation-status', [UserController::class, 'updateActivationStatus']);
    Route::get('users-with-no-profile', [UserController::class, 'usersWithNoProfile']);
    Route::post('send-welcome-email', [UserController::class, 'sendWelcomeEmail']);
    Route::post('send-welcome', [BusinessProfileController::class, 'welcomeEmail']);
    Route::apiResource('business-profiles', BusinessProfileController::class)->except('update');
    Route::post('/business-profiles/{id}', [BusinessProfileController::class, 'update']);
    Route::post('import-business-profiles', [BusinessProfileController::class, 'importBusinessProfiles']);
    Route::post('import-business-directory', [BusinessDirectoryController::class, 'importBusinessDirectory']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('admin-accounts', AdminAccountController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('sponsers', BannerController::class);
    Route::apiResource('one-more-thing', OneMoreThingController::class);
    Route::apiResource('exporting-fairs', ExportingFairController::class);
    Route::apiResource('footer-setting', FooterSettingController::class);
    Route::apiResource('issues', IssueController::class);
    Route::apiResource('languages', LanguageController::class);
    Route::apiResource('menus', MenuController::class);
    Route::post('/menus/{id}/menu-builder', [MenuController::class, 'updateMenuBuilder']);
    Route::apiResource('business-categories', BusinessCategoryController::class);
    Route::apiResource('i2b', I2bController::class);
    Route::post('import-i2b', [I2bController::class, 'importI2b']);
    Route::apiResource('coffee-wall-packages', CoffeeWallPackageController::class);
    Route::apiResource('coffee-wall-beneficiaries', CoffeeWallBeneficiaryController::class);
    Route::apiResource('coffee-wall-faqs', CoffeeWallFaqController::class);
    Route::get('sponsor-amounts-frequencies', [SponsorAmountController::class, 'getFrequencies']);
    Route::apiResource('sponsor-amounts', SponsorAmountController::class);
    Route::post('sponsor-amounts/batch-update', [SponsorAmountController::class, 'batchUpdate']);
    Route::apiResource('registration-packages', RegistrationPackageController::class);
    Route::apiResource('packages', PackageController::class);
    Route::get('billing-period-discounts', [BillingPeriodDiscountController::class, 'index']);
    Route::put('billing-period-discounts/{id}', [BillingPeriodDiscountController::class, 'update']);
    Route::post('billing-period-discounts/batch-update', [BillingPeriodDiscountController::class, 'batchUpdate']);
    Route::apiResource('pages', PageController::class);
    Route::post('password-verification', [LoginPageSettingController::class, 'passwordVerification']);
    Route::apiResource('general-setting', GeneralSettingController::class)->only(['index', 'store']);
    Route::post('meta-tags-setting', [GeneralSettingController::class, 'saveMetaTagsSetting']);
    Route::apiResource('static-translation', StaticTranslationController::class)->only(['index', 'store']);
    Route::get('/advertiser-forms', [AdvertiserFormController::class, 'index']);
    Route::get('/coffee-wallets', [CoffeeWalletsController::class, 'index']);
    Route::get('/business-profile-stats', [BusinessProfileStatsController::class, 'index']);
    Route::get('/business-profile-stats/{id}', [BusinessProfileStatsController::class, 'show']);
    Route::get('/info-letter-forms', [InfoLetterController::class, 'index']);
    Route::get('/contact-forms', [ContactFormController::class, 'index']);
    Route::get('/registration-page-setting', [RegPageSettingController::class, 'show']);
    Route::get('/event-create-setting', [EventCreateSettingController::class, 'show']);
    Route::get('/event-signup-setting', [EventSignupSettingController::class, 'show']);
    Route::get('/login-page-setting', [LoginPageSettingController::class, 'show']);
    Route::get('/home-page-setting', [HomePageSettingController::class, 'show']);
    Route::get('/sponsor-page-setting', [SponsorPageSettingController::class, 'show']);
    Route::get('/about-us-page-setting', [AboutUsPageSettingController::class, 'show']);
    Route::get('/rates-setting', [RatesSettingController::class, 'show']);
    Route::get('/contact-us-setting', [ContactUsSettingController::class, 'show']);
    Route::get('/i2b-setting', [I2BSettingController::class, 'show']);
    Route::get('/event-setting', [EventSettingController::class, 'show']);
    Route::get('/comments-setting', [CommentsSettingController::class, 'show']);
    Route::get('/close-account-setting', [CloseAccountSettingController::class, 'show']);
    Route::get('/event-listing-setting', [EventListingSettingController::class, 'show']);
    Route::get('/sponser-listing-setting', [SponserListingSettingController::class, 'show']);
    Route::get('/dashboard-stats', [DashboardController::class, 'show']);
    Route::get('/forget-page-setting', [ForgetPageSettingController::class, 'show']);
    Route::get('/advertiser-setting', [AdvertiserSettingController::class, 'show']);
    Route::get('/become-sponsor-setting', [BecomeSponsorSettingController::class, 'show']);
    Route::get('/online-business-directory-setting', [OnlineBusinessDirectorySettingController::class, 'show']);
    Route::get('/financing-program-setting', [FinancingProgramSettingController::class, 'show']);
    Route::get('/contact-for-rate-setting', [ContactForRateSettingController::class, 'show']);
    Route::get('/scam-alert-setting', [ScamAlertSettingController::class, 'show']);
    Route::get('/testimonial-setting', [TestimonialSettingController::class, 'show']);
    Route::get('/success-stories-setting', [SuccessStoriesSettingController::class, 'show']);
    Route::get('/faq-exporter-setting', [FaqExporterSettingController::class, 'show']);
    Route::get('/faq-importer-setting', [FaqImporterSettingController::class, 'show']);
    Route::get('/one-more-thing-setting', [OneMoreThingSettingController::class, 'show']);
    Route::get('/exporting-fair-setting', [ExportingFairSettingController::class, 'show']);
    Route::get('/info-letter-setting', [InfoLetterSettingController::class, 'show']);
    Route::group(['prefix' => 'errors'], function () {
        Route::post('/', [ErrorController::class, 'update']);
        Route::get('/', [ErrorController::class, 'index']);
    });
    Route::group(['prefix' => 'media'], function () {
        Route::post('/process', [MediaController::class, 'process']);
        Route::post('/revert', [MediaController::class, 'revert']);
        Route::get('/load', [MediaController::class, 'load']);
        Route::post('image_again_upload', [MediaController::class, 'uploadImage']);
    });

    // Email Templates CRUD
    Route::apiResource('email-templates', EmailTemplateController::class);

    // Articles
    Route::apiResource('article-sections', ArticleSectionsController::class);
    Route::apiResource('articles', ArticlesController::class);
});
