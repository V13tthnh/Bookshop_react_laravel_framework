<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $hidden=['deleted_at', 'created_at', 'updated_at'];
    protected $table='categories';
  protected $fillable = ['name', 'description'];
    
    public function books(){
        return $this->belongsToMany(Book::class);

    }
}
