<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateUpdatePublisherRequest;
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

    public function create()
    {
        //
    }

    public function store(CreateUpdatePublisherRequest $request)
    {
        $publisher=new Publisher();
        $publisher->name=$request->name;
        $publisher->description=$request->description;
        $publisher->save();
        return response()->json([
            'success' => true,
            'message' => "Thêm thành công!"
        ]);
    }

    public function show(string $id)
    {
        //
    }

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

    public function update(CreateUpdatePublisherRequest $request, $id)
    {
        $publisher=Publisher::find($request->id);
        $publisher->name=$request->name;
        $publisher->description=$request->description;
        $publisher->save();
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thành công!"
        ]);
    }

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
