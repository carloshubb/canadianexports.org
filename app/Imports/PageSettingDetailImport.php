<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PageSettingDetailImport implements ToCollection
{
    protected Model $detailModel;

    protected int $settingId;

    protected string $settingForeignKey;

    protected array $valueColumns;

    protected array $langIds;

    public function __construct(Model $detailModel, int $settingId, ?string $settingForeignKey = null)
    {
        $this->detailModel = $detailModel;
        $this->settingId = $settingId;
        $table = $detailModel->getTable();
        $this->settingForeignKey = $settingForeignKey ?? (str_replace('_detail', '', $table) . '_id');
        $allColumns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
        $this->valueColumns = array_values(array_diff($allColumns, ['id', 'language_id', $this->settingForeignKey]));
        $langs = getAllLanguages();
        $this->langIds = $langs->pluck('id')->all();
    }

    public function collection(Collection $rows)
    {
        $keyIndex = 0;
        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex === 0) {
                continue; // skip header
            }
            $row = $row->toArray();
            $key = isset($row[0]) ? trim((string) $row[0]) : '';
            if ($key === '' || !in_array($key, $this->valueColumns, true)) {
                continue;
            }
            foreach ($this->langIds as $langIndex => $langId) {
                $value = isset($row[1 + $langIndex]) ? (string) $row[1 + $langIndex] : '';
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                $this->detailModel->newQuery()->updateOrCreate(
                    [
                        $this->settingForeignKey => $this->settingId,
                        'language_id' => $langId,
                    ],
                    [$key => $value]
                );
            }
        }
    }
}
