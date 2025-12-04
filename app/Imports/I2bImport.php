<?php

namespace App\Imports;

use App\Models\BusinessCategory;
use App\Models\I2b;
use App\Models\I2bDetail;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class I2bImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                continue;
            }
            if (!isset($row[12])) {
                continue;
            }
            $language = Language::where('id', $row[12])->exists();
            if (!$language) {
                continue;
            }
            if (!isset($row[4])) {
                continue;
            }
            $businessCategory = BusinessCategory::where('id', $row[4])->exists();
            if (!$businessCategory) {
                continue;
            }
            $businessCategory2 = BusinessCategory::where('id', $row[5])->exists();
            if(!$businessCategory2){
                $row[5] = null;
            }
            $businessCategory3 = BusinessCategory::where('id', $row[6])->exists();
            if(!$businessCategory3){
                $row[6] = null;
            }


            $i2b = I2b::where('import_id', $row[0])->first();

            if (!$i2b) {
                $excelDate = $row[7];
                if (isset($excelDate) && $excelDate != '') {
                    try {
                        $formattedDate = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($excelDate - 2)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $formattedDate = null;
                    }
                }

                if (isset($row[9]) && $row[9] != '') {
                    $response = Http::get($row[9]);

                    if ($response->successful()) {
                        $pdfContent = $response->body();

                        $path = parse_url($row[9], PHP_URL_PATH);
                        $extension = pathinfo($path, PATHINFO_EXTENSION);

                        $storagePath = public_path('documents/uploads/i2b');

                        if (!is_dir($storagePath)) {
                            mkdir($storagePath, 0755, true);
                        }
                        $fileName = time() . '.' . $extension;

                        $filePath = $storagePath . '/' . $fileName;

                        // Store the PDF content to a local file
                        file_put_contents($filePath, $pdfContent);

                        $pdf_1 = '/documents/uploads/i2b/' . $fileName;
                    }
                }

                if (isset($row[10]) && $row[10] != '') {
                    $response = Http::get($row[10]);

                    if ($response->successful()) {
                        $pdfContent = $response->body();

                        $path = parse_url($row[10], PHP_URL_PATH);
                        $extension = pathinfo($path, PATHINFO_EXTENSION);

                        $storagePath = public_path('documents/uploads/i2b');

                        if (!is_dir($storagePath)) {
                            mkdir($storagePath, 0755, true);
                        }
                        $fileName = time() . '.' . $extension;

                        $filePath = $storagePath . '/' . $fileName;

                        // Store the PDF content to a local file
                        file_put_contents($filePath, $pdfContent);

                        $pdf_2 = '/documents/uploads/i2b/' . $fileName;
                    }
                }

                if (isset($row[11]) && $row[11] != '') {
                    $response = Http::get($row[11]);

                    if ($response->successful()) {
                        $pdfContent = $response->body();

                        $path = parse_url($row[11], PHP_URL_PATH);
                        $extension = pathinfo($path, PATHINFO_EXTENSION);

                        $storagePath = public_path('documents/uploads/i2b');

                        if (!is_dir($storagePath)) {
                            mkdir($storagePath, 0755, true);
                        }
                        $fileName = time() . '.' . $extension;

                        $filePath = $storagePath . '/' . $fileName;

                        // Store the PDF content to a local file
                        file_put_contents($filePath, $pdfContent);

                        $pdf_3 = '/documents/uploads/i2b/' . $fileName;
                    }
                }


                $i2b = I2b::create([
                    'email' => $row[2],
                    'business_category_id' => $row[4],
                    'business_category_id_2' => $row[5],
                    'business_category_id_3' => $row[6],
                    'deadline_date' => $formattedDate,
                    'estimated_value' => $row[8],
                    'pdf_1' => isset($pdf_1) ? $pdf_1 : null,
                    'pdf_2' => isset($pdf_2) ? $pdf_2 : null,
                    'pdf_3' => isset($pdf_3) ? $pdf_3 : null,
                    'import_id' => $row[0],
                ]);
            }


            $i2bDetail = I2bDetail::where('i2b_id', $i2b->id)->where('language_id', $row[12])->first();
            if (!$i2bDetail) {
                I2bDetail::create([
                    'i2b_id' => $i2b->id,
                    'language_id' => $row[12],
                    'name' => $row[1],
                    'country_name' => $row[3],
                ]);
            }
        }
        I2b::whereNotNull('import_id')->update([
            'import_id' => null
        ]);
    }
}
