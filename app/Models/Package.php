<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function packageDetail()
    {
        return $this->hasMany(PackageDetail::class, "package_id", "id");
    }

    public function packageFeature()
    {
        return $this->hasMany(PackageFeature::class, "package_id", "id");
    }
}
