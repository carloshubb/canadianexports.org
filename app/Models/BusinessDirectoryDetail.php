<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDirectoryDetail extends Model
{
    use HasFactory;
    protected $fillable = ["business_directory_id", "language_id","name","slug"];
    public $timestamps = false;


    public function businessDirectory()
    {
        return $this->belongsTo(BusinessDirectory::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
