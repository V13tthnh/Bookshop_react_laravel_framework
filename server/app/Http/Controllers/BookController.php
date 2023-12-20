<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateBookRequest;
use App\Imports\BooksImport;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Image;
use App\Models\Publisher;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Str;

class BookController extends Controller
{
    public function index()
    {
        $listAuthor = Author::all();
        $listSupplier = Supplier::all();
        $listCategory = Category::all();
        $listPublisher = Publisher::all();
        return view('book.index', compact('listAuthor', 'listSupplier', 'listCategory', 'listPublisher'));
    }

    public function dataTable()
    {
        $listBook = Book::with('supplier')->with('publisher')->with('images')->get();
        return datatables::of($listBook)->addColumn('supplier_name', function ($listBook) {
            return $listBook->supplier->name;
        })->addColumn('publisher_name', function ($listBook) {
            return $listBook->publisher->name;
        })->addColumn('images', function ($listBook) {
            return $listBook->images->toArray();
        })->make(true);
    }

    public function import(Request $request){
        if($request->hasFile('file_excel')){
            $path = $request->file('file_excel')->getRealPath();
            Excel::import(new BooksImport, $path);
            return back()->with('successMsg', 'Nhập thành công!');
        }
        return back()->with('errorMsg', 'Nhập không thành công!');
    }

    public function store(CreateUpdateBookRequest $request)
    {
        $book = new Book();
        $book->name = $request->name;
        $book->code = $request->code;
        $book->description = $request->description;
        $book->weight = $request->weight;
        $book->format = $request->format;
        $book->year = $request->year;
        $book->language = $request->language;
        $book->size = $request->size;
        $book->num_pages = $request->num_pages;
        $book->slug = Str::slug($request->name);
        $book->translator = $request->translator;
        $book->publisher_id = $request->publisher_id;
        $book->supplier_id = $request->supplier_id;
        $book->book_type = $request->book_type;
        $book->e_book_price = null;
        if($request->hasFile('link_pdf')){
            $files = $request->link_pdf;
            $path = $files->store('uploads/ebooks');
            $book->link_pdf = $path;
        }
        else{
            $book->link_pdf = null;
        }
        $book->save();
        //Thêm vào bảng trung gian author_book
        if(isset($request->author_ids)){
            //Hàm explode() chuyển request từ string sang array vì hàm sync() chỉ nhận array
            //ví dụ: "2,3" => [2, 3]
            $authorIds = explode(',', $request->author_ids);
            $book->authors()->sync($authorIds);
        }
        //Thêm vào bảng trung gian book_category
        if(isset($request->category_ids)){
            $categoryIds = explode(',', $request->category_ids);
            $book->categories()->sync($categoryIds);
        }
       //Kiểm tra input images nếu có thì thêm ảnh ko thì bỏ qua
        if ($request->hasFile('images')) {
            $files = $request->images;
            foreach ($files as $file) {
                $images = new Image;
                $path = $file->store('uploads/books');
                $images->front_cover = $path;
                $images->back_cover = $path;
                $images->book_id = $book->id;
                $images->save();
            }
        } 
        return response()->json([
            'success' => true,
            'message' => "Thêm thành công!"
        ]);
    }

    public function show(string $id)
    {

    }
    public function edit(string $id)
    {
        $book = Book::with('images','authors', 'categories')->find($id);
        if ($book == null) {
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $book,

        ]);
    }

    public function update(CreateUpdateBookRequest $request, $id)
    {
        //Cập nhật
        $book = Book::find($id);
        $book->name = $request->name;
        $book->code = $request->code;
        $book->description = $request->description;
        $book->weight = $request->weight;
        $book->format = $request->format;
        $book->year = $request->year;
        $book->language = $request->language;
        $book->size = $request->size;
        $book->num_pages = $request->num_pages;
        $book->slug = Str::slug($request->name);
        $book->translator = $request->translator;
        $book->publisher_id = $request->publisher_id;
        $book->supplier_id = $request->supplier_id;
        $book->book_type = $request->book_type;
        $book->e_book_price = null;
        if($request->hasFile('link_pdf')){
            $files = $request->link_pdf;
            $path = $files->store('uploads/ebooks');
            $book->link_pdf = $path;
        }
        else{
            $book->link_pdf = null;
        }
        $book->save();
        //Thêm vào bảng trung gian author_book
        if(isset($request->author_ids)){
            $authorIds = explode(',', $request->author_ids); 
            $book->authors()->sync($authorIds); 
        }
        //Thêm vào bảng trung gian book_category
        if(isset($request->category_ids)){
            $categoryIds = explode(',', $request->category_ids);
            $book->categories()->sync($categoryIds);
        }
        //Kiểm tra input updateImages nếu có thì thêm ảnh ko thì bỏ qua
        if ($request->hasFile('updateImages')) {
            $files = $request->updateImages;
            foreach ($files as $file) {
                $images = new Image;
                $path = $file->store('uploads/books');
                $images->front_cover = $path;
                $images->back_cover = $path;
                $images->book_id = $book->id;
                $images->save();
            }
        }
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thành công!"
        ]);
    }
    public function destroy(string $id)
    {
        $book = Book::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }

    public function trash()
    {
        return view('book.trash');
    }

    public function dataTableTrash(){
        $trash = Book::with('publisher', 'supplier')->onlyTrashed()->get();
        return Datatables::of($trash)->addColumn('publisher_name', function($trash){
            return $trash->publisher->name;
        })->addColumn('supplier_name', function($trash){
            return $trash->supplier->name;
        })->addColumn('images', function($trash){
            return $trash->images->toArray();
        })->make(true);
    }

    public function untrash($id)
    {
        Book::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }

    public function deleteImage($id)
    {
        $image = Image::find($id);
        if (!$image)
            abort(404);
        unlink(public_path($image->front_cover));
        $image->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }
}
