<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['name', 'start_date', 'end_date', 'book_id', 'image',];

    protected $hidden = ['deleted_at'];
    public function book(){
        return $this->belongsTo(Book::class);
    }
}
