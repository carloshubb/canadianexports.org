<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PageSettingDetailExport implements FromArray, WithHeadings
{
    protected Model $detailModel;

    protected int $settingId;

    protected string $settingForeignKey;

    protected array $valueColumns;

    protected array $langIds;

    protected array $langNames;

    public function __construct(Model $detailModel, int $settingId, ?string $settingForeignKey = null)
    {
        $this->detailModel = $detailModel;
        $this->settingId = $settingId;
        $table = $detailModel->getTable();
        $this->settingForeignKey = $settingForeignKey ?? (str_replace('_detail', '', $table) . '_id');
        $allColumns = Schema::getColumnListing($table);
        $this->valueColumns = array_values(array_diff($allColumns, ['id', 'language_id', $this->settingForeignKey]));
        $langs = getAllLanguages();
        $this->langIds = $langs->pluck('id')->all();
        $this->langNames = $langs->pluck('name')->all();
    }

    public function headings(): array
    {
        return ['Key', ...$this->langNames];
    }

    public function array(): array
    {
        $rows = [];
        $details = $this->detailModel->newQuery()
            ->where($this->settingForeignKey, $this->settingId)
            ->get()
            ->groupBy('language_id');

        foreach ($this->valueColumns as $key) {
            $row = [$key];
            foreach ($this->langIds as $langId) {
                $detail = $details->get($langId)?->first();
                $row[] = $detail ? ($detail->{$key} ?? '') : '';
            }
            $rows[] = $row;
        }

        return $rows;
    }
}
