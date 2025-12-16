<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WebinarController;
use App\Http\Controllers\WebinarRegistrationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Admin routes (protected with auth middleware)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::apiResource('webinars', WebinarController::class);
    Route::get('webinars/{id}/registrations', [WebinarController::class, 'registrations']);
    Route::patch('webinar-registrations/{id}/attended', [WebinarRegistrationController::class, 'markAttended']);
    Route::patch('webinar-registrations/{id}/cancel', [WebinarRegistrationController::class, 'cancelAdmin']);
    
    // For managing registrations
    Route::patch('webinar-registrations/{id}/attended', [WebinarRegistrationController::class, 'markAttended']);
    Route::patch('webinar-registrations/{id}/cancel', [WebinarRegistrationController::class, 'cancelAdmin']);
});

// Public routes for webinar registration
Route::prefix('webinars')->group(function () {
    Route::post('{webinar}/register', [WebinarRegistrationController::class, 'register']);
    Route::post('{webinar}/cancel', [WebinarRegistrationController::class, 'cancel']);
    Route::post('{webinar}/check-registration', [WebinarRegistrationController::class, 'checkRegistration']);
});

require_once('web-api.php');
require_once('admin.php');

