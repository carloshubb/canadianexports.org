<?php

namespace App\Services\Package;

use App\Models\Language;
use App\Models\Package;
use App\Models\PackageDetail;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createOrUpdatePackage(Package $package, $request, $inactivePrice = false)
    {
        // GET package name
        $language = Language::where('is_default', '1')->first();
        $packageDetail = PackageDetail::wherePackageId($package->id);
        if ($language) {
            $packageDetail = $packageDetail->whereLanguageId($language->id);
        }
        $packageDetail = $packageDetail->first();
        $packageName = $packageDetail->name ?? env('APP_NAME');

        if ($package->stripe_product_id) {
            $product = Product::retrieve($package->stripe_product_id);
            $product->name = $packageName;
            $product->save();
        } else {
            $product = Product::create([
                'name' => $packageName,
                'type' => 'service',
            ]);
            $package->update(['stripe_product_id' => $product->id]);
        }
        $createMonthlyPrice = false;
        $createQuaterlyPrice = false;
        $createSemiAnnualPrice = false;
        $createAnnualPrice = false;
        if ($inactivePrice) {
            if ($request->monthly_price != $package->monthly_price) {
                $createMonthlyPrice = true;
            }
            if ($request->quarterly_price != $package->quarterly_price) {
                $createQuaterlyPrice = true;
            }
            if ($request->semi_annual_price != $package->semi_annual_price) {
                $createSemiAnnualPrice = true;
            }
            if ($request->annual_price != $package->annual_price) {
                $createAnnualPrice = true;
            }
        }

        // Create or update prices
        if ($inactivePrice == false || $createMonthlyPrice) {
            $price = $this->createOrUpdatePrice($product->id, 1, $package->monthly_price);
            $package->update(['monthly_stripe_price_id' => $price->id ?? null]);
        }

        if ($inactivePrice == false || $createQuaterlyPrice) {
            $price = $this->createOrUpdatePrice($product->id, 3, $package->quarterly_price);
            $package->update(['quarterly_stripe_price_id' => $price->id ?? null]);
        }

        if ($inactivePrice == false || $createSemiAnnualPrice) {
            $price = $this->createOrUpdatePrice($product->id, 6, $package->semi_annual_price);
            $package->update(['semi_annual_stripe_price_id' => $price->id ?? null]);
        }

        if ($inactivePrice == false || $createAnnualPrice) {
            $price = $this->createOrUpdatePrice($product->id, 12, $package->annual_price);
            $package->update(['annual_stripe_price_id' => $price->id ?? null]);
        }
    }

    protected function createOrUpdatePrice($productId, $interval, $price)
    {
        if ($price) {
            $priceData = [
                'product' => $productId,
                'unit_amount' => $price * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => 'month', 'interval_count' => $interval],
            ];

            return Price::create($priceData);
        }
    }
}
