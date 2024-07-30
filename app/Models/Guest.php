<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'age', 'phone', 'gender'];

    public function hotelBooks()
    {
        return $this->hasMany(HotelBook::class);
    }
    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }
}