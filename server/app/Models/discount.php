<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'percent', 'start_date', 'end_date'];

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
