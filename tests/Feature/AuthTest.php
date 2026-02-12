<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_registration_form()
    {
        $response = $this->get('/inscription');
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/inscription', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'date_of_birth' => '1990-01-01',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_user_can_view_login_form()
    {
        $response = $this->get('/connexion');
        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => 'password', // Model mutator will hash this
        ]);

        $response = $this->post('/connexion', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/deconnexion');

        $response->assertRedirect('/connexion');
        $this->assertGuest();
    }
}
