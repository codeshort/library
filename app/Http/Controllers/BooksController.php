<?php

namespace App\Http\Controllers;
use App\Models\Book;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store()
    {
        $data = $this->validatedRequest();
        $book = Book::create($this->validatedRequest($data));
        return redirect('/books/'. $book->id);
        
    }

    public function update(Book $book)
    {
          // dd('hreeer');
        $data = $this->validatedRequest();
        $book->update($data);
        return redirect('/books/'. $book->id);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }

    protected function validatedRequest()
    {
         return request()->validate([
            'title' => 'required',
            'author' =>'required',
          ]);
    }

}
