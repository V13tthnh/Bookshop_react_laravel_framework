<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Author;
use App\Models\Supplier;
use App\Models\Image;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }

    public function image_list(){
        return $this->hasMany(Image::class);
    }
}
