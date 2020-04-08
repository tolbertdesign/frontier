<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\RegisterPage;
use Tests\Browser\Pages\DashboardPage;
use App\Entities\User;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\DB;

class ParentRegistrationTest extends DuskTestCase
{
    private function logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/logout');
        });
    }
    /** @test */
    public function loadWelcome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/logout');
            $browser->visit(new RegisterPage)
                ->pause(500) //waiting for animation
                ->waitForText('Welcome!')
                ->assertSee('Welcome!')
                ->assertSee('Becoming a fundraising hero is now easier than ever.');
        });
    }

    /** @test */
    public function selectParent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegisterPage)
                ->click('@parent-registration')
                ->waitForText('Google Account')
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
    public function registerParent()
    {
        $user = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->type('@firstName', $user->first_name)
                ->type('@lastName', $user->last_name)
                ->type('@email', $user->email)
                ->type('@emailConfirmation', $user->email)
                ->type('@password', 'Secret1!')
                ->type('@phone', $user->phone);
            $browser->select('month', 3)
                ->select('day', 22)
                ->select('year', 1983)
                ->click('@createAccount')
                ->waitForText('Search for a school or event', 10)
                ->assertSee('Click here for help searching for your school');
        });

        return $user;
    }

    /** @test */
    public function searchSchool()
    {
        $this->browse(function (Browser $browser) {
            $browser->type('@schoolSearch', 'sales')
                ->waitForText('Salesforce Test')
                ->assertSee('Salesforce /@$!%^&*() Kenny');
        });
    }

    /** @test */
    public function schoolSelection()
    {
        $this->browse(function (Browser $browser) {
            $browser->waitForText('Salesforce /@$!%^&*() Kenny')
                ->click('.list-group-item')
                ->waitForText('Register Student')
                ->assertSee('Student First Name')
                ->assertSee('Student Last Name')
                ->assertSee('Select Classroom')
                ->assertSee('I agree to the terms of participation')
                ->assertSee('Add Student');
        });
    }

    /** @test */
    public function participantRegistration()
    {
        $user  = '';
        $this->browse(function (Browser $browser) use (&$user) {
            $user = factory(User::class)->make();
            $browser->type('@firstName', $user->first_name)
                ->type('@lastName', $user->last_name)
                ->check('participation_terms')
                ->select('classroom', '126106')
                ->press('Add Student')
                ->waitForText('Awesome!', 15)
                ->assertSee('Do you need to add another student?');
            return $user;
        });
        return $user;
    }

    /** @test */
    public function registerAnotherParticipant()
    {
        $this->browse(function (Browser $browser) {
            $browser->press('Yes')
                ->waitForText('Search for a school or event')
                ->assertSee('Search for a school or event');
        });
    }

    /** @test */
    public function searchAnotherSchool()
    {
        $this->searchSchool();
        $this->schoolSelection();
    }

    /** @test */
    public function registerParticipantFamilyPledgingOn()
    {
        $this->browse(function (Browser $browser) {
            $browser->assertSee('Enable Family Pledging')
                ->pause(500);
        });
        return $this->participantRegistration();
    }

    public function registerParticipantFamilyPledgingOff()
    {
        $this->browse(function (Browser $browser) {
            $browser->assertSee('Enable Family Pledging')
                ->click('.v-switch-core');
        });
        return $this->participantRegistration();
    }

    /** @test */
    public function finishRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->clickLink('No')
                ->assertPathBeginsWith('/v3/home/dashboard');
        });
    }

    /** @test */
    public function partialRegistration()
    {
        $this->logout();
        $this->loadWelcome();
        $this->selectParent();
        $this->emailRegistration();
        $user = $this->registerParent();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/v3/logout')
                ->waitForText('Welcome!')
                ->assertSee('Get started here');
            $browser->clickLink('Login')
                ->waitForText('Remember Me')
                ->type('@email', $user->email)
                ->type('@password', 'Secret1!')
                ->press('Login')
                ->waitForText('Welcome Back')
                ->assertSee('I\'m a Parent')
                ->assertSee('I\'m a Teacher');
        });
    }

    public function testImageUploadModal()
    {
        $this->logout();
        $this->loadWelcome();
        $this->selectParent();
        $this->emailRegistration();
        $this->registerParent();
        $this->searchSchool();
        $this->schoolSelection();
        $this->browse(function (Browser $browser) {
            $browser->click('#upload-photo')
                ->waitForText('Zoom in on your student\'s face to create a personalized Student Star video!')
                ->assertSee('Zoom in on your student\'s face to create a personalized Student Star video!')
                ->assertDisabled('.image-upload-save-btn')
                ->attach('#uploadPhotoModal > div > div > div > div:nth-child(4) > div.w-150px.position-relative.mx-auto > div > input[type="file"]', 'public/img/bg-hand-stack.jpg')
                ->pause(500)
                ->assertEnabled('.image-upload-save-btn')
                ->assertSee('Delete photo')
                ->assertSee('Your Student Star video may take an hour to create. We will email you when it is ready!')
                ->click('.delete-photo-btn')
                ->assertDontSee('Delete photo')
                ->assertDontSee('Your Student Star video may take an hour to create. We will email you when it is ready!')
                ->assertDisabled('.image-upload-save-btn');
        });
    }

    public function testImageUploadStoreToRegisterPage()
    {
        $this->loadWelcome();
        $this->selectParent();
        $this->emailRegistration();
        $this->registerParent();
        $this->searchSchool();
        $this->schoolSelection();
        $this->browse(function (Browser $browser) {
            $browser->click('#upload-photo')
                ->attach('#uploadPhotoModal > div > div > div > div:nth-child(4) > div.w-150px.position-relative.mx-auto > div > input[type="file"]', 'public/img/bg-hand-stack.jpg')
                ->pause(500)
                ->assertEnabled('.image-upload-save-btn')
                ->press('Save')
                ->pause(500)
                ->assertDontSee('Zoom in on your student\'s face to create a personalized Student Star video!')
                ->assertSee('Register Student')
                ->assertDontSee('Optional')
                ->assertSee('Edit Photo');
        });
    }

    public function testImageUploadOnAddParticipant()
    {
        $this->loadWelcome();
        $this->selectParent();
        $this->emailRegistration();
        $this->registerParent();
        $this->searchSchool();
        $this->schoolSelection();
        $this->browse(function (Browser $browser) {
            $browser->click('#upload-photo')
                ->attach('#uploadPhotoModal > div > div > div > div:nth-child(4) > div.w-150px.position-relative.mx-auto > div > input[type="file"]', 'public/img/bg-hand-stack.jpg')
                ->pause(500)
                ->assertEnabled('.image-upload-save-btn')
                ->press('Save')
                ->pause(500)
                ->assertDontSee('Zoom in on your student\'s face to create a personalized Student Star video!')
                ->assertSee('Register Student')
                ->assertDontSee('Optional')
                ->assertSee('Edit Photo');
        });
        $this->participantRegistration();
        $this->browse(function (Browser $browser) {
            $browser->pause(750);
        });
        $profile = DB::table('user_profiles')->orderBy('id', 'desc')->first();
        $this->assertAttributeNotEmpty('image_name', $profile);
    }

    /** @test **/
    public function registerDuplicateParticipant()
    {
        $this->logout();
        $this->loadWelcome();
        $this->selectParent();
        $this->emailRegistration();
        $this->registerParent();
        $this->searchSchool();
        $this->schoolSelection();
        $user = factory(User::class)->make();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->type('@firstName', $user->first_name)
                ->type('@lastName', $user->last_name)
                ->check('participation_terms')
                ->select('classroom', '126106')
                ->press('Add Student')
                ->waitForText('Awesome!')
                ->assertSee('Do you need to add another student?');
            return $user;
        });
        $participant = $this->browse(function (Browser $browser) {
            $browser->press('Yes');
        });
        $this->searchSchool();
        $this->schoolSelection();
        $participant = $this->browse(function (Browser $browser) use ($user) {
            $browser->pause(5000)->type('@firstName', $user->first_name)
                ->type('@lastName', $user->last_name)
                ->check('participation_terms')
                ->select('classroom', '126106')
                ->press('Add Student')
                ->waitForText('This student is already registered. Please contact the person who registered him or her for a link to pledge.')
                ->assertSee('This student is already registered. Please contact the person who registered him or her for a link to pledge.');
        });
    }

    /** test **/
    public function testInvalidPasswordResetNeedsUppercaseLetter()
    {
        $this->loadWelcome();
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/password/reset/123')
                ->waitForText('Change Password')
                ->type('@email', 'random@email.com')
                ->type('@password', 'badpass1!')
                ->type('@passwordConfirmation', 'badpass1!')
                ->press('Update')
                ->assertSee('The password field must have at least one uppercase letter.');
        });
    }

    /** test **/
    public function testInvalidPasswordResetNeedsLowercaseLetter()
    {
        $this->loadWelcome();
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/password/reset/123')
                ->waitForText('Change Password')
                ->type('@email', 'random@email.com')
                ->type('@password', 'BADPASS1!')
                ->type('@passwordConfirmation', 'BADPASS1!')
                ->press('Update')
                ->assertSee('The password field must have at least one lowercase letter.');
        });
    }

    /** test **/
    public function testInvalidPasswordResetNeedsNumber()
    {
        $this->loadWelcome();
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/password/reset/123')
                ->waitForText('Change Password')
                ->type('@email', 'random@email.com')
                ->type('@password', 'Badpass!')
                ->type('@passwordConfirmation', 'Badpass!')
                ->press('Update')
                ->assertSee('The password field must have at least one number.');
        });
    }

    /** test **/
    public function testInvalidPasswordResetNeedsSpecialCharacter()
    {
        $this->loadWelcome();
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/password/reset/123')
                ->waitForText('Change Password')
                ->type('@email', 'random@email.com')
                ->type('@password', 'Badpass1')
                ->type('@passwordConfirmation', 'Badpass1')
                ->press('Update')
                ->assertSee('The password field must have at least one special character. !@#$%^&*()\-_=+{};:,<.>§~');
        });
    }

    /** test **/
    public function testInvalidPasswordResetMinLength()
    {
        $this->loadWelcome();
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/password/reset/123')
                ->waitForText('Change Password')
                ->type('@email', 'random@email.com')
                ->type('@password', 'Bad1!')
                ->type('@passwordConfirmation', 'Bad1!')
                ->press('Update')
                ->assertSee('The password field must have at least ' . env('PASSWORD_MIN_LENGTH') . ' characters.');
        });
    }

    /** test **/
    public function testInvalidPasswordResetMaxLength()
    {
        $this->loadWelcome();
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/password/reset/123')
                ->waitForText('Change Password')
                ->type('@email', 'random@email.com')
                ->type('@password', 'Badpassword1!WithWayTooManyCharactersForTheTest')
                ->type('@passwordConfirmation', 'Badpassword1!WithWayTooManyCharactersForTheTest')
                ->press('Update')
                ->assertSee('The password field cannot contain more than ' . env('PASSWORD_MAX_LENGTH') . ' characters.');
        });
    }

    /** test **/
    public function testInvalidPasswordResetPasswordConfirmation()
    {
        $this->loadWelcome();
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/password/reset/123')
                ->waitForText('Change Password')
                ->type('@email', 'random@email.com')
                ->type('@password', 'Badpassword1!')
                ->type('@passwordConfirmation', 'Badpassword2!')
                ->press('Update')
                ->assertSee('The password confirmation does not match.');
        });
    }
}
