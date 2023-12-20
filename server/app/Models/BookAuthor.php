<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    use HasFactory;
    public function list_category(){
        return $this->hasMany(Category::class);
    }
    public function list_book(){
        return $this->hasMany(Book::class);
    }
}
