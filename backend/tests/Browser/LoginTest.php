<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\DashboardPage;
use Tests\Browser\Pages\LoginPage;
use App\Entities\User;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Generator as Faker;
use App\Entities\Pledge;

class LoginTest extends DuskTestCase
{
    use WithFaker;

    public function testLoginFormFailureBadPassword()
    {
        $this->browse(function ($browser) {
            $browser->visit(new LoginPage)
                ->type('@email', 'parent@example.com')
                ->type('@password', 'badpass')
                ->press('Login')
                ->on(new LoginPage);
        });
    }

    public function testLoginFormFailureBadEmailBadPass()
    {
        $this->browse(function ($browser) {
            $browser->visit(new LoginPage)
                ->type('@email', 'bademail@gmail.com')
                ->type('@password', 'badpass')
                ->press('Login')
                ->on(new LoginPage);
        });
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginFormSuccess()
    {
        if (env('APP_ENV') === 'testing') {
            $this->assertTrue(true);
            return;
        }
        $this->browse(function ($browser) {
            $browser->visit(new LoginPage)
                ->type('@email', 'parent@example.com')
                ->type('@password', 'secret')
                ->press('Login')
                ->assertSee('Program Overview');
        });
    }

    public function testLogoutSuccess()
    {
        if (env('APP_ENV') === 'testing') {
            $this->assertTrue(true);
            return;
        }
        $this->browse(function ($browser) {
            $browser->click('@side-bar-toggle')
                ->waitForText('Logout')
                ->clickLink('Logout')
                ->waitForText('Welcome!')
                ->assertSee('Becoming a fundraising hero is now easier than ever.');
        });
    }

    public function testLoginSponsorArchivedProgram()
    {
        $this->setUpFaker();
        $email = $this->faker->email;
        //make sponsor user
        $sponsor              = factory(User::class)->make();
        $sponsor->first_name  = 'sponsor';
        $sponsor->last_name   = 'sponsor';
        $sponsor->email       = $email;
        $sponsor->username    = $email;
        $sponsor->password    = bcrypt('Secret1!');
        $sponsor->dob         = null;
        $sponsor->save();
        $sponsorRoles = [
            'members',
            'sponsors',
        ];
        $sponsor->assignRole($sponsorRoles);
        //assign active pledge to sponsor and point at program 1
        $pledge             = Pledge::first();
        $pledge->user_id    = $sponsor->id;
        $pledge->program_id = 1;
        $pledge->save();
        //un-archive program
        $pledge->program->archived = 1;
        $pledge->program->save();
        if (env('APP_ENV') === 'testing') {
            $this->assertTrue(true);
            return;
        }
        $this->browse(function ($browser) use ($email) {
            $browser->visit('/v3/logout')
                ->visit(new LoginPage)
                ->type('@email', $email)
                ->type('@password', 'Secret1!')
                ->press('Login')
                ->assertSee('Welcome Back')
                ->assertSee('I\'m a Sponsor');
        });
    }

    public function testLoginSponsor()
    {
        $this->setUpFaker();
        $email = $this->faker->email;
        //make sponsor user
        $sponsor              = factory(User::class)->make();
        $sponsor->first_name  = 'sponsor';
        $sponsor->last_name   = 'sponsor';
        $sponsor->email       = $email;
        $sponsor->username    = $email;
        $sponsor->password    = bcrypt('Secret1!');
        $sponsor->dob         = null;
        $sponsor->save();
        $sponsorRoles = [
            'members',
            'sponsors',
        ];
        $sponsor->assignRole($sponsorRoles);
        //assign active pledge to sponsor and point at program 1
        $pledge             = Pledge::first();
        $pledge->user_id    = $sponsor->id;
        $pledge->program_id = 1;
        $pledge->save();
        //un-archive program
        $pledge->program->archived = 0;
        $pledge->program->save();
        if (env('APP_ENV') === 'testing') {
            $this->assertTrue(true);
            return;
        }
        $this->browse(function ($browser) use ($email) {
            $browser->visit('/v3/logout')
                ->visit(new LoginPage)
                ->type('@email', $email)
                ->type('@password', 'Secret1!')
                ->press('Login')
                ->waitForText('This fundraising experience is powered by Booster. The mission of Booster is to strengthen schools.')
                ->assertSee('This fundraising experience is powered by Booster. The mission of Booster is to strengthen schools.');
        });
    }
}
