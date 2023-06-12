<?php

namespace Tests\Feature;

use App\Exceptions\UserAlreadyExistsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser()
    {
        $userData = [
            'name' => 'Findel Fofana',
            'email' => 'findel.fofana@user.ci',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User registered successfully',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    public function testRegisterUserWithExistingEmail()
    {
        $existingUser = User::factory()->create();

        $userData = [
            'name' => 'Findel Fofana',
            'email' => $existingUser->email,
            'password' => 'password123',
        ];

        $this->expectException(UserAlreadyExistsException::class);

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'User with this email already exists.',
            ]);
    }



    public function testUserLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'findel.fofana@user.ci',
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email' => 'findel.fofana@user.ci',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'user',
            ]);
    }


    public function testUserLoginWithInvalidCredentials()
    {
        $credentials = [
            'email' => 'findel.fofana@user.ci',
            'password' => 'invalidpassword',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Invalid email or password',
            ]);
    }

    public function testAuthenticatedUser()
    {

        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/me');

        $response->assertStatus(200)
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    public function testUnauthenticatedUser()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testUserLogout()
    {

        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }

    public function testRefreshToken()
    {

        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }
}
