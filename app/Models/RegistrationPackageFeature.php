<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPackageFeature extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $fillable = ['registration_package_id', 'language_id', 'name'];

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }
}
