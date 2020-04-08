<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class PublicPage extends Page
{
    protected $shortKey;

    public function __construct($shortKey)
    {
        $this->shortKey = $shortKey;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return secure_url('/v3/dash/' . $this->shortKey);
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertSee('Enter Pledge');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [];
    }
}
