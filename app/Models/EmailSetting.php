<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use HasFactory;

    protected $table = 'email_setting';

    protected $guarded = [];

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }
}
