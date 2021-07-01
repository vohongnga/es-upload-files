<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    protected $specialCharacter = true;
    protected $number = true;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern1 = '/^(.*[!@#$&*])$/';
        $this->specialCharacter = preg_match($pattern1, $value);
        $pattern2 = '/^(.*?[0-9]).$/';
        $this->number = preg_match($pattern2,$value);
        return($this->specialCharacter && $this->number);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if(!$this->number) {
            return 'The :attribute must have at least 1 number';
        }
        if(!$this->specialCharacter) {
            return 'The :attribute must have at least 1 special character.';
        }
    }
}
