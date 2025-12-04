<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function widgetDetail()
    {
        return $this->hasMany(WidgetDetail::class, "widget_id", "id");
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'image_path', 'id');
    }

    public function media2()
    {
        return $this->belongsTo(Media::class, 'image_path_2', 'id');
    }
}
