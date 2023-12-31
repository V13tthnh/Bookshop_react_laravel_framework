<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use App\Models\Supplier;
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
        $books = Book::where('book_type', 0)->get();
        $suppliers = Supplier::all();
        return view('combo.create', compact('books', 'suppliers'));
    }

    public function store(Request $request)
    {
        //dd($request);
        if($request->hasFile('image')){
            $file = $request->image;
            $path = $file->store('uploads/combos');
            $combo = new Combo;
            $combo->supplier_id = $request->supplier_id;
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
            $combo->supplier_id = $request->supplier_id;
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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
