<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMedia extends Model
{
    use HasFactory;

    protected $table = 'customer_media';

    public $timestamps = false;

    protected $fillable = ['customer_id', 'logo', 'video', 'video_frame', 'customer_profile_id', 'title', 'description', 'images'];

    public function customerLogo()
    {
        return $this->belongsTo(Media::class, 'logo', 'id');
    }

    public function customerProfile()
    {
        return $this->belongsTo(CustomerProfile::class);
    }

    public function customerGalleryImages()
    {
        return $this->hasMany(CustomerGalleryImage::class);
    }
}
