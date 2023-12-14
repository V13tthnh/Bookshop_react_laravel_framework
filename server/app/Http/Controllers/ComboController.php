<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ComboController extends Controller
{
    public function index()
    {
        return view('combo.index');
    }

    public function dataTable(){
        $combos = Combo::all();
        return Datatables::of($combos)->make(true);
    }

    public function dataTableDetail($id){
        $combo = Combo::find($id);
        return response()->json([
            'data' => $combo->books
        ]);
    }

    public function create()
    {
        $books = Book::all();
        return view('combo.create', compact('books'));
    }

    public function store(Request $request)
    {
        //dd($request->hasFile('image'));
        if($request->hasFile('image')){
            $file = $request->image;
            $path = $file->store('uploads/combos');
            $combo = new Combo;
            $combo->name = $request->name;
            $combo->price = $request->price;
            $combo->quantity = $request->quantity;
            $combo->image = $path;
            $combo->save();
            $combo->books()->sync($request->book_ids);
        }
        else{
            $combo = new Combo;
            $combo->name = $request->name;
            $combo->price = $request->price;
            $combo->quantity = $request->quantity;
            $combo->save();
            $combo->books()->sync($request->book_ids);
        }
            
       return redirect()->route('combo.index')->with('successMsg', "Thêm thành công!");
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
