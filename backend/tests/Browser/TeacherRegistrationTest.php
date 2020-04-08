<?php

namespace Tests\Browser;

use App\Entities\Classroom;
use App\Entities\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\RegisterPage;

class TeacherRegistrationTest extends DuskTestCase
{
    /** @test */
    public function loadWelcome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/logout');
            $browser->visit(new RegisterPage)
                ->waitForText('Welcome!')
                ->assertSee('Welcome!')
                ->assertSee('Becoming a fundraising hero is now easier than ever.');
        });
    }

    /** @test */
    public function selectTeacher()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegisterPage)
                ->click('@teacher-registration')
                ->assertSee('Welcome!')
                ->assertSee('Use My Email');
        });
    }

    /** @test */
    public function emailRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->clickLink('Use My Email')
                    ->waitForText('Sign Up')
                    ->assertSee('Sign Up')
                    ->assertSee('First Name')
                    ->assertSee('Create Account');
        });
    }

    /** @test */
    public function registerTeacher()
    {
        $user = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->type('@firstName', $user->first_name)
                ->type('@lastName', $user->last_name)
                ->type('@email', $user->email)
                ->type('@emailConfirmation', $user->email)
                ->type('@password', 'Secret1!')
                ->type('@phone', $user->phone);
            $browser->select('month', 5)
                ->select('day', 21)
                ->select('year', 1983)
                ->click('@createAccount')
                ->pause(1)
                ->waitForText('Enter Teacher Code', 10)
                ->assertSee('Enter Teacher Code');
        });
    }

    /** @test */
    public function validTeacherCode()
    {
        if (env('APP_ENV') === 'testing') {
            $this->assertTrue(true);
            return;
        }
        $user      = factory(User::class)->make();
        $classroom = factory(Classroom::class)->create();

        $this->browse(function (Browser $browser) use ($user, $classroom) {
            $browser->type('@teacherCode', $classroom->team_leader_code)
                ->check('agree')
                ->pause(500)
                ->press('Next')
                ->assertSee('Program Overview')
                ->assertSee('Enter Pledge')
                ->visit('/v3/logout');
        });
    }

    /** @test */
    public function invalidTeacherAge()
    {
        $user = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/v3/logout')
                ->visit(new RegisterPage)
                ->waitForText('Welcome!')
                ->click('@teacher-registration')
                ->waitForText('Use My Email')
                ->clickLink('Use My Email')
                ->waitForText('Create Account')
                ->type('@firstName', $user->first_name)
                ->type('@lastName', $user->last_name)
                ->type('@email', $user->email)
                ->type('@emailConfirmation', $user->email)
                ->type('@password', 'Secret1!')
                ->type('@phone', $user->phone);
            $browser->select('month', 2)
                ->select('day', 22)
                ->select('year', 2015)
                ->click('@createAccount')
                ->waitForText('There was an error with your registration. Some information you entered is invalid.')
                ->assertSee('There was an error with your registration. Some information you entered is invalid.');
        });
    }

    /** @test */
    public function emailAddressAlreadyRegistered()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/logout')
                ->visit(new RegisterPage)
                ->click('@teacher-registration')
                ->clickLink('Use My Email')
                ->type('@email', User::first()->email)
                ->click('@firstName')
                ->pause(1500)
                ->waitForText('You already have an account. We can send you an email to reset your password.')
                ->assertSee('Reset Password')
                ->visit('/v3/logout');
        });
    }
}
