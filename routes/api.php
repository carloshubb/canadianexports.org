<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WebinarController;
use App\Http\Controllers\WebinarRegistrationController;
use App\Http\Controllers\WebinarQuestionController;
use App\Http\Controllers\WebinarMessageController;
use App\Http\Controllers\WebinarChatController;
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
    
    // Q&A Admin routes
    Route::get('webinars/{webinarId}/questions', [WebinarQuestionController::class, 'adminIndex']);
    Route::post('webinar-questions/{questionId}/approve', [WebinarQuestionController::class, 'approve']);
    Route::post('webinar-questions/{questionId}/reject', [WebinarQuestionController::class, 'reject']);
    Route::post('webinar-questions/{questionId}/answer', [WebinarQuestionController::class, 'answer']);
    Route::post('webinar-questions/{questionId}/mark-answered', [WebinarQuestionController::class, 'markAnswered']);
    Route::post('webinar-questions/{questionId}/toggle-featured', [WebinarQuestionController::class, 'toggleFeatured']);
    Route::delete('webinar-questions/{questionId}', [WebinarQuestionController::class, 'destroy']);
    
    // Private Messages Admin routes
    Route::get('webinars/{webinarId}/messages', [WebinarMessageController::class, 'adminIndex']);
    Route::get('webinars/{webinarId}/messages/all', [WebinarMessageController::class, 'adminAllMessages']);
    Route::get('webinars/{webinarId}/messages/{registrationId}', [WebinarMessageController::class, 'adminConversation']);
    Route::post('webinars/{webinarId}/messages/{registrationId}/reply', [WebinarMessageController::class, 'reply']);
    Route::delete('webinars/{webinarId}/messages/{messageId}', [WebinarMessageController::class, 'adminDelete']);
    
    // Chat Admin routes
    Route::get('webinars/{webinarId}/chat', [WebinarChatController::class, 'adminIndex']);
    Route::post('webinars/{webinarId}/chat', [WebinarChatController::class, 'adminSend']);
    Route::delete('webinars/{webinarId}/chat/{messageId}', [WebinarChatController::class, 'adminDelete']);
});

// Public routes for webinar registration
Route::prefix('webinars')->group(function () {
    Route::post('{webinar}/register', [WebinarRegistrationController::class, 'register']);
    Route::post('{webinar}/cancel', [WebinarRegistrationController::class, 'cancel']);
    Route::post('{webinar}/check-registration', [WebinarRegistrationController::class, 'checkRegistration']);
    
    // Public Q&A routes
    Route::get('{webinarId}/questions', [WebinarQuestionController::class, 'index']);
    Route::post('{webinarId}/questions', [WebinarQuestionController::class, 'store']);
    Route::post('{webinarId}/questions/{questionId}/upvote', [WebinarQuestionController::class, 'upvote']);
    Route::delete('{webinarId}/questions/{questionId}/upvote', [WebinarQuestionController::class, 'removeUpvote']);
    Route::post('{webinarId}/my-questions', [WebinarQuestionController::class, 'myQuestions']);
    
    // Public Private Messaging routes
    Route::post('{webinarId}/messages', [WebinarMessageController::class, 'send']);
    Route::post('{webinarId}/messages/conversation', [WebinarMessageController::class, 'getConversation']);
    Route::delete('{webinarId}/messages/{messageId}', [WebinarMessageController::class, 'deleteOwn']);
    
    // Public Chat routes
    Route::get('{webinarId}/chat', [WebinarChatController::class, 'index']);
    Route::get('{webinarId}/chat/new/{lastMessageId}', [WebinarChatController::class, 'getNew']);
    Route::post('{webinarId}/chat', [WebinarChatController::class, 'send']);
});

require_once('web-api.php');
require_once('admin.php');

