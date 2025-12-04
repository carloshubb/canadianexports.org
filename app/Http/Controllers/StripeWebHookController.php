<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Models\Customer;
use App\Models\Order;
use App\Services\PDFService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StripeWebHookController extends Controller
{


    public function index(Request $request)
    {

        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
        // Handle the event
        switch ($event->type) {
            case 'invoice.finalized':
                $paymentIntent = $event->data->object;
                $this->sendInvocie($paymentIntent);
            case 'customer.subscription.created':
                $paymentIntent = $event->data->object;
                $this->sendInvocie($paymentIntent);
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }


    protected function sendInvocie($paymentIntent)
    {
        $defaultLang = getDefaultLanguage();

        $customer = Customer::with(['registrationPackage.registrationPackageDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->with('customerProfile')->where('stripe_customer_id', $paymentIntent->customer)->firstOrFail();


        $packageName = isset($customer->registrationPackage->registrationPackageDetail[0]) ? $customer->registrationPackage->registrationPackageDetail[0]->name : $paymentIntent->items->data[0]->plan->nickname;

        // $packagePrice = isset($customer->registrationPackage->discount_price) ? $customer->registrationPackage->discount_price : (isset($customer->registrationPackage->price) ? $customer->registrationPackage->price : ($paymentIntent->items->data[0]->plan->amount) / 100);
        $package_expiry_date = date('Y-m-d');
        if ($customer->payment_frequency == 'monthly') {
            $packagePrice = $customer->registrationPackage->monthly_price;
            $packageValidity = '1 month';
            $package_expiry_date = date('Y-m-d', strtotime('+1 months'));

        } else if ($customer->payment_frequency == 'quarterly') {
            $packagePrice = $customer->registrationPackage->quarterly_price * 3;
            $packageValidity = '3 months';
            $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
        } else if ($customer->payment_frequency == 'semi_annually') {
            $packagePrice = $customer->registrationPackage->semi_annually_price * 6;
            $packageValidity = '6 months';
            $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
        } else if ($customer->payment_frequency == 'annually') {
            $packagePrice = $customer->registrationPackage->annually_price * 12;
            $packageValidity = '12 months';
            $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
        }

        $packageValidity = isset($customer->registrationPackage) ? $customer->registrationPackage->package_validity_months : $paymentIntent->items->data[0]->plan->interval . ' months';

        $order = Order::whereCustomerId($customer->id)->where('type', 'profile')->latest()->first();

        $data = ['package_name' => $packageName, 'package_price' => $packagePrice, 'package_validity' => $packageValidity, 'payment_frequency' => $customer->payment_frequency, 'customer' => $customer, 'order' => $order, 'package_expiry_date' => $package_expiry_date];


        $PDFService = new PDFService();

        $PDFService->createRegistrationInvoicePDF(null, $data);

        Mail::to($customer->email)->send(new RegistrationInvoiceToCustomerMail($data));
    }
}
