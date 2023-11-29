<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public function user(){
        return $this->belongsTo(User::class);
    }
}
