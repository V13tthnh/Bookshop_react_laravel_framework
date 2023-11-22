<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\book;

class image extends Model
{
    use HasFactory;

    public function book(){
        return $this->belongsTo(book::class);
    }
}
