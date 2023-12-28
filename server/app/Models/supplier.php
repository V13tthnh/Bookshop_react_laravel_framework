<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Supplier extends Model
{
    use HasFactory;
    protected $hidden=['deleted_at', 'created_at', 'updated_at'];
    use SoftDeletes;
    protected $fillable = ['name', 'address', 'phone', 'description', 'slug'];
}
