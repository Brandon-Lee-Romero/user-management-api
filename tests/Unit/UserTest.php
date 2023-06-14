<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['type' => 1]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $user = [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->address(),
            'postcode' => fake()->postcode(),
            'contact_number' => substr_replace(str_replace('+', '', fake()->unique()->e164PhoneNumber()), '09', 0, 2),
            'email' => fake()->unique()->safeEmail(),
            'username' =>  fake()->unique()->userName(),
            'password' => 'password',
            'password_confirmation' => "password"
        ];

        $response = $this->actingAs($admin)
            ->postJson('/api/users', $user, ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function test_admin_can_get_user(): void
    {
        $admin = User::factory()->create(['type' => 1]);

        $user = User::factory()->create(['type' => 0]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $response = $this->actingAs($admin)->getJson('/api/users/' . $user->id,  ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200)->assertJsonStructure(['status', 'message', 'data']);
    }


    public function test_admin_can_list_users(): void
    {
        $admin = User::factory()->create(['type' => 1]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $response = $this->actingAs($admin)->getJson('/api/users', ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200)->assertJsonStructure(['status', 'message', 'data']);
    }

    public function test_admin_can_search_created_users(): void
    {

        $admin = User::factory()->create(['type' => 1]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $user1 = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
        $user2 = User::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);

        $response = $this->actingAs($admin)->getJson('/api/users?search=John', ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200)->assertSee($user1->name)->assertDontSee($user2->name);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->create(['type' => 1]);

        $user = User::factory()->create(['type' => 0]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $updateValues = [
            "username" => "olson.sammie",
            "postcode" => "97922"
        ];

        $updateResponse = $this->actingAs($admin)->putJson('/api/users/' . $user->id, $updateValues, ['Authorization' => 'Bearer ' . $token]);

        $updateResponse->assertStatus(200)->assertJson(['status' => 'success', 'message' => 'User updated successfully']);

        $getUpdatedResponse = $this->actingAs($admin)->getJson('/api/users/' . $user->id, ['Authorization' => 'Bearer ' . $token]);

        $getUpdatedResponse->assertStatus(200)->assertSee($updateValues['username'])->assertSee($updateValues['postcode']);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create(['type' => 1]);

        $user = User::factory()->create(['type' => 0]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $response = $this->actingAs($admin)->deleteJson('/api/users/' . $user->id,  ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }

    public function test_admin_can_delete_multiple_user(): void
    {
        $admin = User::factory()->create(['type' => 1]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $user1 = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
        $user2 = User::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);

        $response = $this->actingAs($admin)->deleteJson('/api/users/bulk-destroy', ["id" => [$user1->id, $user2->id]], ['Authorization' => 'Bearer ' . $token]);


        $response->assertStatus(200)->assertJsonStructure(['status', 'message']);
    }

    public function test_admin_cant_see_deleted_users()
    {
        $admin = User::factory()->create(['type' => 1]);

        $token = $admin->createToken('test-token', ['admin'])->plainTextToken;

        $response = $this->actingAs($admin)->getJson('/api/users',  ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200)->assertDontSee(['John', 'Jane']);
    }
}
