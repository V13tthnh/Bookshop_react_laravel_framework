<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BookCategory;

class APICategoryController extends Controller
{
    public function getAllCategory(){
        $listCate = Category::withCount('books')->get();
        if(empty($listCate)){
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $listCate
        ]);
    }
    public function getListCategoryAndListBook(){
        $listCateBook = Category::with('list_book')->get();
        if(empty($listCateBook)){
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $listCateBook
        ]);
    }

    public function getListBookInCategory($id){
        $listCB = Category::with('books', 'books.images', 'books.discounts')->where('id', $id)->get();
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
