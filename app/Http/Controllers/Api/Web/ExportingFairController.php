<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\ExportingFair;
use App\Traits\StatusResponser;

class ExportingFairController extends Controller
{
    use StatusResponser;

    public function show($abbreviation, $id)
    {
        updateLangByAbber($abbreviation);
        $defaultLang = getDefaultLanguage(true);
        $exportingFair = ExportingFair::with(['exportingFairDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->with('media')->whereId($id)->firstOrFail();
        return view('web.exporting-fair.show', compact('exportingFair'));
    }
}
