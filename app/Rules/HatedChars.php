<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class HatedChars implements Rule
{
    protected string $hatedChars;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hatedChars)
    {
        $this->hatedChars = $hatedChars;
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
        return !(Str::contains($value, $this->hatedChars));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute must not contain ({$this->hatedChars}), we hate those chars ^_^";
    }
}
