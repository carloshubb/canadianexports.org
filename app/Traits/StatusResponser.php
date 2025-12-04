<?php

namespace App\Traits;

trait StatusResponser
{

    protected function successResponse($data, $message = null, $html = '')
    {
        return array(
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
            'html' => $html,
        );
    }

    protected function errorResponse($message = null, $data = '')
    {
        if ($message == null) {
            $message = 'Something went wrong, please try again.';
        }
        return array(
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        );
    }

    protected function apiSuccessResponse($data, $message = null, $code = 200)
    {
        return ($data)
            ->additional([
                'status' => 'Success',
                'message' => $message,
                'status_code' => $code,
            ]);
    }

    protected function apiErrorResponse($message = null, $code = 500, $data = null)
    {
        if ($message == null) {
            $general_messages = getStaticTranslationByKey(null, 'general_messages', ['message_1']);
            $message_1 = isset($general_messages['message_1']) ? $general_messages['message_1'] : '';
            $message = $message_1;
        }
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }


    protected function redirectMethod($redirectUrl, $data, $editMethod = '')
    {
        if (is_array($data) && $data['status'] == 'Success') {
            if ($editMethod != '')
                return redirect($redirectUrl . '/' . $data['data'] . '/edit')->with('message', $data['message']);
            return redirect($redirectUrl)->with('message', $data['message']);
        }
        return $data;
    }
}
