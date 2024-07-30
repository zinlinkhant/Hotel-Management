<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'price',
        'name',
        'active',
    ];

    public function hotelBooks()
    {
        return $this->hasMany(HotelBook::class);
    }
    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }
}