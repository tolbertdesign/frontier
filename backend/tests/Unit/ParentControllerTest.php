<?php

namespace Tests\Unit;

use App\Entities\User;
use App\Http\Controllers\ParentController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class ParentControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function updateSuccess()
    {
        //having
        $userData = [
            'first_name' => 'johnny',
            'last_name'  => 'john',
            'email'      => 'john@john.com',
            'phone'      => '1234567890',
            'dob'        => '1900-01-01',
        ];
        $user = factory(User::class)->create();
        $this->assertDatabaseMissing('users', $userData);

        //when
        $response = $this->actingAs($user)
            ->post('/v3/parent/update', $userData);

        //then
        $response->assertStatus(200);
        $userData['username'] = $userData['email'];
        $this->assertDatabaseHas('users', $userData);
    }
}
