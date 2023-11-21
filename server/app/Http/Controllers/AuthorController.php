<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\author;
class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function index(Request $request){
        $ListAuthor=author::paginate(3);
        $id = 0;
        return view('author.index',compact('ListAuthor', 'id'));
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
        $author=author::where('name', $request->name)->first();
        if($author != null){
            return redirect()->back()->with('errorMsg', "Ten tac gia da ton tai");
        }
        if($request->hasFile('image')){
            $file = $request->image;
            $path = $file->store('uploads');
            $author=new author();
            $author->name=$request->name;
            $author->description=$request->description;
            $author->slug=$request->slug;
            $author->image = $file;
            $author->save();
        }
        else{
            $author=new author();
            $author->name=$request->name;
            $author->description=$request->description;
            $author->slug=$request->slug;
            $author->save();
        }
        return redirect()->route('author.index')->with('successMsg', "Them thanh cong!");
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
        $author=author::find($id);
        return view('author.edit',compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $author=author::find($id);
        if($author){
            $author->name=$request->name;
            $author->description=$request->description;
            $author->slug=$request->slug;
            $author->save();
        }
        return redirect()->route('author.index')->with('successMsg', "Sua thanh cong!");
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = author::find($id);
        $author->delete();
        return redirect()->route('author.index')->with('successMsg', 'Xóa thành công!');
    }
    public function trash(){
        $trash = author::onlyTrashed()->get();
        return view('author.trash', compact('trash'));
    }

    public function untrash($id)
    {   
        author::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
