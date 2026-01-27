<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloseAccountRequest extends Model
{
    use HasFactory;

    protected $table = 'close_account_requests';

    protected $fillable = [
        'title',
        'email',
        'opinion',
        'customer_id',
        'page_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
