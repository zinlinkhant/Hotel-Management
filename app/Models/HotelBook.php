<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBook extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id', 'guest_id', 'check_in_date', 'check_out_date', 'price', 'num_of_people'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
    public function checkOut()
    {
        return $this->hasOne(CheckOut::class);
    }
    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}
