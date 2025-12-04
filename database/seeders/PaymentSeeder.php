<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use App\Services\PaypalService;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $product = $stripe->products->create([
            'name' => 'Free packages',
        ]);
        GeneralSetting::where('key', 'stripe_free_product')->where('type', 'stripe_config')->update([
            'value' => $product->id
        ]);

        $product = $stripe->products->create([
            'name' => 'Featured packages',
        ]);
        GeneralSetting::where('key', 'stripe_featured_product')->where('type', 'stripe_config')->update([
            'value' => $product->id
        ]);

        $product = $stripe->products->create([
            'name' => 'Premium packages',
        ]);
        GeneralSetting::where('key', 'stripe_premium_product')->where('type', 'stripe_config')->update([
            'value' => $product->id
        ]);

        $product = $stripe->products->create([
            'name' => 'Pay to go',
        ]);
        GeneralSetting::where('key', 'stripe_pay_to_go_product')->where('type', 'stripe_config')->update([
            'value' => $product->id
        ]);


        if (app()->environment('production')) {
            $stripe->webhookEndpoints->create([
                'url' => route('stripe.webhook'),
                'enabled_events' => [
                    'customer.subscription.created',
                    'customer.subscription.deleted',
                    'customer.subscription.trial_will_end',
                ],
            ]);
        }
        
        $paypal = new PaypalService();

        GeneralSetting::where('type', 'paypal_config')->where('key', 'paypal_free_product')->update([
            'value' => $paypal->createProduct( [
                'name' => 'Free',
                'type' => 'SERVICE',
                'description' => 'This is a Free product.',
                'category' => 'SOFTWARE',
            ]),
        ]);

        GeneralSetting::where('type', 'paypal_config')->where('key', 'paypal_featured_product')->update([
            'value' => $paypal->createProduct( [
                'name' => 'Featured',
                'type' => 'SERVICE',
                'description' => 'This is a Featured product.',
                'category' => 'SOFTWARE',
            ]),
        ]);

        GeneralSetting::where('type', 'paypal_config')->where('key', 'paypal_premium_product')->update([
            'value' => $paypal->createProduct( [
                'name' => 'Premium',
                'type' => 'SERVICE',
                'description' => 'This is a Premium product.',
                'category' => 'SOFTWARE',
            ]),
        ]);

        GeneralSetting::where('type', 'paypal_config')->where('key', 'paypal_pay_to_go_product')->update([
            'value' => $paypal->createProduct( [
                'name' => 'Pay as you go',
                'type' => 'SERVICE',
                'description' => 'This is a Pay as you go product.',
                'category' => 'SOFTWARE',
            ]),
        ]);




    }
}
