<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\Admin;
use Illuminate\Support\Carbon;

class GoodsReceivedNote extends Model
{
    use HasFactory;

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function goodReceivedNoteDetails(){
        return $this->hasMany(GoodsReceivedNoteDetail::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}
