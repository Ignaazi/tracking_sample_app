<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_login_accepts_nik_and_password(): void
    {
        User::create([
            'name' => 'Administrator Amcor',
            'nik' => '123456',
            'password' => Hash::make('admin123'),
            'role' => 'Administrator',
        ]);

        $response = $this->post('/login', [
            'nik' => '123456',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_api_login_requires_the_nik_field(): void
    {
        $response = $this->postJson('/api/login', [
            'password' => 'admin123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nik']);
    }

    public function test_api_login_accepts_nik_and_password(): void
    {
        User::create([
            'name' => 'Administrator Amcor',
            'nik' => '123456',
            'password' => Hash::make('admin123'),
            'role' => 'Administrator',
        ]);

        $response = $this->postJson('/api/login', [
            'nik' => '123456',
            'password' => 'admin123',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('user.nik', '123456');
    }
}
