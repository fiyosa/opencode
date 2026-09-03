<?php

namespace Tests\Feature\Auth;

use App\Domain\Core\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LogoutTest extends TestCase
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

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        Passport::actingAs($user);

        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Logged out successfully']);
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertStatus(401);
    }
}
