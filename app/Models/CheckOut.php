<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;
    protected $fillable = ['hotelbook_id', 'checkout_date'];
    public function hotelBook()
    {
        return $this->belongsTo(HotelBook::class, 'hotelbook_id');
    }
}