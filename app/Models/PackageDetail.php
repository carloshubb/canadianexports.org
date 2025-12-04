<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
    use HasFactory;

    protected $table = 'package_detail';

    public $timestamps = false;

    protected $fillable = ['package_id', 'language_id', 'name', 'short_description'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
