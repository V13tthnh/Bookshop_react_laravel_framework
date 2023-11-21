<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $listSupplier = supplier::paginate(2);
        $id = 0;
        return view('supplier.index',compact('listSupplier', 'id'));
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
        $createSupplier=new supplier();
        $createSupplier->name=$rq->name;
        $createSupplier->address=$rq->address;
        $createSupplier->phone=$rq->phone;
        $createSupplier->description=$rq->description;
        $createSupplier->slug=$rq->slug;
        $createSupplier->save();
        return redirect()->route('supplier.index')->with('successMsg', 'Thêm thành công!');
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
        $editSuppliers=supplier::find($id);
        return view("supplier.edit",compact('editSuppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $rq, string $id)
    {
        $editSuppliers=supplier::find($id);
        if($editSuppliers)
        {
            $editSuppliers->name=$rq->name;
            $editSuppliers->address=$rq->address;
            $editSuppliers->phone=$rq->phone;
            $editSuppliers->description=$rq->description;
            $editSuppliers->slug=$rq->slug;
            $editSuppliers->save();
        }
        return 'thanh cong';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        supplier::find($id)->delete();
        return redirect()->route('supplier.index')->with('successMsg', 'Xóa thành công!');
    }
    public function trash(){
        $trash = supplier::onlyTrashed()->get();
        return view('supplier.trash', compact('trash'));
    }
    public function untrash($id)
    {   
        supplier::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
