<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Combo;
use App\Models\Discount;
use App\Models\OrderDetail;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Book;
use DB;
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
        $keyword = $request->input('search');
        $posts = book::with('images', 'categories', 'authors')->where('name', 'like', "%$keyword%")->get();
        return response()->json(['data' => $posts]);
    }


    public function getBanner()
    {
        $sliders = Slider::with('book')->get();
        if (empty($sliders)) {
            return response()->json([
                'success' => false,
                'message' => "Không có dữ liệu!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }
    public function getBook($id)
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
        $perPage = 9; // Số lượng mục trên mỗi trang, mặc định là 10
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

    public function getRelatedBooks($id)
    {
        $books = Book::with('categories')->find($id);
        $relatedBooks = Category::with('books.images', 'books.authors', 'books.categories', 'books.supplier', 'books.publisher')->find($books->categories[0]->id);
        return response()->json([
            'success' => true,
            'data' => $relatedBooks
        ]);
    }
    public function filterByCategory($categories, Request $request)
    {
        $perPage = 9; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1
        $query = Category::with('books.images', 'books.publisher', 'books.supplier', 'books.discounts')->find($categories);
        if (!$query) {
            // Xử lý khi không tìm thấy category
            return response()->json(['error' => 'Không tìm thấy danh mục'], 404);
        }
        $books = $query->books;
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
        $perPage = 9; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1
        $query = Book::query()->whereBetween('unit_price', [$minPrice, $maxPrice])->orderBy('unit_price', 'ASC');
        // Thêm bất kỳ điều kiện tìm kiếm nào nếu cần
        $total = $query->count();
        $totalPages = ceil($total / $perPage);
        $data = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->with('categories', 'authors', 'images', 'discounts')
            ->get();
        return response()->json([
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'data' => $data,
        ]);
    }

    public function filterByType($type, Request $request)
    {
        $perPage = 9; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1
        $query = Book::query()->where('book_type', $type)->orderBy('unit_price', 'ASC');
        if ($type == 2) {
            $query = Combo::query();
            $total = $query->count();
            $totalPages = ceil($total / $perPage);
            $data = $query->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();
            return response()->json([
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => $totalPages,
                'data' => $data,
            ]);
        }
        //Thêm bất kỳ điều kiện tìm kiếm nào nếu cần
        $total = $query->count();
        $totalPages = ceil($total / $perPage);
        $data = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->with('categories', 'authors', 'images', 'discounts')
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
        $perPage = 9; // Số lượng mục trên mỗi trang, mặc định là 10
        $page = $request->input('page', 1); // Trang hiện tại, mặc định là 1
        $query = Book::query();
        // Thêm bất kỳ điều kiện tìm kiếm nào nếu cần
        $total = $query->count();
        $totalPages = ceil($total / $perPage);
        $data = $query->skip(($page - 1) * $perPage)
            ->take($perPage)->with('categories', 'authors', 'images', 'discounts')
            ->get();
        return response()->json([
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'data' => $data,
        ]);
    }

    public function showPDF($id){
        $pdf = Book::find($id);
        return response()->json([
            'success' => true,
            'filePDF' => $pdf->link_pdf
        ]);
    }

    public function hotSellingBook(){
        $books = OrderDetail::with('book','book.images', 'book.discounts')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->select('order_details.book_id', 'order_details.unit_price', DB::raw('SUM(order_details.quantity) as total_sold'))
        ->where('order_details.book_id', '<>', null)
        ->where('orders.status', '=', 4) 
        ->groupBy('order_details.book_id', 'order_details.unit_price')
        ->get();
        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    public function newBooks(){
        $newBooks = Book::with('discounts', 'images')->orderBy('id', 'desc')->take(3)->get();
        return response()->json([
            'success' => true,
            'data' => $newBooks
        ]);
    }

    public function salesBooks(){
        $saleBooks = Discount::with('book', 'book.images')->get();
        return response()->json([
            'success' => true,
            'data' => $saleBooks
        ]);
    }

    public function featuredBook(){
        $featuredBook = Book::with('images', 'discounts', 'authors')->select('books.id', 'books.name', 'books.unit_price', 'books.overrate',DB::raw('SUM(order_details.quantity) as total_sold'))
        ->join('order_details', 'books.id', '=', 'order_details.book_id')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->where('status', 4)
        ->groupBy('books.id', 'books.name',  'books.unit_price', 'books.overrate')
        ->orderByDesc('total_sold')
        ->take(1) // Lấy top 1 sách bán chạy nhất
        ->get();
        return response()->json([
            'success' => true,
            'data' => $featuredBook
        ]);
    }

    public function listEbook(){
        $ebook = Book::with('images', 'discounts', 'authors')->where('book_type', 1)->take(3)->get();
        return response()->json([
            'success' => true,
            'data' => $ebook
        ]);
    }
}

