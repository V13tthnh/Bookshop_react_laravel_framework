<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\goods_received_note;
class goods_received_note_details extends Model
{
    use HasFactory;

    public function goods_received_note(){
        return $this->belongsTo(goods_received_note::class);
    }

    public function book(){
        return $this->belongsTo(book::class);
    }
}
