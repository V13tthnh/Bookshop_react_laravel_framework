<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Image;
use App\Models\Publisher;
use Yajra\Datatables\Datatables;

use Str;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listAuthor=Author::all();
        $listSupplier=Supplier::all();
        $listCategory=Category::all();
        $listPublisher=Publisher::all();
        return view('book.index',compact('listAuthor','listSupplier','listCategory','listPublisher'));
    }

    public function dataTable(){
        $listBook=Book::with('category')->with('author')->with('publisher')->with('image_list')->get();
        return datatables::of($listBook)->addColumn('author_name', function($listBook){
            return $listBook->author->name;
        })->addColumn('category_name', function($listBook){
            return $listBook->category->name;
        })->addColumn('publisher_name', function($listBook){
            return $listBook->publisher->name;
        })->addColumn('image_list', function($listBook){
            return $listBook->image_list->toArray();
        })->make(true);
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
        //dd($request->images);
        $name = Book::where('name', $request->name)->first();
        if($name != null){
            return response()->json([
                'success' => false,
                'message' => "Tên sách đã tồn tại!"
            ]);
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
        $book->supplier_id=0;
        $book->save();
        if($request->hasFile('images')){
            $files = $request->images;
            foreach($files as $file){
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }
    public function edit(string $id)
    {
        $book = Book::with('image_list')->find($id);
       
        if($book == null){
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $name = Book::where('id', '<>', $id)->where('name', $request->name)->first();
        if($name != null){
            return response()->json([
                'success' => false,
                'message' => "Tên sách đã tồn tại"
            ]);
        }
        $book=Book::find($id);
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
        $book->supplier_id=0;
        $book->category_id=$request->category_id;
        $book->publisher_id=$request->publisher_id;
        $book->save();
        if($request->hasFile('updateImages')){
            $files = $request->updateImages;
            foreach($files as $file){
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

    public function deleteImage($id){
        $image = Image::find($id);
        if(!$image) abort(404);
        unlink(public_path($image->front_cover)); 
        $image->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }
}
