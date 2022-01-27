<?php

namespace Tests\Feature;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;

     /** @test */
    public function author_can_be_created()
    {

      $this->withoutExceptionHandling(); 
      $this->post('/author',[
        'name' => 'Author Name',
        'dob' => '05/14/1998'
      ]);

      $author = Author::all();

       $this->assertCount(1,$author);
       $this->assertInstanceOf(Carbon:: class, $author->first()->dob);
       $this->assertEquals('1998/14/05',$author->first()->dob->format('Y/d/m'));
    }
}
