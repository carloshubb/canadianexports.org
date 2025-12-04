<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'parent_id',
        'position',
        'is_active',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ArticleSection::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ArticleSection::class, 'parent_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'section_id');
    }
}


