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
        $ListAuthor=author::all();
        return view('author.index',compact('ListAuthor'));
    }
    public function create()
    {
        return view('author.create');
    }
    public function handleCreate(Request $request)
    {
 
        //chua xu ly hinh anh
        $author=new author();
        $author->name=$request->name;
        $author->description=$request->description;
        $author->slug=$request->slug;
        $author->save();

        $ListAuthor=author::all();
        return view('author.index',compact('ListAuthor'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $ListAuthor=author::all();
        return view('author.index',compact('ListAuthor'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = author::find($id);
        if ($author) {
            $author->delete();
            $ListAuthor=author::all();
            return view('author.index',compact('ListAuthor'));
        } 
            return '';
    }
}
