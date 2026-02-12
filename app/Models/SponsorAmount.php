<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorAmount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
        'amount' => 'decimal:2',
    ];

    // Frequency options: one_time, monthly, quarterly, annually
    public static $frequencies = [
        'one_time' => 'One Time',
        'monthly' => 'Monthly',
        'quarterly' => 'Quarterly',
        'annually' => 'Annually'
    ];

    public static $frequencies_es = [
        'one_time' => 'Una vez',
        'monthly' => 'Mensual',
        'quarterly' => 'Trimestral',
        'annually' => 'Anual'
    ];

    /**
     * Get frequency labels for the given language.
     *
     * @param \App\Models\Language|null $lang
     * @return array
     */
    public static function getFrequenciesForLang($lang)
    {
        $abbr = $lang ? strtolower(trim($lang->abbreviation ?? '')) : '';
        if ($abbr === 'es') {
            return static::$frequencies_es;
        }
        return static::$frequencies;
    }
}
