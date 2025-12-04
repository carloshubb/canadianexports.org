<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageFeature extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $fillable = ['package_id', 'language_id', 'name'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
