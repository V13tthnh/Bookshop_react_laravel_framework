<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\supplier;
use App\Models\admin;

class goods_received_note extends Model
{
    use HasFactory;

    public function supplier_id(){
        return $this->belongsTo(supplier::class);
    }

    public function admin_id(){
        return $this->belongsTo(admin::class);
    }
}
