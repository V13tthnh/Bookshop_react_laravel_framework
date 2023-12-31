<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Combo;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Book;

class APIBookController extends Controller
{
    public function getListBook()
    {
        $listBook = Book::with('categories', 'authors', 'images')->get();
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


    public function getBanner()
    {
        $sliders = Slider::with('book')->get();
        if(empty($sliders)){
            return response()->json([
                'success' => false,
                'message' => "Không có dữ liệu!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }    public function getBook($id)
    {
        $book = Book::with('categories', 'authors', 'images', 'publisher')->find($id);
        if (empty($book)) {
            return response()->json([
                'success' => false,
                'data' => "Book ID {$id} khong ton tai"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

    public function getCombo(Request $request)
    {
        $perPage = 3; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1
        $query = Combo::with('supplier', 'books')->get();
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'data' => "Không có combo trong kho!"
            ]);
        }
        $total = $query->count();
     
        $totalPages = ceil($total / $perPage);
        $data = $query->skip(($page - 1) * $perPage)->take($perPage)->all();
        return response()->json([
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'data' => $data,
        ]);
    }
    public function getBooksByCategory($categoryId)
    {
        $category = Category::find($categoryId);
        $booksBycategories = Book::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->with(['categories', 'authors'])->get();
        return response()->json([
            'success' => true,
            'data' => $booksBycategories
        ]);
    }

    public function getRelatedBooks($id){
        $book = Book::find($id);
        // Lấy danh sách các danh mục của sách
        $categories = $book->categories;
        // Lấy danh sách sản phẩm liên quan theo danh mục
        $relatedProducts = collect();
        foreach ($categories as $category) {
            $relatedProducts = $relatedProducts->merge($category->books);
        }

        return response()->json([
            'success' => true,
            'data' => $relatedProducts
        ]);
    }
    public function filterByCategory($categories, Request $request)
    {
        $perPage = 3; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1

        $query = Category::with('books.images', 'books.publisher', 'books.supplier')->find($categories);
        if (!$query) {
            // Xử lý khi không tìm thấy category
            return response()->json(['error' => 'Không tìm thấy danh mục'], 404);
        }
        $books = $query->books;
        //dd($query->books);
        //Phân trang
        $total = $books->count();
        $totalPages = ceil($total / $perPage);
        $data = $books->skip(($page - 1) * $perPage)->take($perPage)->all();
        //Trả về kết quả
        return response()->json([
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'data' => $data,
        ]);
    }

    public function filterByPrice($minPrice, $maxPrice, Request $request)
    {
        $filteredBooks = Book::whereBetween('unit_price', [$minPrice, $maxPrice])
            ->with('categories', 'authors', 'images')
            ->orderBy('unit_price', 'ASC')
            ->get();
        $perPage = 3; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1

        $query = Book::query()->whereBetween('unit_price', [$minPrice, $maxPrice])->orderBy('unit_price', 'ASC');

        // Thêm bất kỳ điều kiện tìm kiếm nào nếu cần
        $total = $query->count();
        $totalPages = ceil($total / $perPage);
        $data = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->with('categories', 'authors', 'images')
            ->get();
        return response()->json([
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'data' => $data,
        ]);
    }
    public function index(Request $request)
    {
        $perPage = 3; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1

        $query = Book::query();

        // Thêm bất kỳ điều kiện tìm kiếm nào nếu cần

        $total = $query->count();
        $totalPages = ceil($total / $perPage);

        $data = $query->skip(($page - 1) * $perPage)
            ->take($perPage)->with('categories', 'authors', 'images')
            ->get();

        return response()->json([
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'data' => $data,
        ]);
    }
}

