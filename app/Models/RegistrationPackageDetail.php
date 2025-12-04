<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPackageDetail extends Model
{
    use HasFactory;

    protected $table = 'registration_package_detail';

    public $timestamps = false;

    protected $fillable = ['registration_package_id', 'language_id', 'name', 'short_description'];

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }
}
