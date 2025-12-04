<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryMedia extends Model
{
    use HasFactory;

    protected $table = 'temporary_media';

    protected $fillable = [
        'path',
        'type',
        'extension',
    ];

}
