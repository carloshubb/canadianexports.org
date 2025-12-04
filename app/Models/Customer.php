<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'registration_package_id', 'package_price', 'package_subscribed_date', 'package_expiry_date', 'is_package_amount_paid', 'type', 'events_allowed', 'events_remaining', 'images_allowed', 'is_active', 'active_email_url', 'stripe_customer_id', 'is_auto_renew', 'subscription_status', 'subscription_id', 'payment_method', 'stripe_item_id', 'paypal_subscription_id', 'temp_registration_package_id', 'verify_customer_email', 'first_pkg_expiry_mail', 'second_pkg_expiry_mail', 'third_pkg_expiry_mail', 'business_name', 'payment_frequency', 'is_account_closed', 'active_account_url', 'profile_image_id', 'temp_payment_frequency', 'temp_is_auto_renew', 'temp_type','is_subscribe','subscribe_hash'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }

    public function customerBusinessCategory()
    {
        return $this->hasMany(CustomerBusinessCategory::class, 'customer_id', 'id');
    }

    public function customerPaymentMethod()
    {
        return $this->hasMany(CustomerPaymentMethod::class, 'customer_id', 'id');
    }

    public function customerMedia()
    {
        return $this->hasOne(CustomerMedia::class, 'customer_id', 'id');
    }

    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class, 'customer_id', 'id');
    }

    public function customerSocialMedia()
    {
        return $this->hasOne(CustomerSocialMedia::class, 'customer_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(order::class, 'customer_id', 'id');
    }

    public function profileImage()
    {
        return $this->belongsTo(Media::class, 'profile_image_id', 'id');
    }

    public function infoLetters()
    {
        return $this->hasMany(InfoLetter::class, 'email', 'email');
    }
}
