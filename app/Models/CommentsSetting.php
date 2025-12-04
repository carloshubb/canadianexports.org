<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsSetting extends Model
{
    use HasFactory;

    protected $table = 'comments_setting';

    protected $guarded = [];

    public function commentsSettingDetail()
    {
        return $this->hasMany(CommentsSettingDetail::class, "comments_setting_id", "id");
    }
}
