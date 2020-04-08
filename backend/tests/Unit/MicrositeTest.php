<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Microsite as MicrositeModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MicrositeTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp() : void
    {
        parent::setUp();

        $this->microsite = new MicrositeModel();
    }

    /**
     * Testing tag that is not allowed.
     *
     * @return void
     */
    public function testDisallowedTag()
    {
        $dirtyHtml = '<center>Test</center>';
        $expectedHtml = 'Test';

        $resultHtml = $this->microsite->getOverviewTextOverrideAttribute($dirtyHtml);

        $this->assertTrue($expectedHtml === $resultHtml);
    }

    /**
     * Testing tag that is allowed.
     *
     * @return void
     */
    public function testAllowedTag()
    {
        $dirtyHtml = '<div>Test <p>Cool!</p></div>';

        $resultHtml = $this->microsite->getOverviewTextOverrideAttribute($dirtyHtml);

        $this->assertTrue($dirtyHtml === $resultHtml);
    }

    /**
     * Testing anchor tag atrribute that is not allowed.
     *
     * @return void
     */
    public function testDisallowedAnchorTag()
    {
        $dirtyHtml = '<a target="my_frame">Link</a>';
        $expectedHtml = '<a>Link</a>';

        $resultHtml = $this->microsite->getOverviewTextOverrideAttribute($dirtyHtml);

        $this->assertTrue($expectedHtml === $resultHtml);
    }
}
