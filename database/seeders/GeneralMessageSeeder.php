<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Seeder;

class GeneralMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = getDefaultLanguage();
        $result = StaticTranslation::where('type', 'general_messages')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Success & error messages',
                'type' => 'general_messages',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_1')->first();
        $message_1_text = 'Something went wrong message';
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_1',
                'display_text' => $message_1_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_1_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_2')->first();
        $message_2_text = 'Already selected package message';
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_2',
                'display_text' => $message_2_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_2_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_3')->first();
        $message_3_text = 'Package expired message';
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_3',
                'display_text' => $message_3_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_3_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_4')->first();
        $message_4_text = 'Please sign in to proceed message';
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_4',
                'display_text' => $message_4_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_4_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_5')->first();
        $message_5_text = 'Please complete payment to process message';
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_5',
                'display_text' => $message_5_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_5_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_6')->first();
        $message_6_text = 'Your payment status is pending message';
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_6',
                'display_text' => $message_6_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_6_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_7')->first();
        $message_7_text = "User's status is inactive message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_7',
                'display_text' => $message_7_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_7_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_8')->first();
        $message_8_text = "Email limit exceeded message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_8',
                'display_text' => $message_8_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_8_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_9')->first();
        $message_9_text = "Bussiness profile updated message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_9',
                'display_text' => $message_9_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_9_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_10')->first();
        $message_10_text = "Media updated message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_10',
                'display_text' => $message_10_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_10_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_11')->first();
        $message_11_text = "Account setting updated message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_11',
                'display_text' => $message_11_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_11_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_12')->first();
        $message_12_text = "Social media updated message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_12',
                'display_text' => $message_12_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_12_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_13')->first();
        $message_13_text = "Subscription canceled message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_13',
                'display_text' => $message_13_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_13_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_14')->first();
        $message_14_text = "Subscription resumed message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_14',
                'display_text' => $message_14_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_14_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_15')->first();
        $message_15_text = "Subscription updated message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_15',
                'display_text' => $message_15_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_15_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_16')->delete();

        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_16')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'message_16',
        //         'display_text' => "Thank you for contacting us. If you have requested a response, we will do our best to respond to you within 2 business days.",
        //     ]);
        // }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_17')->first();
        $message_17_text = "Contact exporter success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_17',
                'display_text' => $message_17_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_17_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_18')->first();
        $message_18_text = "Request to book a stand message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_18',
                'display_text' => $message_18_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_18_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_19')->first();
        $message_19_text = "Package subscribed message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_19',
                'display_text' => $message_19_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_19_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_19_a')->first();
        $message_19_a_text = "Upgrade package message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_19_a',
                'display_text' => $message_19_a_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_19_a_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_20')->first();
        $message_20_text = "Account created message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_20',
                'display_text' => $message_20_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_20_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_21')->first();
        $message_21_text = "Event created message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_21',
                'display_text' => $message_21_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_21_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_22')->first();
        $message_22_text = "Inquiry to buy message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_22',
                'display_text' => $message_22_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_22_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_23')->first();
        $message_23_text = "Account created message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_23',
                'display_text' => $message_23_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_23_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_24')->first();
        $message_24_text = "Account closed message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_24',
                'display_text' => $message_24_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_24_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_25')->first();
        $message_25_text = "Wrong credentials message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_25',
                'display_text' => $message_25_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_25_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_26')->first();
        $message_26_text = "Not a bot message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_26',
                'display_text' => $message_26_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_26_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_27')->first();
        $message_27_text = "Can't find a user with email address message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_27',
                'display_text' => $message_27_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_27_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_28')->first();
        $message_28_text = "Limit of selection to a maximum of 3 business categories message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_28',
                'display_text' => $message_28_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_28_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_29')->first();
        $message_29_text = "Password doesn't match message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_29',
                'display_text' => $message_29_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_29_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_30')->first();
        $message_30_text = "Are you sure text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_30',
                'display_text' => $message_30_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_30_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_31')->first();
        $message_31_text = "You won't be able to revert this text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_31',
                'display_text' => $message_31_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_31_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_32')->first();
        $message_32_text = "Yes, delete it text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_32',
                'display_text' => $message_32_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_32_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_33')->first();
        $message_33_text = "Cancel button text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_33',
                'display_text' => $message_33_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_33_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_34')->first();
        $message_34_text = "You haven't yet verified your email address message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_34',
                'display_text' => $message_34_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_34_text,
            ]);
        }

        StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_35')->delete();
        $message_35_text =

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_35_a')->first();
        $message_35_a_text = "Pre resend verification email text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_35_a',
                'display_text' => $message_35_a_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_35_a_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_35_b')->first();
        $message_35_b_text = "Resend verification email text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_35_b',
                'display_text' => $message_35_b_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_35_b_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_36')->first();
        $message_36_text = "Password reset token is invalid message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_36',
                'display_text' => $message_36_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_36_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_37')->first();
        $message_37_text = "User registered sucessfully message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_37',
                'display_text' => $message_37_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_37_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_38')->first();
        $message_38_text = "Subscription completed message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_38',
                'display_text' => $message_38_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_38_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_39')->first();
        $message_39_text = "Payment completed message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_39',
                'display_text' => $message_39_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_39_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_40')->first();
        $message_40_text = "Subscription canceled message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_40',
                'display_text' => $message_40_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_40_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_41')->first();
        $message_41_text = "Package upgrade request cancelled message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_41',
                'display_text' => $message_41_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_41_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_42')->first();
        $message_42_text = "Payment request cancelled message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_42',
                'display_text' => $message_42_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_42_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_43')->first();
        $message_43_text = "Account closed message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_43',
                'display_text' => $message_43_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_43_text,
            ]);
        }

        StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_44')->delete();
        $message_44_text =

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_44_a')->first();
        $message_44_a_text = "Pre reactive your account text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_44_a',
                'display_text' => $message_44_a_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_44_a_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_44_b')->first();
        $message_44_b_text = "Reactive your account text";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_44_b',
                'display_text' => $message_44_b_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_44_b_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_45')->first();
        $message_45_text = "Info letter success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_45',
                'display_text' => $message_45_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_45_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_46')->first();
        $message_46_text = "Become sponsor success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_46',
                'display_text' => $message_46_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_46_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_47')->first();
        $message_47_text = "Feedback form success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_47',
                'display_text' => $message_47_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_47_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_48')->first();
        $message_48_text = "Contact us success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_48',
                'display_text' => $message_48_text,
            ]);
        }
        else{
            $staticTranslationDetail->update([
                'display_text' => $message_48_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_49')->first();
        $message_49_text = "Financing program success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_49',
                'display_text' => $message_49_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_50')->first();
        $message_50_text = "Reset password success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_50',
                'display_text' => $message_50_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_51')->first();
        $message_51_text = "Sent reset password email message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_51',
                'display_text' => $message_51_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_52')->first();
        $message_52_text = "Resent Verify email success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_52',
                'display_text' => $message_52_text,
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_53')->first();
        $message_53_text = "Password do not match message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_53',
                'display_text' => $message_53_text,
            ]);
        }


        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_54')->first();
        $message_54_text = "Contact for current rates success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_54',
                'display_text' => $message_54_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_55')->first();
        $message_55_text = "Scam Alert success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_55',
                'display_text' => $message_55_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_56')->first();
        $message_56_text = "Faq Importer success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_56',
                'display_text' => $message_56_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_57')->first();
        $message_57_text = "Faq Exporter success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_57',
                'display_text' => $message_57_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_58')->first();
        $message_58_text = "Success Stories success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_58',
                'display_text' => $message_58_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_59')->first();
        $message_59_text = "Testimonial success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_59',
                'display_text' => $message_59_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_60')->first();
        $message_60_text = "Rates and Information success message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_60',
                'display_text' => $message_60_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_61')->first();
        $message_61_text = "Invalid email message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_61',
                'display_text' => $message_61_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_62')->first();
        $message_62_text = "Events Limit message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_62',
                'display_text' => $message_62_text,
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_65')->first();
        $message_65_text = "Unsubscribe message";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_65',
                'display_text' => $message_65_text,
            ]);
        }
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_64')->first();
        // $message_64_text = "Holiday Email Unsubsribe message";
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'message_64',
        //         'display_text' => $message_64_text,
        //     ]);
        // }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'message_66')->first();
        $message_66_text = "In sponsor user, add restriction on add event button & see all event on home page";
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'message_66',
                'display_text' => $message_66_text,
            ]);
        }
    }
}
