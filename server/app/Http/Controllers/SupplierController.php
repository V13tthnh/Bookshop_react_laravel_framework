<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Str;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSupplier = Supplier::all();
        $id = 1;
        return view('supplier.index',compact('listSupplier', 'id'));
    }

    public function dataTable(){
        return Datatables::of(Supplier::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("supplier.create");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $rq)
    {
        $name = Supplier::where('name', $rq->name)->first();
        if(!empty($name)){
            return response()->json([
                'success' => false,
                'message' => "Nhà cung cấp đã tồn tại!"
            ]);
        }
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editSuppliers=Supplier::find($id);
        return response()->json([
            'success' => true,
            'data' => $editSuppliers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $rq, $id)
    {
        //dd($rq);
        $suppliers=supplier::where('id', '<>', $id)->where('name', $rq->name)->first();
        if($suppliers!=null)
        {
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        } 
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

    /**
     * Remove the specified resource from storage.
     */
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
