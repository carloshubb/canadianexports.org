<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RecaptchaController extends Controller
{
    use StatusResponser;

    public function verifyRecaptcha(Request $request)
    {
        return $this->successResponse(['score' => 1], "reCAPTCHA verification successful");

        $secretKey = env('reCAPTCHA_secret_key');

        $client = new Client();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $secretKey,
                'response' => $request->input('token'),
            ],
        ]);

        
        $body = json_decode((string) $response->getBody());

        if ($body->success) {
            $score = $body->score;
            if ($score >= 0.5) {
                return $this->successResponse(['score' => $score], "reCAPTCHA verification successful");
            } else {
                $general_messages = getStaticTranslationByKey(null, 'general_messages', ['message_26']);
                $message_26 = isset($general_messages['message_26']) ? $general_messages['message_26'] : '';
                return $this->errorResponse($message_26);
            }
        }
        return $this->errorResponse("reCAPTCHA verification failed");
    }
}
