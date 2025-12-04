<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'comments_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function commentsSetting()
    {
        return $this->belongsTo(CommentsSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
