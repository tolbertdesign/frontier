<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class ValidPassword implements Rule
{
    protected $message = '';
    protected $_useShortPasswordMessages = false;

    public function useShortPasswordMessages(bool $bool)
    {
        $this->_useShortPasswordMessages = $bool;
    }

    private function _getLangKeyVersion()
    {
        return $this->_useShortPasswordMessages ? '_short' : '';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $password)
    {
        $password        = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number    = '/[0-9]/';
        $regex_special   = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
        $min             = env('PASSWORD_MIN_LENGTH');
        $max             = env('PASSWORD_MAX_LENGTH');

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $this->message = Lang::get('passwords.contains_lower' . $this->_getLangKeyVersion());
            return false;
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->message = Lang::get('passwords.contains_upper' . $this->_getLangKeyVersion());
            return false;
        }

        if (preg_match_all($regex_number, $password) < 1) {
            $this->message = Lang::get('passwords.contains_number' . $this->_getLangKeyVersion());
            return false;
        }

        if (preg_match_all($regex_special, $password) < 1) {
            $this->message = Lang::get('passwords.contains_special_character' . $this->_getLangKeyVersion());
            return false;
        }

        if (strlen($password) < $min) {
            $this->message = Lang::get('passwords.min_length' . $this->_getLangKeyVersion(), ['value' => env('PASSWORD_MIN_LENGTH')]);
            return false;
        }

        if (strlen($password) > $max) {
            $this->message = Lang::get('passwords.max_length' . $this->_getLangKeyVersion(), ['value' => env('PASSWORD_MAX_LENGTH')]);
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
