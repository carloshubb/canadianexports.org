<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function menuDetail()
    {
        return $this->hasMany(MenuDetail::class, "menu_id", "id");
    }
}
