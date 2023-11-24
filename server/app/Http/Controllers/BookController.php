<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book;
use App\Models\author;
use App\Models\supplier;
use App\Models\category;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listBook=book::paginate(3);
        $id=1;
        $listAuthor=author::all();
        $listSupplier=supplier::all();
        $listCategory=category::all();
        return view('book.index',compact('listBook','id','listAuthor','listSupplier','listCategory'));
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
        $name = book::where('name', $request->name)->first();
        if($name != null){
            return redirect()->back()->with('errorMsg', 'Tên sach đã tồn tại!');
        }
        $book=new book();
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
        $book->slug=$request->slug;
        $book->translator=$request->translator;
        $book->author_id=$request->author_id;
        $book->supplier_id=$request->supplier_id;
        $book->category_id=$request->category_id;
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
        $book = book::find($id);
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

        $name = book::where('id', '<>', $request->id)->where('name', $request->name)->first();
        if($name != null){
            return redirect()->back()->with('errorMsg', "Sách đã tồn tại!");
        }
        $book=book::find($request->id);
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
        $book->slug=$request->slug;
        $book->translator=$request->translator;
        $book->author_id=$request->author_id;
        $book->supplier_id=$request->supplier_id;
        $book->category_id=$request->category_id;
        $book->save();
        return redirect()->route('book.index')->with('successMsg', 'Sửa thành công!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book=book::find($id)->delete();
        return redirect()->route('book.index')->with('successMsg', 'Xoa thành công!');
    }
    public function trash(){
        $trash = book::onlyTrashed()->get();
        return view('book.trash', compact('trash'));
    }

    public function untrash($id)
    {   
        book::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
    
    
}
