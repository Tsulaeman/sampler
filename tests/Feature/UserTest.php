<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::factory()->create();

        $response = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertNotNull($content->token);
    }

    public function test_register()
    {
        $user = User::factory()->make();
        $data = $user->toArray();
        $data['password'] = 'Password42';
        $response = $this->json('POST', 'api/auth/register', $data);

        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertNotNull($content->token);
    }
}
