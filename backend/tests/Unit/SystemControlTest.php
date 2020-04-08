<?php

namespace Tests\Unit;

use App\Entities\User;
use App\Libraries\SystemControl;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;;
use Illuminate\Support\Facades\Redis;
use Mockery;

class SystemControlTest extends TestCase
{
    private $systemControl;

    public function setUp() : void
    {
        parent::setUp();
        $this->systemControl = new SystemControl();
    }

    public function testFeatureDoesNotExists()
    {
        $user = User::find(4);
        $result = $this->systemControl->featureStatus('does_not_exist', $user);
        $this->assertFalse($result);
    }

    public function testFeatureParity()
    {
        config(['system_control.titan_dashboard.feature_on' => 'parity']);
        $user = User::find(4);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertFalse($result);
        $user = User::find(5);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertTrue($result);
    }

    public function testFeatureByProgram()
    {
        config(['system_control.titan_dashboard.feature_on' => 'programs:a4MU0000001JCN3MAO']);
        $user = User::find(4);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertFalse($result);
        config(['system_control.titan_dashboard.feature_on' => 'programs:a4MU0000001JCN3MA6']);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertTrue($result);
        config(['system_control.titan_dashboard.feature_on' => 'programs:a4MU0000001JCN3MAO,a4MU0000001JCN3MA6']);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertTrue($result);
    }

    public function testFeatureOn(){
        config(['system_control.titan_dashboard.feature_on' => 'off']);
        $user = User::find(4);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertFalse($result);
        config(['system_control.titan_dashboard.feature_on' => 'on']);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertTrue($result);
    }

    public function testFeatureModulus(){
        config(['system_control.titan_dashboard.feature_on' => 'modulus:1']);
        $user = User::find(4);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertFalse($result);
        config(['system_control.titan_dashboard.feature_on' => 'modulus:4']);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertTrue($result);
        config(['system_control.titan_dashboard.feature_on' => 'modulus:4,1,3']);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertTrue($result);
        config(['system_control.titan_dashboard.feature_on' => 'modulus:2,3,9']);
        $result = $this->systemControl->featureStatus('feature_on', $user);
        $this->assertFalse($result);
    }

    public function testSystemControlMiddleware() {
        config(['system_control.status' => true]);
        Redis::shouldReceive('smembers')
            ->once()
            ->andReturn(['feature2_on:on']);

        $this->get("/");
        $this->assertTrue( config('system_control.titan_dashboard.feature2_on') === 'on');
    }

    public function testMultiplePagesOfSystemControlFeatures()
    {
            config(['system_control.status' => true]);
            Redis::shouldReceive('smembers')
                ->andReturn(
                    ['feature2_on:on',
                    'feature3_on:off',
                    'feature4_on:cows']
                );

            $this->get("/");
            $this->assertTrue( config('system_control.titan_dashboard.feature2_on') === 'on');
            $this->assertTrue( config('system_control.titan_dashboard.feature3_on') === 'off');
            $this->assertTrue( config('system_control.titan_dashboard.feature4_on') === 'cows');
    }
}
