<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\PageSettingDetailExport;
use App\Http\Controllers\Controller;
use App\Imports\PageSettingDetailImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PageSettingDetailController extends Controller
{

    protected function getConfigForTemplate(?string $template): ?array
    {
        if (!$template) {
            return null;
        }
        $templates = config('page_setting_templates.templates', []);
        $config = $templates[$template] ?? null;
        if (!$config || !isset($config[0], $config[1])) {
            return null;
        }
        return [
            'setting_class' => $config[0],
            'detail_class' => $config[1],
            'setting_fk' => $config[2] ?? null,
        ];
    }

    /**
     * Download Excel template with page setting detail fields and language columns.
     * Query: page_id, template (required). Only when template has a setting detail table.
     */
    public function exportXls(Request $request)
    {
        $request->validate([
            'page_id' => ['required', 'integer', 'exists:pages,id'],
            'template' => ['required', 'string'],
        ]);
        $template = $request->input('template');
        $pageId = (int) $request->input('page_id');
        $config = $this->getConfigForTemplate($template);
        if (!$config) {
            return response()->json(['status' => 'Error', 'message' => 'Template does not support Excel export.'], 422);
        }
        $settingClass = $config['setting_class'];
        $detailClass = $config['detail_class'];
        $setting = $settingClass::where('page_id', $pageId)->first();
        if (!$setting) {
            return response()->json(['status' => 'Error', 'message' => 'Page setting not found. Save the page first.'], 404);
        }
        $detailModel = new $detailClass;
        $export = new PageSettingDetailExport($detailModel, $setting->id, $config['setting_fk']);
        $fileName = 'page_setting_detail_' . $template . '_' . now()->format('Ymd_His') . '.xls';

        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLS);
    }

    /**
     * Import Excel and update page setting detail rows.
     */
    public function importXls(Request $request)
    {
        $request->validate([
            'page_id' => ['required', 'integer', 'exists:pages,id'],
            'template' => ['required', 'string'],
            'file' => ['required', 'file', 'mimes:xls,xlsx'],
        ]);
        $template = $request->input('template');
        $pageId = (int) $request->input('page_id');
        $config = $this->getConfigForTemplate($template);
        if (!$config) {
            return response()->json(['status' => 'Error', 'message' => 'Template does not support Excel import.'], 422);
        }
        $settingClass = $config['setting_class'];
        $detailClass = $config['detail_class'];
        $setting = $settingClass::where('page_id', $pageId)->first();
        if (!$setting) {
            return response()->json(['status' => 'Error', 'message' => 'Page setting not found. Save the page first.'], 404);
        }
        $detailModel = new $detailClass;
        $import = new PageSettingDetailImport($detailModel, $setting->id, $config['setting_fk']);
        Excel::import($import, $request->file('file'));
        return response()->json(['status' => 'Success', 'message' => 'Excel imported successfully. Setting details updated.', 'data' => []]);
    }
}
