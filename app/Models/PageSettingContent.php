<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSettingContent extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'page_setting_contents';

    public function section()
    {
        return $this->belongsTo(PageSettingSection::class, 'page_section_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}

