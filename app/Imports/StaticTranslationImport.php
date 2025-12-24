<?php

namespace App\Imports;

use App\Models\StaticTranslationDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StaticTranslationImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        // Skip header row
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue; // Skip header
            }

            if (!isset($row[0]) || !isset($row[1]) || !isset($row[2])) {
                continue; // Skip invalid rows
            }

            $static_translation_id = $row[0];
            $display_text = $row[1];
            $key = $row[2];

            $lang_list = getAllLanguages();
            $lang_ids = [];
            foreach ($lang_list as $lang) {
                $lang_ids[] = $lang->id;
            }

            foreach ($lang_ids as $index => $lang_id) {
                $value = isset($row[3 + $index]) ? (string)$row[3 + $index] : "";
                
                // Handle encoding if needed (Excel usually handles UTF-8 well)
                if (!empty($value)) {
                    $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }

                StaticTranslationDetail::updateOrCreate(
                    [
                        'static_translation_id' => $static_translation_id,
                        'language_id' => $lang_id,
                        'key' => $key,
                    ],
                    [
                        'display_text' => $display_text,
                        'value' => $value,
                    ]
                );
            }
        }
    }
}

