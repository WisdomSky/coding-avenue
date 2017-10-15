<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\MailTracking;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PasswordTest extends TestCase
{
    use DatabaseMigrations, MailTracking;

    /** @test */
    public function a_user_can_request_password_reset_link()
    {
        $role = 'vendor administrator';
        $user = factory(User::class)->create();
        $user->assignRole($role);

        $response = $this->json('POST', '/password/email', [
            'email' => $user->email
        ]);

        $token = $user->fresh()->passwordReset->token;

        $response->assertStatus(200);
        $this->seeEmailWasSent()
             ->seeEmailSubject('Password Reset')
             ->seeEmailTo($user->email)
             ->seeEmailContains(route('password.reset', ['token' => $token]));
    }

    /** @test */
    public function a_user_can_reset_their_password_using_a_valid_reset_link()
    {
        $role = 'vendor administrator';
        $user = factory(User::class)->create();
        $user->assignRole($role);

        $response = $this->json('POST', '/password/email', [
            'email' => $user->email
        ]);

        $token = $user->fresh()->passwordReset->token;
        $new_password = 'qwertyghg';

        $response = $this->json('POST', '/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => $new_password,
            'password_confirmation' => $new_password
        ]);

        $this->assertTrue(Hash::check($new_password, $user->fresh()->password));
    }
}
