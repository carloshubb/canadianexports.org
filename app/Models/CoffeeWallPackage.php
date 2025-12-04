<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeWallPackage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function coffeeWallPackageDetail()
    {
        return $this->hasMany(CoffeeWallPackageDetail::class, "package_id", "id");
    }
}
