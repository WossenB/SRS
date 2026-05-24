<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RateLimitingTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_rate_limited_after_5_attempts()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'test@test.com', 'password' => 'wrong']);
        }

        $response = $this->post('/login', ['email' => 'test@test.com', 'password' => 'wrong']);
        $response->assertStatus(429); // Too Many Requests
    }
}
