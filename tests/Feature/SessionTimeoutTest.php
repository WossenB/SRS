<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SessionTimeoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_session_times_out_after_30_minutes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate 31 minutes passing
        session(['last_activity' => now()->subMinutes(31)]);

        $response = $this->get('/dashboard');

        $this->assertFalse(auth()->check());
        $response->assertRedirect(route('login'));
    }

    public function test_session_resets_on_activity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        session(['last_activity' => now()->subMinutes(15)]);

        $this->get('/dashboard');

        $this->assertTrue(auth()->check());
        $this->assertTrue(session('last_activity')->diffInMinutes(now()) < 1);
    }
}
