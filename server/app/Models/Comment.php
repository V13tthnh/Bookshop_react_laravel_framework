<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['book_id', 'combo_id', 'customer_id', 'comment_text', 'status', 'created_at'];
    protected $hidden = ['updated_at'];
    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function combo(){
        return $this->belongsTo(Combo::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function comment_replies(){
        return $this->hasMany(CommentReply::class);
    }

    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

}
