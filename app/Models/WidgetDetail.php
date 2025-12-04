<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetDetail extends Model
{
    use HasFactory;

    protected $table = 'widget_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function widget()
    {
        return $this->belongsTo(Widget::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
