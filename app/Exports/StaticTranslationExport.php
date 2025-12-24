<?php

namespace App\Exports;

use App\Models\StaticTranslationDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StaticTranslationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $langList;
    protected $langIds;
    protected $langNames;

    public function __construct()
    {
        $this->langList = getAllLanguages();
        $this->langIds = [];
        $this->langNames = [];
        
        foreach ($this->langList as $lang) {
            $this->langIds[] = $lang->id;
            $this->langNames[] = $lang->name;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Assume English is default language with ID of 1
        $detailLangList = StaticTranslationDetail::whereLanguageId(1)->get();
        
        // Add language translations to each detail
        foreach ($detailLangList as $langDetail) {
            foreach ($this->langIds as $langId) {
                $translation = StaticTranslationDetail::where('static_translation_id', $langDetail->static_translation_id)
                    ->where('key', $langDetail->key)
                    ->where('language_id', $langId)
                    ->first();
                $langDetail->{'lang_' . $langId} = $translation ? $translation->value : '';
            }
        }
        
        return $detailLangList;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['ID', 'Display Text', 'Key', ...$this->langNames];
    }

    /**
     * @param mixed $lang
     * @return array
     */
    public function map($lang): array
    {
        $row = [
            $lang->static_translation_id,
            $lang->display_text,
            $lang->key,
        ];
        
        // Add translations for each language
        foreach ($this->langIds as $langId) {
            $property = 'lang_' . $langId;
            $row[] = $lang->$property ?? '';
        }
        
        return $row;
    }
}

