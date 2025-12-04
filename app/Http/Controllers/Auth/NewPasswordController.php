<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use App\Mail\CustomerPasswordResetSuccessMail;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    // public function store(Request $request)
    // {
    //     $niceNames = [];
    //     $defaultLang = getDefaultLanguage(true);
    //     $reset_password_setting = getI2bModalSetting($defaultLang, ['reset_password_setting']);
    //     if ($reset_password_setting) {
    //         App::setLocale($defaultLang->abbreviation);
    //         $niceNames['email'] = isset($reset_password_setting['email_error_text']) ? $reset_password_setting['email_error_text'] : '';
    //         $niceNames['password'] = isset($reset_password_setting['password_error_text']) ? $reset_password_setting['password_error_text'] : '';
    //         $niceNames['password_confirmation'] = isset($reset_password_setting['confirm_password_error_text']) ? $reset_password_setting['confirm_password_error_text'] : '';
    //     }
    //     $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_29']);
    //     $message_29 = isset($general_messages['message_29']) ? $general_messages['message_29'] : '';
    //     $messages = [
    //         'password.confirmed' => $message_29
    //     ];
    //     $request->validate([
    //         'token' => ['required'],
    //         'email' => ['required', 'email'],
    //         'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()],
    //     ], $messages, $niceNames);

    //     $general_setting = getGeneralSettingByKey();

    //     $password_resets = DB::table('password_resets')->where('token', $request->token)->first();
    //     if (!$password_resets) {
    //         $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_36']);
    //         $message_36 = isset($general_messages['message_36']) ? $general_messages['message_36'] : '';

    //         return back()->withErrors(['email' => $message_36]);
    //     }

    //     // Here we will attempt to reset the user's password. If it is successful we
    //     // will update the password on an actual user model and persist it to the
    //     // database. Otherwise we will parse the error and return the response.
    //     // $status = Password::reset(
    //     //     $request->only('email', 'password', 'password_confirmation', 'token'),
    //     //     function ($user) use ($request) {
    //     //         $user->forceFill([
    //     //             'password' => Hash::make($request->password),
    //     //             'remember_token' => Str::random(60),
    //     //         ])->save();

    //     //         event(new PasswordReset($user));
    //     //     }
    //     // );
    //     if (isset($request->validity)) {
    //         $user = User::where('email', $password_resets->email)->first();
    //         if (!$user) {
    //             $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_27']);
    //             $message_27 = isset($general_messages['message_27']) ? $general_messages['message_27'] : '';

    //             return back()->withErrors(['email' => $message_27]);
    //         }
    //         if ($user) {
    //             $userUpdate = $user->update([
    //                 'password' => Hash::make($request->password)
    //             ]);
    //             if ($userUpdate) {
    //                 DB::table('password_resets')->where('token', $request->token)->delete();
    //                 event(new PasswordReset($user));
    //                 $redirect_url = route('front.index', $defaultLang->abbreviation);
    //                 $url = langBasedURL($defaultLang, $redirect_url);

    //                 $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_50']);
    //                 $message_50 = isset($general_messages['message_50']) ? $general_messages['message_50'] : '';


    //                 Session::flash('message', $message_50);
    //                 Session::flash('type', 'success');
    //                 return redirect($url);

    //                 // return Redirect::to(route('login'))->with('status', 'Your password has been reset successfully.');
    //             }
    //         }
    //     } else {
    //         $customer = Customer::where('email', $password_resets->email)->first();
    //         if (!$customer) {
    //             $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_27']);
    //             $message_27 = isset($general_messages['message_27']) ? $general_messages['message_27'] : '';

    //             return back()->withErrors(['email' => $message_27]);
    //         }
    //         if ($customer) {
    //             $customerUpdate = $customer->update([
    //                 'password' => Hash::make($request->password)
    //             ]);
    //             if ($customerUpdate) {
    //                 DB::table('password_resets')->where('token', $request->token)->delete();
    //                 event(new PasswordReset($customer));
    //                 $redirect_url = route('front.index', $defaultLang->abbreviation);
    //                 $url = langBasedURL($defaultLang, $redirect_url);

    //                 $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_50']);
    //                 $message_50 = isset($general_messages['message_50']) ? $general_messages['message_50'] : '';
    //                 Session::flash('message', $message_50);
    //                 Session::flash('type', 'success');
    //                 return redirect($url);

    //                 // $url = langBasedURL(null, $general_setting['user_signin_page']);
    //                 // return Redirect::to($url)->with('status', 'Your password has been reset successfully.');
    //             }
    //         }
    //     }
    // }
    public function store(Request $request)
    {
        $niceNames = [];
        $defaultLang = getDefaultLanguage(true);
        $reset_password_setting = getI2bModalSetting($defaultLang, ['reset_password_setting']);

        if ($reset_password_setting) {
            App::setLocale($defaultLang->abbreviation);
            $niceNames['email'] = $reset_password_setting['email_error_text'] ?? '';
            $niceNames['password'] = $reset_password_setting['password_error_text'] ?? '';
            $niceNames['password_confirmation'] = $reset_password_setting['confirm_password_error_text'] ?? '';
        }

        $general_messages = getStaticTranslationByKey($defaultLang ?? null, 'general_messages', ['message_29']);
        $message_29 = $general_messages['message_29'] ?? '';

        $messages = [
            'password.confirmed' => $message_29
        ];

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()],
        ], $messages, $niceNames);

        $password_resets = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$password_resets) {
            $general_messages = getStaticTranslationByKey($defaultLang ?? null, 'general_messages', ['message_36']);
            $message_36 = $general_messages['message_36'] ?? '';

            return back()->withErrors(['email' => $message_36]);
        }

        if (isset($request->validity)) {
            $user = User::where('email', $password_resets->email)->first();
            if (!$user) {
                $general_messages = getStaticTranslationByKey($defaultLang ?? null, 'general_messages', ['message_27']);
                $message_27 = $general_messages['message_27'] ?? '';

                return back()->withErrors(['email' => $message_27]);
            }

            $userUpdate = $user->update([
                'password' => Hash::make($request->password)
            ]);

            if ($userUpdate) {
                DB::table('password_resets')->where('token', $request->token)->delete();
                event(new PasswordReset($user));

                // Send password reset success email
                Mail::to($user->email)->send(new CustomerPasswordResetSuccessMail(['name' => $user->name, 'email' => $user->email]));

                Session::flash('message', 'Your password has been reset successfully.');
                Session::flash('type', 'success');
                return redirect()->route('front.index', $defaultLang->abbreviation);
            }
        } else {
            $customer = Customer::where('email', $password_resets->email)->first();
            if (!$customer) {
                $general_messages = getStaticTranslationByKey($defaultLang ?? null, 'general_messages', ['message_27']);
                $message_27 = $general_messages['message_27'] ?? '';

                return back()->withErrors(['email' => $message_27]);
            }

            $customerUpdate = $customer->update([
                'password' => Hash::make($request->password)
            ]);

            if ($customerUpdate) {
                DB::table('password_resets')->where('token', $request->token)->delete();
                event(new PasswordReset($customer));

                // Send password reset success email
                Mail::to($customer->email)->send(new CustomerPasswordResetSuccessMail(['name' => $customer->name, 'email' => $customer->email]));

                Session::flash('message', 'Your password has been reset successfully.');
                Session::flash('type', 'success');
                return redirect()->route('front.index', $defaultLang->abbreviation);
            }
        }
    }
}
