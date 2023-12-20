<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\Admin;

class GoodsReceivedNote extends Model
{
    use HasFactory;
    protected $fillable = ['formality', 'supplier_id', 'admin_id', 'total', 'status'];
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
