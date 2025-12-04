<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueDetail extends Model
{
    use HasFactory;

    protected $fillable = ["issue_id", "language_id", "title"];

    protected $table = 'issue_detail';

    public $timestamps = false;

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
