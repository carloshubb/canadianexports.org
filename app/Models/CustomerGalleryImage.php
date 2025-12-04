<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGalleryImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['customer_media_id', 'media_id'];

    public function customerMedia()
    {
        return $this->belongsTo(CustomerMedia::class, 'customer_media_id', 'id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }
}
