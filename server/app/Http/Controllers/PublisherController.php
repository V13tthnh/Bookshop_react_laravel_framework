<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;
class PublisherController extends Controller
{
    
    public function index()
    {
        $listPublisher=Publisher::paginate(3);
        $id = 1;
        return view('publisher.index',compact('listPublisher', 'id'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = Publisher::where('name', $request->name)->first();
        if($name != null){
            return redirect()->back()->with('errorMsg', "Ten đã tồn tại!");
        }
        $publisher=new Publisher();
        $publisher->name=$request->name;
        $publisher->description=$request->description;
        $publisher->save();
        return redirect()->route('publisher.index')->with('successMsg', "Thêm thành công!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $publisher=Publisher::find($id);
        if($publisher == null){
            return redirect()->back()->with('errorMsg', "Dữ liệu không tồn tại!");
        }
        return response()->json([
            'success' => 200,
            'data' => $publisher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $publisher=Publisher::find($request->id);
        $publisher->name=$request->name;
        $publisher->description=$request->description;
        $publisher->save();
        return redirect()->route('publisher.index')->with('successMsg', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publisher=Publisher::find($id)->delete();
        return redirect()->route('publisher.index')->with('successMsg', 'Xoa thành công!');
    }
    public function trash(){
        $trash = Publisher::onlyTrashed()->get();
        $id=1;
        return view('publisher.trash', compact('trash','id'));
    }

    public function untrash($id)
    {   
        Publisher::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
