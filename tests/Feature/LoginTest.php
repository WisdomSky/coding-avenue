<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_login_if_credentials_is_correct_and_is_active()
    {
        $role = 'vendor administrator';
        $user = factory(User::class)->create();
        $user->assignRole($role);

        $response = $this->json('POST', '/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'login success.'
            ]);
    }
}
