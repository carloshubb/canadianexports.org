<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function issueDetail()
    {
        return $this->hasMany(IssueDetail::class, 'issue_id', 'id');
    }
}
