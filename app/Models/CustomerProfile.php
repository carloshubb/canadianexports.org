<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerProfile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customer_profile';

    protected $fillable = ['company_name', 'slug', 'company_email', 'short_description', 'description', 'phone', 'website', 'keywords', 'address', 'customer_id','cta_btn', 'cta_link'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerBusinessCategory()
    {
        return $this->hasMany(CustomerBusinessCategory::class, 'customer_profile_id', 'id');
    }

    public function customerMedia()
    {
        return $this->hasOne(CustomerMedia::class, 'customer_profile_id', 'id');
    }

    public function customerSocialMedia()
    {
        return $this->hasOne(CustomerSocialMedia::class, 'customer_profile_id', 'id');
    }
    public function businessProfileStats()
{
    return $this->hasMany(BusinessProfileStats::class, 'customer_profile_id');
}

}
