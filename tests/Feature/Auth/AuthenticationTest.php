<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'teacher@school.com',
            'password' => bcrypt('password123'),
            'role' => 'Subject Teacher',
        ]);

        $response = $this->post('/login', [
            'email' => 'teacher@school.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'teacher@school.com',
            'password' => bcrypt('password123'),
        ]);

        $this->post('/login', [
            'email' => 'teacher@school.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function users_can_not_authenticate_with_invalid_email(): void
    {
        $this->post('/login', [
            'email' => 'nonexistent@school.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function authenticated_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /** @test */
    public function authenticated_users_are_redirected_from_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function login_requires_email(): void
    {
        $response = $this->post('/login', [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function login_requires_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'teacher@school.com',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function login_throttles_after_too_many_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'teacher@school.com',
            'password' => bcrypt('password123'),
        ]);

        // Make 5 failed login attempts
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'teacher@school.com',
                'password' => 'wrong-password',
            ]);
        }

        // The 6th attempt should be throttled
        $response = $this->post('/login', [
            'email' => 'teacher@school.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    /** @test */
    public function different_user_roles_can_login(): void
    {
        $roles = ['Principal', 'Head Teacher', 'Subject Teacher', 'Adviser'];

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'email' => strtolower(str_replace(' ', '', $role)) . '@school.com',
                'password' => bcrypt('password123'),
                'role' => $role,
            ]);

            $response = $this->post('/login', [
                'email' => strtolower(str_replace(' ', '', $role)) . '@school.com',
                'password' => 'password123',
            ]);

            $this->assertAuthenticated();
            $response->assertRedirect(route('dashboard'));

            // Logout for next iteration
            $this->post('/logout');
        }
    }

    /** @test */
    public function remember_me_functionality_works(): void
    {
        $user = User::factory()->create([
            'email' => 'teacher@school.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'teacher@school.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $response->assertCookie('remember_web_' . sha1(User::class));
        $this->assertAuthenticated();
    }
}