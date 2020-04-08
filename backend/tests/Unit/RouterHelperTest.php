<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Helpers\RouteHelper;

class RouterHelperTest extends TestCase
{
    public function testValidRoute()
    {
        $validUri = 'v3/home/dashboard';

        $this->assertTrue(RouteHelper::isValidRoute($validUri));
    }

    public function testValidRouteWithParam()
    {
        $validUri = 'v3/api/videos/program/5';

        $this->assertTrue(RouteHelper::isValidRoute($validUri));
    }

    public function testInvalidValidRoute()
    {
        $invalidUri = 'v3/does-not-exist';

        $this->assertFalse(RouteHelper::isValidRoute($invalidUri));
    }
}
