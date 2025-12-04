<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\BookingStandMail;
use App\Models\Event;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    use StatusResponser;

    public function show($abbreviation, $id)
    {
        updateLangByAbber($abbreviation);
        $defaultLang = getDefaultLanguage(true);
        $event = Event::with(['eventDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->with(['eventMedia.media', 'eventContacts'])->whereId($id)->firstOrFail();
        return view('web.event.show', compact('event'));
    }

    public function bookAStand(Request $request)
    {
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string'],
            'event_id' => ['required', 'exists:events,id'],
        ];
        $defaultLang = getDefaultLanguage(true);
        $event_detail_setting = getI2bModalSetting($defaultLang, ['event_detail_setting']);
        $niceNames = [];
        if ($event_detail_setting) {
            App::setLocale($defaultLang->abbreviation);
            $niceNames['name'] = isset($event_detail_setting['book_a_stand_modal_name_error']) ? $event_detail_setting['book_a_stand_modal_name_error'] : '';
            $niceNames['email'] = isset($event_detail_setting['book_a_stand_modal_email_error']) ? $event_detail_setting['book_a_stand_modal_email_error'] : '';
            $niceNames['message'] = isset($event_detail_setting['book_a_stand_modal_message_error']) ? $event_detail_setting['book_a_stand_modal_message_error'] : '';
        }
        $data = $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );
        $event = Event::whereId($request->event_id)->first();
        if ($event && $event->contact_email) {
            $data = ['event' => $event, 'data' => $data];
            Mail::to($event->contact_email)->send(new BookingStandMail($data));
        }
        $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_18']);
        $message_18 = isset($general_messages['message_18']) ? $general_messages['message_18'] : '';

        return $this->successResponse([], $message_18);
    }
}
