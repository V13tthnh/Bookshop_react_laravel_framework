<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Publisher;
use Str;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listBook=Book::all();
        $id=1;
        $listAuthor=Author::all();
        $listSupplier=Supplier::all();
        $listCategory=Category::all();
        $listPublisher=Publisher::all();
        return view('book.index',compact('listBook','id','listAuthor','listSupplier','listCategory','listPublisher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = Book::where('name', $request->name)->first();
        if($name != null){
            return redirect()->back()->with('errorMsg', 'Tên sach đã tồn tại!');
        }
        $book=new Book();
        $book->name=$request->name;
        $book->code=$request->code;
        $book->description=$request->description;
        $book->unit_price=$request->unit_price;
        $book->quantity=$request->quantity;
        $book->weight=$request->weight;
        $book->format=$request->format;
        $book->year=$request->year;
        $book->language=$request->language;
        $book->size=$request->size;
        $book->num_pages=$request->num_pages;
        $book->slug=Str::slug($request->name);
        $book->translator=$request->translator;
        $book->author_id=$request->author_id;
        $book->category_id=$request->category_id;
        $book->publisher_id=$request->publisher_id;
        $book->save();
        return redirect()->route('book.index')->with('successMsg', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }
    public function edit(string $id)
    {
        $book = Book::find($id);
        if($book == null){
            return redirect()->back()->with('errorMsg', "Dữ liệu không tồn tại!");
        }
        return response()->json([
            'success' => 200,
            'data' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $name = Book::where('id', '<>', $request->id)->where('name', $request->name)->first();
        if($name != null){
            return redirect()->back()->with('errorMsg', "Sách đã tồn tại!");
        }
        $book=Book::find($request->id);
        $book->name=$request->name;
        $book->code=$request->code;
        $book->description=$request->description;
        $book->unit_price=$request->unit_price;
        $book->quantity=$request->quantity;
        $book->weight=$request->weight;
        $book->format=$request->format;
        $book->year=$request->year;
        $book->language=$request->language;
        $book->size=$request->size;
        $book->num_pages=$request->num_pages;
        $book->slug=Str::slug($request->name);
        $book->translator=$request->translator;
        $book->author_id=$request->author_id;
        $book->supplier_id=$request->supplier_id;
        $book->category_id=$request->category_id;
        $book->publisher_id=$request->publisher_id;
        $book->save();
        return redirect()->route('book.index')->with('successMsg', 'Sửa thành công!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book=Book::find($id)->delete();
        return redirect()->route('book.index')->with('successMsg', 'Xoa thành công!');
    }
    public function trash(){
        $trash = Book::onlyTrashed()->get();
        $id=1;
        return view('book.trash', compact('trash','id'));
    }

    public function untrash($id)
    {   
        Book::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
