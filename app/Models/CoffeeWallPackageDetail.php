<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeWallPackageDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['package_id', 'language_id', 'name', 'short_description'];

    public function coffeeWallPackage()
    {
        return $this->belongsTo(CoffeeWallPackage::class);
    }
}
