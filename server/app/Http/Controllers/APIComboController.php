<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use Illuminate\Http\Request;

class APIComboController extends Controller
{
    public function getAllCombo(){
        $combos = Combo::with('books', 'supplier')->get();
        return response()->json([
            'success' => true,
            'data' => $combos
        ]);
    }

    public function getComboDetail($id){
        $combo = Combo::with('books')->find($id);
        if(empty($combo)){
            return response()->json([
                'success' => true,
                'message' => "Không tìm thấy combo!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $combo
        ]);
    }
}
