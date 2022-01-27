<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagamentTest extends TestCase
{
    
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author_id' => 'Victor'
        ]);

        $book = Book::first();
        $this->assertCount(1,Book::all());
        $response->assertRedirect(('/books/'. $book->id));
        
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
            'author_id' => ''
        ]);
        $response->assertSessionHasErrors('author_id');
    }
    
     /** @test */
     public function a_book_can_be_updated()
     {
        //$this->withoutExceptionHandling();
           $this->post('/books',[
             'title' => 'A cool one',
             'author_id' => 'Victor'
         ]);
          $book = Book::first();
          $response = $this->patch('/books/'. $book->id,[
             'title' => 'A new tittle',
             'author_id' => 'Victory'
         ]);
         $this->assertEquals('A new tittle', Book:: first()->title);
         $this->assertEquals(2, Book:: first()->author_id);
         $response->assertRedirect(('/books/'. $book->id));

     }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/books',[
            'title' => 'A cool one',
            'author_id' => 'A cool author'
        ]);

        $book = Book:: first();
        $this->assertCount(1,Book::all());
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
        
    }

    
    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books',[
            'title' => 'Cool Title',
            'author_id' => 'Victor',
        ]);
        $book = Book::first();
        $author = Author:: first();
        $this->assertEquals($author->id,$book->author_id);
        $this->assertCount(1, Author:: all());
    }
}   

