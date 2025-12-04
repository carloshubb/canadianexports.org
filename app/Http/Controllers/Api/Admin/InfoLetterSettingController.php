<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\InfoLetterSettingResource;
use App\Models\InfoLetterSetting;
use App\Traits\StatusResponser;
use Illuminate\Support\Facades\Mail;
use App\Mail\InfoLetterAdminMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InfoLetterSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $infoLetterSetting = InfoLetterSetting::query();

        if (isset($_GET['withInfoLetterSettingDetail']) && $_GET['withInfoLetterSettingDetail'] == '1') {
            $infoLetterSetting = $infoLetterSetting->with('infoLetterSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $infoLetterSetting = $infoLetterSetting->wherePageId($_GET['findByPageId']);
        }

        $infoLetterSetting = $infoLetterSetting->firstOrFail();

        return $this->successResponse(new InfoLetterSettingResource($infoLetterSetting), 'Data get successfully.');
    }
    //     public function sendEmail(Request $request)
    // {
    //     $recipients = json_decode($request->input('recipients'), true);
    //     $message = $request->input('message');
    //     $file = $request->file('file');

    //     foreach ($recipients as $email) {
    //         if($email){
    //             Mail::to($email)->send(new InfoLetterAdminMail($message, $file, $email));
    //         }
    //     }

    //     return response()->json(['status' => 'success', 'message' => 'Emails sent successfully.'], 200);
    // }
    public function sendEmail(Request $request)
    {
        $recipients = json_decode($request->input('recipients'), true);
        $message = $request->input('message');
        $file = $request->file('file');
        $sentCount = 0;
        $skippedCount = 0;

        Log::info('message', ['message' => $message]);
        foreach ($recipients as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skippedCount++;
                continue;
            }

            // Check if unsubscribed in either system
            $isUnsubscribed = \App\Models\InfoLetter::where('email', $email)
                ->where('is_subscribe', 0)
                ->exists() ||
                \App\Models\Customer::where('email', $email)
                ->where('is_subscribe', 0)
                ->exists();

            if ($isUnsubscribed) {
                $skippedCount++;
                continue;
            }

            // Check if subscribed in either system
            $isSubscribed = \App\Models\InfoLetter::where('email', $email)
                ->where('is_subscribe', 1)
                ->exists() ||
                \App\Models\Customer::where('email', $email)
                ->where('is_subscribe', 1)
                ->exists();

            if ($isSubscribed) {
                try {
                    Mail::to($email)->send(new InfoLetterAdminMail($message, $file, $email));
                    $sentCount++;
                } catch (\Exception $e) {
                    Log::error("Failed to send email to {$email}: " . $e->getMessage());
                    $skippedCount++;
                }
            } else {
                $skippedCount++;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => "Emails sent successfully. Sent: {$sentCount}, Skipped: {$skippedCount}",
            'data' => [
                'sent' => $sentCount,
                'skipped' => $skippedCount
            ]
        ], 200);
    }
}
