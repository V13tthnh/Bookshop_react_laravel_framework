<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;

class APIBookController extends Controller
{
    public function getListBook(){
        $listBook=Book::with('author','category')->get();
        return response()->json([
            'success' => true,
            'data' => $listBook
        ]);
    }
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $posts = book::where('name', 'like', "%$keyword%")->get();
        return response()->json(['data' => $posts]);
    }
    public function getBook($id){
        $book=Book::with('category','author')->find($id);
        if(empty($book)){
            return response()->json([
                'success'=>false,
            'data'=>"Book ID {$id} khong ton tai"
            ]);
        }
        return response()->json([
            'success'=>true,
            'data'=>$book
        ]);
    }
    public function filterByCategory($category)
    {
        $filteredBooks = Book::where('category_id', $category)->get();

        return response()->json(['filtered_books' => $filteredBooks]);
    }
    public function filterByPrice($minPrice, $maxPrice)
    {
        $filteredBooks = Book::whereBetween('unit_price', [$minPrice, $maxPrice])
                             ->orderBy('unit_price', 'ASC')
                             ->get();

        return response()->json(['filtered_books' => $filteredBooks]);
    }
}
