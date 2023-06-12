<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    /** @test */

    public function test_admin_can_login()
    {
        $admin = User::factory()->create(['type' => 1]);

        $credentials = [
            'username' => $admin->username,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/auth/login', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'status']);
    }

    public function test_user_with_non_admin_type_cannot_login()
    {
        $user = User::factory()->create(['type' => 0]);

        $credentials = [
            'username' => $user->username,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/auth/login', $credentials);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid login details.', 'status' => 'error']);
    }

    public function test_admin_can_logout()
    {
        $admin = User::factory()->create(['type' => 1]);

        $token = $admin->createToken('test-token')->plainTextToken;

        $response = $this->actingAs($admin)
            ->postJson('/api/auth/logout', ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);
    }
}
