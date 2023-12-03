<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Yajra\Datatables\Datatables;
use Str;
class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function index(Request $request){
        return view('author.index');
    }

    public function dataTable(Request $request){
        $listAuthor=Author::all();
        return Datatables::of($listAuthor)->make(true);
    }
    public function create()
    {
        return view('author.create');
    }
    public function handleCreate(Request $request)
    {
 
        //chua xu ly hinh anh
        
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $author=Author::where('name', $request->name)->first();
        if($author != null){
            return response()->json([
                'success' => false,
                'message' => "Tên tác giả đã tồn tại!"
            ]);
        }
        if($request->hasFile('avatar')){
            $file = $request->avatar;
            $path = $file->store('uploads/authors');
            $author=new Author();
            $author->name=$request->name;
            $author->description=$request->description;
            $author->slug=Str::slug($request->image);
            $author->image = $path;
            $author->save();
            return response()->json([
                'success' => true,
                'message' => "Thêm thành công!"
            ]);
        }
        $author=new Author();
        $author->name=$request->name;
        $author->description=$request->description;
        $author->slug=$request->slug;
        $author->save();
        
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
        //
    }

    public function edit($id,Request $request)
    {
        $author=Author::find($id);
        return view('author.edit',compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $author=Author::find($id);
        if($request->hasFile('avatar')){
            $file = $request->avatar;
            $path = $file->store('uploads/authors');
            $author=new Author();
            $author->name=$request->name;
            $author->description=$request->description;
            $author->slug=Str::slug($request->image);
            $author->image = $path;
            $author->save();
            return response()->json([
                'success' => true,
                'message' => "Cập nhật thành công!"
            ]);
        }
        $author=new Author();
        $author->name=$request->name;
        $author->description=$request->description;
        $author->slug=Str::slug($request->image);
        $author->save();
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
        $author = Author::find($id);
        $author->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }

    public function dataTableTrash(){
        $trash = Author::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }

    public function trash(){
        return view('author.trash');
    }

    public function untrash($id)
    {   
        Author::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
