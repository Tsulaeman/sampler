<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    private $user;
    private $book;
    private $token;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_checkout_checkin()
    {
        parent::setUp();
        $this->user = '';

        $this->user = User::factory()->create();
        $this->book = Book::factory()->create();

        $this->token = $this->user->createToken('authToken')->accessToken;

        $response = $this->json('GET', 'api/books/checkout/'. $this->book->id, [], [
            'Authorization' => 'Bearer '. $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent());

        $this->assertEquals(Book::CHECKED_OUT, $content->book->status);

        //================= Test Checkin ==============

        $response = $this->json('GET', 'api/books/checkin/'. $this->book->id, [], [
            'Authorization' => 'Bearer '. $this->token
        ]);

        $response->assertStatus(200);

        $content = json_decode($response->getContent());

        $this->assertEquals(Book::AVAILABLE, $content->book->status);
    }
}
