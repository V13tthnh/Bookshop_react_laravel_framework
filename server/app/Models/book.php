<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;
use App\Models\author;
use App\Models\supplier;
use App\Models\image;
use Illuminate\Database\Eloquent\SoftDeletes;

class book extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function author(){
        return $this->belongsTo(author::class);
    }

    public function supplier(){
        return $this->belongsTo(supplier::class);
    }

    public function image_list(){
        return $this->hasMany(image::class);
    }
}
