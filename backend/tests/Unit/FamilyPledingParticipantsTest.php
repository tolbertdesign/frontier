<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Shared\FamilyPledging;
use App\Entities\User;

class FamilyPledingParticipantsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetFamilyParticipantsSuccess()
    {
        $participant   = User::where('email', 'parent@boosterthon.com')
            ->first()
            ->participants
            ->first();
        $familyPleding = new FamilyPledging();
        $this->assertCount(2, $familyPleding->participants($participant));
    }

    public function testDisplayNames1()
    {
        $users = collect([
            (object)[
                'first_name' => 'john'
            ],
        ]);
        $this->assertEquals('john', FamilyPledging::displayNames($users));
    }

    public function testDisplayNames2()
    {
        $users = collect([
            (object)[
                'first_name' => 'john'
            ],
            (object)[
                'first_name' => 'sally'
            ],
        ]);
        $this->assertEquals('john and sally', FamilyPledging::displayNames($users));
    }

    public function testDisplayNames3()
    {
        $users = collect([
            (object)[
                'first_name' => 'sue'
            ],
            (object)[
                'first_name' => 'sally'
            ],
            (object)[
                'first_name' => 'john'
            ],
        ]);
        $this->assertEquals('sue, sally and john', FamilyPledging::displayNames($users));
    }
}
