<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDirectory extends Model
{
    use HasFactory;
    protected $fillable = [
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'fax',
        'industry',
        'status'
    ];

    public function businessDirectoryDetail()
    {
        return $this->hasMany(BusinessDirectoryDetail::class, "business_directory_id", "id");
    }
    
}
