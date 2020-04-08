<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use App\Models\DashboardUser\ParentUser;
use App\Facades\FeatureFlag;

class DashboardUserTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        $this->parentUser = User::where('email', 'parent@example.com')->first();
    }

    /**
     *
     * @return void
     */
    public function testAppendsNotifications()
    {
        FeatureFlag::shouldReceive('checkIfGloballyEnabled')
            ->with('notifications')
            ->andReturn(true);

        $dashboardUser = new ParentUser($this->parentUser);
        $user          = $dashboardUser->get();
        $attributes    = $user->toArray();

        $this->assertTrue(array_key_exists('notifications', $attributes));
    }

    /**
     *
     * @return void
     */
    public function testDoesNotAppendNotifications()
    {
        FeatureFlag::shouldReceive('checkIfGloballyEnabled')
            ->with('notifications')
            ->andReturn(false);

        $dashboardUser = new ParentUser($this->parentUser);
        $user          = $dashboardUser->get();
        $attributes    = $user->toArray();

        $this->assertFalse(array_key_exists('notifications', $attributes));
    }
}
