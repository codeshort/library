<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use App\Models\Author;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function only_name_is_required_to_create_an_author()
    {
      
       Author:: firstOrCreate([
           'name' => 'john doe',
       ]);

       $this->assertCount(1,Author:: all());
    }
}
