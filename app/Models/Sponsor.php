<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'talk_to_us_first' => 'boolean',
        'is_visible' => 'boolean',
        'paid_at' => 'datetime',
        'preferred_call_date' => 'date',
        'appointment_date' => 'date',
    ];

    /**
     * Get the customer associated with the sponsor.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the logo media.
     */
    public function logoMedia()
    {
        return $this->belongsTo(Media::class, 'logo_media_id');
    }

    /**
     * Get the featured media.
     */
    public function featuredMedia()
    {
        return $this->belongsTo(Media::class, 'featured_media_id');
    }

    /**
     * Get the beneficiary.
     */
    public function beneficiary()
    {
        return $this->belongsTo(CoffeeWallBeneficiary::class, 'beneficiary_id');
    }

    /**
     * Get all beneficiaries associated with the sponsor.
     */
    public function beneficiaries()
    {
        return $this->belongsToMany(CoffeeWallBeneficiary::class, 'sponsor_beneficiary')->withTimestamps();
    }

    /**
     * Scope for active sponsors.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for visible sponsors.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope for paid sponsors.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Check if sponsor is fully approved and visible.
     */
    public function isLive()
    {
        return $this->status === 'active' && 
               $this->is_visible === true && 
               ($this->payment_status === 'paid' || $this->payment_status === 'not_required');
    }

    /**
     * Mark sponsor as paid and activate.
     */
    public function markAsPaid($transactionId, $paymentMethod)
    {
        $this->update([
            'payment_status' => 'paid',
            'status' => 'active',
            'is_visible' => true,
            'transaction_id' => $transactionId,
            'payment_method' => $paymentMethod,
            'paid_at' => now(),
        ]);
    }
}

