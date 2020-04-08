<?php

namespace Tests\Unit;

use App\Libraries\Auth\GoogleOAuth;
use Tests\TestCase;
use App\Libraries\Auth\OAuthFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OAuthFactoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test for getting an invalid OAuth provider exception
     *
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
     */
    public function testGetInvalidOAuth()
    {
        $oAuthProvider = new OAuthFactory();
        $oAuthProvider->getOAuth('Foo');
    }

    /**
     * A test for getting a valid OAuth provider (google)
     *
     * @return void
     */
    public function testGetValidOAuth()
    {
        $oAuthProvider = new OAuthFactory();
        $validProvider = $oAuthProvider->getOAuth('google');
        $this->assertInstanceOf(GoogleOAuth::class, $validProvider);
    }
}
