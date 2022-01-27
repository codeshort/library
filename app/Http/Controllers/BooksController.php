<?php

namespace App\Http\Controllers;
use App\Models\Book;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store()
    {
        $data = $this->validatedRequest();
        Book::create([
            'title' => request('title'),
            'author' => request('author')
        ]);
    }

    public function update(Book $book)
    {
          // dd('hreeer');
        $data = $this->validatedRequest();
        $book->update($data);
    }

    protected function validatedRequest()
    {
         return request()->validate([
            'title' => 'required',
            'author' =>'required',
          ]);
    }

}
