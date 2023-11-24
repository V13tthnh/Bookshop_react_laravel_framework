<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\users;
class order extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'orders';
    public function user(){
        return $this->belongsTo(users::class);
    }
}
