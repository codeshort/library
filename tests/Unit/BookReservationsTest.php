<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_book_can_be_checked_out()
    {
       $book =  Book::factory()->count(1)->create()->first();
       $user = User::factory()->count(1)->create()->first();

        $book->checkout($user);
        $this->assertCount(1, Reservation:: all());
        $this->assertEquals($user->id, Reservation:: first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test */
    public function a_book_can_be_returned()
    {
        
       $book =  Book::factory()->count(1)->create()->first();
       $user = User::factory()->count(1)->create()->first();
       $book->checkout($user);
       $book->checkin($user);
        $this->assertCount(1, Reservation:: all());
        $this->assertEquals($user->id, Reservation:: first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);

    }

    /** @test */
    // if not checked out then exception
    public function if_not_checked_out_then_exception()
    {
       
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);
       $book =  Book::factory()->count(1)->create()->first();
       $user = User::factory()->count(1)->create()->first();
       $book->checkin($user);
       

    }


    /** @test */
    // a user cancheck out twice

    public function a_user_can_checkout_a_book_twice()
    {
        $book =  Book::factory()->count(1)->create()->first();
        $user = User::factory()->count(1)->create()->first();
        $book->checkout($user);
        $book->checkin($user);
        $book->checkout($user);
        $this->assertCount(2, Reservation:: all());
        $this->assertEquals($user->id, Reservation:: find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

        $book->checkin($user);
        $this->assertCount(2, Reservation:: all());
        $this->assertEquals($user->id, Reservation:: find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_in_at);
    }
}
