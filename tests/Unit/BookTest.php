<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

     use RefreshDatabase;
     /** @test */
    public function an_author_id_is_recorded()
    {
        Book::create([
            'title' => 'Cool Title',
            'author_id' => 1,

        ]);
        $this->assertCount(1, Book:: all());
    }
}
