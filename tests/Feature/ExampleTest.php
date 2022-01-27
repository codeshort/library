<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);
        $response->assertOk();
        $this->assertCount(1,Book::all());

    }

    /** @test */
    public function a_title_is_req()
    {
      //  $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Victor'
        ]);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_is_req()
    {
      //  $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'A cool one',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }
    
     /** @test */
     public function a_book_can_be_updated()
     {
        $this->withoutExceptionHandling();
           $this->post('/books',[
             'title' => 'A cool one',
             'author' => 'A cool author'
         ]);
          $book = Book::first();
          $response = $this->patch('/books/'. $book->id,[
             'title' => 'A new tittle',
             'author' => 'New Author'
         ]);
         $this->assertEquals('A new tittle', Book:: first()->title);
         $this->assertEquals('New Author', Book:: first()->author);
     }

    
}
