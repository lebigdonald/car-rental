<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_login_form()
    {
        $response = $this->get('/admin/connexion');
        $response->assertStatus(200);
    }

    public function test_admin_can_login()
    {
        $admin = Admin::factory()->create([
            'password' => 'password', // Model mutator will hash this
        ]);

        $response = $this->post('/admin/connexion', [
            'username' => $admin->username,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_can_logout()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/deconnexion');

        $response->assertRedirect('/admin/connexion');
        $this->assertGuest('admin');
    }
}
