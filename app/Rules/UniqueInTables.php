<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueInTables implements ValidationRule
{

    public function __construct(
        private readonly array $tables, 
        private readonly string $column
    ) {}


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach($this->tables as $table) {
            if (DB::table($table)->where($this->column, $value)->exists()) {
                $fail(__('validation.unique', ['attribute' => __("app.$attribute")]));
                return;
            }
        }
    }
}
