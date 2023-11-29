<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;
use Yajra\Datatables\Datatables;
class PublisherController extends Controller
{
    
    public function index()
    {
        $listPublisher=Publisher::all();
        $id = 1;
        return view('publisher.index',compact('listPublisher', 'id'));
    }

    public function dataTable(){
        return Datatables::of(Publisher::query())->make(true);
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
            return response()->json([
                'success' => false,
                'message' => "Tên đã tồn tại!"
            ]);
        }
        $publisher=new Publisher();
        $publisher->name=$request->name;
        $publisher->description=$request->description;
        $publisher->save();
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $publisher=Publisher::find($id);
        if($publisher == null){
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $publisher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = Publisher::where('id', '<>', $id)->where('name', $request->name)->first();
        if(!empty($id)){
            return response()->json([
                'success' => false,
                'message' => "Tên đã tồn tại!"
            ]);
        }
        $publisher=Publisher::find($request->id);
        $publisher->name=$request->name;
        $publisher->description=$request->description;
        $publisher->save();
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
        Publisher::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }
    public function dataTableTrash(){
        $trash = Publisher::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }
    public function trash(){
        return view('publisher.trash');
    }

    public function untrash($id)
    {   
        Publisher::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
