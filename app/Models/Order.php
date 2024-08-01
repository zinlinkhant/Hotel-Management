<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'invetory_id',
        'hotelbook_id',
        'quantity',
        'price',
    ];

    public function invetories()
    {
        return $this->hasOne(Invetory::class);
    }

    public function hotel_books()
    {
        return $this->hasOne(HotelBook::class);
    }
}