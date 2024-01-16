<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;
    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
