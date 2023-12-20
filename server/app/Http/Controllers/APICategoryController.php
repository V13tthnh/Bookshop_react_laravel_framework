<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BookCategory;

class APICategoryController extends Controller
{
    public function getListCategoryAndListBook(){
        $categoryBooks = Category::with('books')->get();
        if(empty($categoryBooks)){
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $categoryBooks
        ]);
    }

    public function getListBookInCategory($id){
        $listCB = Category::with('list_book')->where('id',$id)->get();
        if(empty($listCB)){
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $listCB
        ]);
    }
}
