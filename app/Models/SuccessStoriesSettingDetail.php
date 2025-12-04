<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStoriesSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'success_stories_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function successStoriesSetting()
    {
        return $this->belongsTo(SuccessStoriesSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
