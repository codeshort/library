<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CheckInBookController extends Controller
{
    public function  __construct()
    {
        $this->middleware('auth');
    }

    public function store(Book $book)
        {
            try
            {
                $book->checkin(auth()->user());
            }
            catch(\Exception $e)
            {
               return response([],404);
            }
           
        }
    
}
