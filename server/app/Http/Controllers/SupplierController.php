<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateUpdateSupplierRequest;
use Str;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index');
    }

    public function dataTable(){
        return Datatables::of(Supplier::query())->make(true);
    }

    public function create()
    {
        return view("supplier.create");
    }

    public function store(CreateUpdateSupplierRequest $rq)
    {
        $createSupplier=new Supplier();
        $createSupplier->name=$rq->name;
        $createSupplier->address=$rq->address;
        $createSupplier->phone=$rq->phone;
        $createSupplier->description=$rq->description;
        $createSupplier->slug=Str::slug($rq->name);
        $createSupplier->save();
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
        $editSuppliers=Supplier::find($id);
        return response()->json([
            'success' => true,
            'data' => $editSuppliers
        ]);
    }

    public function update(CreateUpdateSupplierRequest $rq, $id)
    {
        //dd($rq);
        $editSuppliers=Supplier::find($id);
        $editSuppliers->name=$rq->name;
        $editSuppliers->address=$rq->address;
        $editSuppliers->phone=$rq->phone;
        $editSuppliers->description=$rq->description;
        $editSuppliers->slug=Str::slug($rq->name);
        $editSuppliers->save();
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thành công!"
        ]);
    }

    public function destroy(string $id)
    {
        Supplier::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }
    public function trash(){
        return view('supplier.trash');
    }

    public function dataTableTrash(){
        $trash = Supplier::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }
    public function untrash($id)
    {   
        Supplier::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }

}
