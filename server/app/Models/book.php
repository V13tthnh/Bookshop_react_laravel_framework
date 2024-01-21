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
    protected $hidden=['deleted_at', 'created_at', 'updated_at'];

    protected $fillable = [
        'name', 
        'code',
        'description',
        'weight', 
        'format', 
        'year', 
        'language', 
        'size', 
        'num_pages', 
        'translator', 
        'slug', 
        'supplier_id', 
        'publisher_id', 
        'book_type',
        'overrate'];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    public function combos(){
        return $this->belongsToMany(Combo::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function discounts(){
        return $this->hasMany(Discount::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
