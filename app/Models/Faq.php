<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq';

    protected $guarded = [];

    public function faqDetail()
    {
        return $this->hasMany(FaqDetail::class, "faq_id", "id");
    }
}
