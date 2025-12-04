<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ErrorController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $validationFilePath = lang_path($language->abbreviation) . '/validation.php';
            if (file_exists($validationFilePath)) {
                $validation = File::getRequire($validationFilePath);
                unset($validation['custom']);
                unset($validation['attributes']);
                $language->validation = $validation;
            }
        }

        return $this->successResponse($languages, 'Language has been added successfully.');
    }

    public function update(Request $request)
    {
        $rules = [
            'language_id' => ['required', 'exists:App\Models\Language,id'],
            'value' => ['required', 'string'],
            'field' => ['required', 'string'],
        ];
        $this->validate($request, $rules);

        $language = Language::whereId($request->language_id)->first();

        $validationFilePath = lang_path($language->abbreviation) . '/validation.php';
        if (file_exists($validationFilePath)) {
            $validation = File::getRequire($validationFilePath);
            $validation[$request->field] = $request->value;

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
            return $this->successResponse([], 'Error has been updated successfully.');
        }
    }
}
