<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'role' => 'siswa',
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('siswa.halaman', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->from('/login')->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('password');
    }

    public function test_login_is_locked_for_one_minute_after_five_failed_attempts(): void
    {
        Cache::flush();

        $user = User::factory()->create();

        for ($attempt = 1; $attempt < 5; $attempt++) {
            $response = $this->from('/login')->post('/login', [
                'username' => $user->username,
                'password' => 'wrong-password',
            ]);

            $response->assertRedirect('/login');
            $response->assertSessionHasErrors('password');
        }

        $response = $this->from('/login')->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('throttle');
        $response->assertSessionHas('login_popup', function (?array $popup): bool {
            return is_array($popup)
                && ($popup['type'] ?? null) === 'warning'
                && ($popup['retry_after'] ?? null) === 60;
        });
    }

    public function test_login_is_blocked_for_one_hour_after_ten_more_failed_attempts(): void
    {
        Cache::flush();

        $user = User::factory()->create();

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->from('/login')->post('/login', [
                'username' => $user->username,
                'password' => 'wrong-password',
            ]);
        }

        $this->travel(61)->seconds();

        for ($attempt = 1; $attempt < 10; $attempt++) {
            $response = $this->from('/login')->post('/login', [
                'username' => $user->username,
                'password' => 'wrong-password',
            ]);

            $response->assertRedirect('/login');
            $response->assertSessionHasErrors('password');
        }

        $response = $this->from('/login')->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('throttle');
        $response->assertSessionHas('login_popup', function (?array $popup): bool {
            return is_array($popup)
                && ($popup['type'] ?? null) === 'blocked'
                && ($popup['retry_after'] ?? null) === 3600;
        });
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
