<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStoriesSetting extends Model
{
    use HasFactory;

    protected $table = 'success_stories_setting';

    protected $guarded = [];

    public function successStoriesSettingDetail()
    {
        return $this->hasMany(SuccessStoriesSettingDetail::class, "success_stories_setting_id", "id");
    }
}
