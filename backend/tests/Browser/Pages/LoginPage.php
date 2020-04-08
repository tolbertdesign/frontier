<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/v3/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible('@email');
        $browser->assertVisible('@password');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@email'       => 'input[name="email"]',
            '@password'    => 'input[name="password"]',
            // '@email'       => '#email',
            // '@password'    => '#password',
            // '@loginButton' => 'Login',
        ];
    }

    public function loginParent(Browser $browser, $email = 'boosterthontest+testparent@gmail.com', $password = 'test23')
    {
        $browser->type('@email', 'parent@example.com')
                ->type('@password', 'secret')
                ->press('Login');
    }
}
