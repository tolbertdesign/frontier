<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class RegisterPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/v3';
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@firstName'            => 'input[name=first_name]',
            '@lastName'             => 'input[name=last_name]',
            '@email'                => 'input[name=email]',
            '@emailConfirmation'    => 'input[name=email_confirmation]',
            '@password'             => 'input[name=password]',
            '@passwordConfirmation' => 'input[name=password_confirmation]',
            '@phone'                => 'input[name=phone]',
            '@createAccount'        => 'button[type=submit]',
            '@emailRegistration'    => '#email_registration]',
            '@schoolSearch'         => 'input[name=school_search]',
            '@teacherCode'          => 'input[name=teacher_registration_code]'
        ];
    }
}
