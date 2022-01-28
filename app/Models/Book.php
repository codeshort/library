<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function checkout($user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }
    public function checkin($user)
    {
         $reservation =   $this->reservations()
           ->where('user_id',$user->id)
           ->whereNotNull('checked_out_at')
           ->whereNull('checked_in_at')
           ->first();
        
           if(is_null($reservation))
           {
               throw new \Exception();
           }
           //dd($reservation);
           $reservation->update([
               'checked_in_at' => now(),

           ]);

    }
    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = Author:: firstOrCreate([
            'name' => $author,
        ])->id;
    }
   
    public function reservations()
    {
        // boo can have many reservation
        // a reservation belongs to a book
        return $this->hasMany(Reservation::class);
    }
   
}
