<?php

namespace Tests\Feature\Auth;

use App\Domain\Core\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');

        DB::table('oauth_clients')->insert([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'name' => 'Test Personal Access Client',
            'secret' => null,
            'provider' => null,
            'redirect' => '',
            'grant_types' => '["personal_access"]',
            'revoked' => false,
            'personal_access_client' => true,
            'password_client' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->artisan('db:seed', ['class' => 'DatabaseSeeder']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['id', 'username', 'email', 'created_at'],
                'message',
            ])
            ->assertJson(['message' => 'Login successful', 'success' => true])
            ->assertCookie('token');
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@gmail.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_user_cannot_login_without_email(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'password' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_login_without_password(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@gmail.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
}
