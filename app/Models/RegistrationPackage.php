<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPackage extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function registrationPackageDetail()
    {
        return $this->hasMany(RegistrationPackageDetail::class, "registration_package_id", "id");
    }

    public function registrationPackageFeature()
    {
        return $this->hasMany(RegistrationPackageFeature::class, "registration_package_id", "id");
    }
}
