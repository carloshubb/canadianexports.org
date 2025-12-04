<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $validationFilePath = lang_path('en') . '/validation.php';
        if (file_exists($validationFilePath)) {
            $validation = File::getRequire($validationFilePath);
            $validation['maxwords'] = 'This :attribute must have less than :maxwords words.';

            $content = "<?php\n\nreturn\n[\n";
            foreach ($validation as $key => $value) {
                if (is_array($value)) {
                    $content .= "\t'" . $key . "' => \n[\n";
                    foreach ($value as $k => $v) {
                        if (is_array($v)) {
                            $content .= "\t'" . $k . "' => \n[\n";
                            foreach ($v as $k1 => $v1) {
                                $content .= "\t'" . $k1 . "' => '" . $v1 . "',\n";
                            }
                            $content .= "],";
                        } else {
                            $content .= "\t'" . $k . "' => '" . $v . "',\n";
                        }
                    }
                    $content .= "],";
                } else {
                    $content .= "\t'" . $key . "' => '" . $value . "',\n";
                }
            }

            $content .= "];";
            file_put_contents($validationFilePath, $content);
        }
    }
}
