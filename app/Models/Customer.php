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

    protected $fillable = ['name', 'email', 'password', 'registration_package_id', 'package_price', 'package_subscribed_date', 'package_expiry_date', 'is_package_amount_paid', 'type', 'is_exporter', 'is_event', 'is_sponsor', 'events_allowed', 'events_remaining', 'images_allowed', 'is_active', 'active_email_url', 'stripe_customer_id', 'is_auto_renew', 'subscription_status', 'subscription_id', 'payment_method', 'stripe_item_id', 'paypal_subscription_id', 'temp_registration_package_id', 'verify_customer_email', 'first_pkg_expiry_mail', 'second_pkg_expiry_mail', 'third_pkg_expiry_mail', 'business_name', 'payment_frequency', 'is_account_closed', 'active_account_url', 'profile_image_id', 'temp_payment_frequency', 'temp_is_auto_renew', 'temp_type', 'is_subscribe', 'subscribe_hash'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_exporter' => 'boolean',
        'is_event' => 'boolean',
        'is_sponsor' => 'boolean',
    ];

    protected $appends = ['sponsor', 'event', 'event_detail'];


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

    public function sponsor()
    {
        return $this->hasMany(Sponsor::class);
    }
    public function getSponsorAttribute()
    {
        return $this->sponsor()->get();
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }
    public function getEventAttribute()
    {
        return $this->event()->get();
    }

    public function eventDetail()
    {
        return $this->hasManyThrough(EventDetail::class, Event::class, 'customer_id', 'event_id', 'id', 'id');
    }
    public function getEventDetailAttribute()
    {
        return $this->eventDetail()->get();
    }
    
    /**
     * Landing type by priority: Exporter (customer) > Event > Sponsor.
     * Used for login redirect and dashboard routing.
     */
    public function getLandingTypeAttribute(): string
    {
        if (!empty($this->attributes['is_exporter'] ?? 0)) {
            return 'customer';
        }
        if (!empty($this->attributes['is_event'] ?? 0)) {
            return 'event';
        }
        if (!empty($this->attributes['is_sponsor'] ?? 0)) {
            return 'sponsor';
        }
        return $this->attributes['type'] ?? 'customer';
    }

    /**
     * When reading type, return landing type (priority: exporter > event > sponsor).
     */
    public function getTypeAttribute($value): string
    {
        if (array_key_exists('is_exporter', $this->attributes) || array_key_exists('is_event', $this->attributes) || array_key_exists('is_sponsor', $this->attributes)) {
            return $this->landing_type;
        }
        return $value ?? 'customer';
    }

    /**
     * When setting type, set the corresponding role flag (adds role without removing others).
     */
    public function setTypeAttribute($value): void
    {
        $this->attributes['type'] = $value;
        if ($value === 'customer') {
            $this->attributes['is_exporter'] = 1;
        } elseif ($value === 'event') {
            $this->attributes['is_event'] = 1;
        } elseif ($value === 'sponsor') {
            $this->attributes['is_sponsor'] = 1;
        }
    }

    /**
     * Dashboard URL by landing type priority: Exporter > Event > Sponsor.
     *
     * @param  object|null  $lang  Language object for langBasedURL
     * @return string
     */
    public function getDashboardUrl($lang = null): string
    {
        $lang = $lang ?? getDefaultLanguage(true);
        $landingType = $this->landing_type;

        if ($landingType === 'customer') {
            return langBasedURL($lang, route('user.profile-settings.index'));
        }
        if ($landingType === 'sponsor') {
            return langBasedURL($lang, route('user.sponsor-settings.index'));
        }
        // event
        $general_setting = getGeneralSettingByKey();
        $eventListingPage = $general_setting['user_event_listing_page'] ?? null;
        $url = $eventListingPage ? url($eventListingPage) : route('front.index');
        return langBasedURL($lang, $url);
    }

}
