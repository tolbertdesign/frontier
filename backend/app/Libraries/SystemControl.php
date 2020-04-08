<?php

namespace App\Libraries;

use App\Entities\Participant;
use App\Entities\Program;
use App\Entities\User;
use Exception;
use Tests\Unit\ParticipantPledgeTotalTest;

class SystemControl
{
    private $programs;

    public function checkIfGloballyOn($controlName)
    {
        $features = config('system_control.titan_dashboard');
        if (! $features || ! array_key_exists($controlName, $features)) {
            return false;
        }

        $status = $features[$controlName];
        return $this->isOn($status);
    }

    public function featureStatus($controlName, User $parentUser)
    {
        $features = config('system_control.titan_dashboard');
        if (! $features || ! array_key_exists($controlName, $features)) {
            return false;
        }

        $status = $features[$controlName];
        if ($this->isOn($status)) {
            return true ;
        } elseif ($this->isParity($status, $parentUser)) {
            return true;
        } elseif ($this->isGoogleOptimize($status)) {
            return true;
        } elseif ($this->isPrograms($status, $parentUser)) {
            return true;
        } elseif ($this->isModulus($status, $parentUser)) {
            return true;
        }
        return false;
    }

    private function isOn($status)
    {
        if (strtolower($status) === 'on') {
            return true ;
        }
        return false;
    }

    private function isParity($status, $parentUser)
    {
        if (strtolower($status) === 'parity' && isset($parentUser) && $parentUser->id % 2) {
            return true;
        }
        return false;
    }

    private function isGoogleOptimize($status)
    {
        if (strpos(strtolower($status), 'google_optimize:') !== false) {
            $experiment = substr($status, 16);
            // Add google optimize data here
        }
        return false;
    }

    private function isPrograms($status, $parentUser)
    {
        if (strpos(strtolower($status), 'programs:') !== false) {
            if (! $this->programs) {
                $this->loadPrograms($parentUser);
            }
            $programs = explode(',', substr($status, 9));
            if (count(array_intersect($programs, $this->programs)) > 0) {
                return true;
            }
        }
    }

    /** For modulus mode we check the last digit of the ID.
     *  ID % 10 = id;
     */
    private function isModulus($status, $parentUser)
    {
        if (strpos(strtolower($status), 'modulus:') !== false && isset($parentUser)) {
            $activeIds = explode(',', substr($status, 8));

            $id = $parentUser->id % 10;

            if (in_array($id, $activeIds)) {
                return true;
            }
            return false;
        }
    }

    private function loadPrograms($parentUser)
    {
        $programs = [];
        $count    = 0;
        $parentUser->getActiveParticipants()->each(function ($participant) use ($programs, $count) {
            $this->programs[] .= $participant->getProgram()->salesforce_id;
        });
        array_merge($this->programs, $programs);
    }
}
