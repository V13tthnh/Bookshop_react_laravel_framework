<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Review extends Model
{
    use HasFactory;
    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function combo(){
        return $this->belongsTo(Combo::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
