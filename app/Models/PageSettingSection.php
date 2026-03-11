<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSettingSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'page_setting_sections';

    public function pageSetting()
    {
        return $this->belongsTo(PageSetting::class);
    }

    public function contents()
    {
        return $this->hasMany(PageSettingContent::class, 'page_section_id');
    }

    /**
     * Get content for a given language, falling back to the default (English) language.
     *
     * @param  int|\App\Models\Language|null  $language
     * @return \App\Models\PageSettingContent|null
     */
    public function contentForLanguage($language = null)
    {
        $languageId = null;

        if (is_null($language)) {
            $defaultLang = getDefaultLanguage(true);
            $languageId = $defaultLang ? $defaultLang->id : null;
        } elseif (is_numeric($language)) {
            $languageId = (int) $language;
        } else {
            $languageId = $language->id ?? null;
        }

        if ($languageId) {
            $content = $this->contents()->where('language_id', $languageId)->first();
            if ($content) {
                return $content;
            }
        }

        $defaultLang = getDefaultLanguage(true);

        if ($defaultLang) {
            return $this->contents()->where('language_id', $defaultLang->id)->first();
        }

        return null;
    }
}

