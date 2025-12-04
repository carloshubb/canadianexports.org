<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class I2bDetail extends Model
{
    use HasFactory;

    protected $table = 'i2b_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function i2b()
    {
        return $this->belongsTo(I2b::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
