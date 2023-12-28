<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;
    protected $hidden=['deleted_at', 'created_at', 'updated_at'];
    use HasFactory;
    protected $fillable = ['name', 'description', 'image',];
    public function books(){
        return $this->belongsToMany(Book::class);
    }
}
