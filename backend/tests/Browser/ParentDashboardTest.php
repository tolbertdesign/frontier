<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParentDashboardTest extends DuskTestCase
{
    /** @test */
    public function verifyParticipantCardShowsName(){
        $this->browse(function (Browser $browser) {
            $data = $this->registerFamilyPledgingOn();
            $browser->visit('/v3/home/dashboard')
                ->assertSee('View Rewards')
                ->assertSee($data['initialStudent']['first_name'])
                ->assertSee($data['secondStudent']['first_name']);
        });
    }

    /** @test */
    public function verifyMultiplePrograms(){
        $this->browse(function (Browser $browser) {
            $this->logout();
            $data = $this->registerFamilyPledgingOff();
            $browser->visit('/v3/home/dashboard')
                ->assertSee($data['initialStudent']['first_name'])
                ->assertSee($data['secondStudent']['first_name']);
        });
    }

    /** @test */
    public function verifyPhoneScript(){
        $this->logout();
        $this->registerFamilyPledgingOff();
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/v3/home/dashboard')
                ->waitForText('Use our Phone Script')
                ->clickLink('Use our Phone Script')
                ->waitForText('Hello, may I speak to')
                ->assertSee('Hello, may I speak to')
                ->click('div.modal.is-active button.close-button')
                ->waitUntilMissing('div.modal.is-active button.close-button')
                ->assertDontSee('I will call you next week to tell you how many reading challenges I have completed.');
                $browser->visit('/v3/home/dashboard')
                ->waitForText('Use our Phone Script')
                ->click('.phone-script-icon')
                ->waitForText('Hello, may I speak to')
                ->assertSee('Hello, may I speak to')
                ->press('button.close-button')
                ->pause(1000)
                ->assertDontSee('I will call you next week to tell you how many reading challenges I have completed.');

        });
    }

    private function logout(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/v3/logout');
        });
    }
    private function registerFamilyPledgingOn(){
        $this->registerParent();
        $initialStudent = $this->registerInitialStudent();
        $secondStudent = $this->registerSecondStudentFamilyPledgeOn();
        $this->finishRegistration();
        $data = [
            'initialStudent' => $initialStudent,
            'secondStudent' => $secondStudent
        ];
        return $data;
    }
    private function registerFamilyPledgingOff(){
        $this->registerParent();
        $initialStudent = $this->registerInitialStudent();
        $secondStudent = $this->registerSecondStudentFamilyPledgeOff();
        $this->finishRegistration();
        $data = [
            'initialStudent' => $initialStudent,
            'secondStudent' => $secondStudent
        ];
        return $data;
    }
    private function registerSingleStudent(){
        $this->registerParent();
        $this->registerInitialStudent();
        $this->finishRegistration();
    }
    private function registerParent(){
            $parentRegistration = new ParentRegistrationTest();
            $parentRegistration->loadWelcome();
            $parentRegistration->selectParent();
            $parentRegistration->emailRegistration();
            $parentRegistration->registerParent();
    }

    private function registerInitialStudent(){
            $parentRegistration = new ParentRegistrationTest();
            $parentRegistration->searchSchool();
            $parentRegistration->schoolSelection();
            $user = $parentRegistration->participantRegistration();
            return $user;
    }

    private function registerSecondStudentFamilyPledgeOff(){
        $parentRegistration = new ParentRegistrationTest();
        $parentRegistration->registerAnotherParticipant();
        $parentRegistration->searchAnotherSchool();
        return $parentRegistration->registerParticipantFamilyPledgingOff();
    }

    private function registerSecondStudentFamilyPledgeOn(){
        $parentRegistration = new ParentRegistrationTest();
        $parentRegistration->registerAnotherParticipant();
        $parentRegistration->searchAnotherSchool();
        return $parentRegistration->registerParticipantFamilyPledgingOn();
    }

    private function finishRegistration(){
        $parentRegistration = new ParentRegistrationTest();
        $parentRegistration->finishRegistration();
    }
}
