<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class I2b extends Model
{
    use HasFactory;

    protected $table = 'i2b';

    protected $guarded = [];

    public function i2bDetail()
    {
        return $this->hasMany(I2bDetail::class, "i2b_id", "id");
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function businessCategory1()
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function businessCategory2()
    {
        return $this->belongsTo(BusinessCategory::class);
    }
}
