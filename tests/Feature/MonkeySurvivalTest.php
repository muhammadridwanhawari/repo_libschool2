<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MonkeySurvivalTest extends TestCase
{
    /**
     * Monkey Test: Login Endpoint
     * Verifies that injecting bad data does not cause an Internal Server Error (500)
     */
    public function test_login_endpoint_survives_monkey_injection(): void
    {
        $payloads = [
            // SQL Injection attempts
            ['login' => "' OR 1=1 --", 'password' => 'password'],
            ['login' => "admin' #", 'password' => "' OR '1'='1"],
            ['login' => "'; DROP TABLE users; --", 'password' => 'abc'],
            
            // Null values
            ['login' => null, 'password' => null],
            ['login' => 'admin', 'password' => null],
            
            // Wrong data types (Arrays instead of strings)
            ['login' => ['admin'], 'password' => ['password']],
            
            // Random chaotic strings
            ['login' => '<script>alert("xss")</script>', 'password' => '123456'],
            ['login' => str_repeat('A', 5000), 'password' => 'password'], // Buffer overflow attempt
        ];

        foreach ($payloads as $payload) {
            $response = $this->post('/login', $payload);
            
            // The expectation is that the application handles this gracefully.
            // It should not throw a 500 Server Error. Usually it returns 302 (Redirect back with errors) 
            // or 422 Unprocessable Entity if it's an API.
            $this->assertNotEquals(500, $response->status(), 'Monkey Payload broke the server: ' . json_encode($payload));
        }
    }
}
