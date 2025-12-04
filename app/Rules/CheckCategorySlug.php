<?php

namespace App\Rules;

use App\Models\Adjuster;
use App\Models\BusinessCategoryDetail;
use App\Models\Supervisor;
use Illuminate\Contracts\Validation\Rule;

class CheckCategorySlug implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $language;
    private $categoryId;


    public function __construct($language, $categoryId)
    {
        $this->language = $language;
        $this->categoryId = $categoryId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $businessCategoryDetail = BusinessCategoryDetail::where('name', $value)->whereLanguageId($this->language->id);
        if (isset($this->categoryId)) {
            $businessCategoryDetail = $businessCategoryDetail->where('business_category_id', '!=', $this->categoryId);
        }
        $businessCategoryDetail = $businessCategoryDetail->exists();
        if ($businessCategoryDetail) {
            return 0;
        }
        return 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Name in ' . $this->language->name . ' must be unique.';
    }
}