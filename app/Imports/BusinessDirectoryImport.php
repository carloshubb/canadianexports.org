<?php

namespace App\Imports;

use App\Models\BusinessDirectory;
use App\Models\BusinessDirectoryDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class BusinessDirectoryImport implements ToCollection
{

    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $sql = BusinessDirectory::create([
                'address' => $row[1] ?? null,
                'city' => $row[2] ?? null,
                'province' => $row[3] ?? null,
                'postal_code' => $row[4] ?? null,
                'phone' => $row[5] ?? null,
                'fax' => '---',
                'industry' => $row[6] ?? null,
                'status' => 'active',
            ]);

            BusinessDirectoryDetail::create([
                'business_directory_id' => $sql->id,
                'language_id' => '1',
                'name' => $row[0] ?? null,
                'slug' => Str::slug($row[0]) ?? null,
            ]);
        }
    }

}
