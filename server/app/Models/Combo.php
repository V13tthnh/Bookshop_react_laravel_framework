<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combo extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function books(){
        return $this->belongsToMany(Book::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

}
