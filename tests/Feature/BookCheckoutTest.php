<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Author;
use App\Models\Reservation;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {
        $this->withoutExceptionHandling();
        $book =  Book::factory()->count(1)->create()->first();
        $user = User::factory()->count(1)->create()->first();
        $this
        ->actingAs($user)
        ->post('/checkout/' . $book->id,);
        $this->assertCount(1, Reservation:: all());
        $this->assertEquals($user->id, Reservation:: first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }

    /** @test */
    public function only_signed_in_user_ca_checkout_a_book()
    {
        //$this->withoutExceptionHandling();
        $book =  Book::factory()->count(1)->create()->first();
        $user = User::factory()->count(1)->create()->first();
        
        $this
        ->post('/checkout/' . $book->id,)
        ->assertRedirect('/login');
        $this->assertCount(0, Reservation:: all());
    }

    /** @test */
    public function only_real_books_can_be_checked_out()
    {
        $user = User::factory()->count(1)->create()->first();
        $this
        ->actingAs($user)
        ->post('/checkout/123')
        ->assertStatus(404);
        $this->assertCount(0, Reservation:: all());
    }

    /** @test */
    public function a_book_can_be_checked_in_by_a_signed_in_user()
    {
       // $this->withoutExceptionHandling();
        $book =  Book::factory()->count(1)->create()->first();
        $user = User::factory()->count(1)->create()->first();
        $this
        ->actingAs($user)
        ->post('/checkout/' . $book->id,);

        Auth::logout();

        $this
        ->post('/checkin/' . $book->id,)
        ->assertRedirect('/login');
        $this->assertCount(1, Reservation:: all());
        $this->isNull(Reservation::first()->checked_in_at);
    }

    /** @test */
    public function a_404_is_thrown_if_a_book_is_not_checked_out_first()
    {
      //  $this->withoutExceptionHandling();
        $book =  Book::factory()->count(1)->create()->first();
        $user = User::factory()->count(1)->create()->first();
        $this
        ->actingAs($user)
        ->post('/checkin/' . $book->id,)
        ->assertStatus(404);

        $this->assertCount(0, Reservation:: all());
        
 
    }
}

