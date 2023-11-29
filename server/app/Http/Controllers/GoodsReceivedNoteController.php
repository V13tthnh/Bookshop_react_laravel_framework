<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceivedNote;
use App\Models\GoodsReceivedNoteDetail;
use App\Models\Supplier;
use App\Models\Admin;
use App\Models\Book;
use Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class GoodsReceivedNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSupplier = Supplier::all();
        $listGoodsReceivedNote = GoodsReceivedNote::all();
        $listAdmin = Admin::all();
        $id = 1;
        return view('goods_received_note.index', compact('listGoodsReceivedNote', 'listSupplier', 'listAdmin', 'id'));
    }

    public function dataTable()
    {
        $supplier_name = GoodsReceivedNote::with('supplier')->get();
        $admin_name = GoodsReceivedNote::with('admin')->get();
        return Datatables::of(GoodsReceivedNote::query())->addColumn('supplier_name', function ($supplier_name) {
            return $supplier_name->supplier->name;
        })->addColumn('admin_name', function ($admin_name) {
            return $admin_name->admin->name;
        })
            ->make(true);
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listSupplier = Supplier::all();
        $listbook = Book::all();

        return view('goods_received_note.create', compact('listSupplier', 'listbook'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $rq)
    {
        //dd($rq);
        if(empty($rq->supplier)){
            return redirect()->back()->with('errorMsg', 'Vui lòng nhập đầy đủ thông tin!');
        }
        $createGoodsReceivedNote = new GoodsReceivedNote();
        $createGoodsReceivedNote->supplier_id = $rq->supplier;
        $createGoodsReceivedNote->formality = null;
        $createGoodsReceivedNote->admin_id = Auth::user()->id;
        $createGoodsReceivedNote->total = null;
        $createGoodsReceivedNote->status = 1;
        $createGoodsReceivedNote->save();

        $total = 0;

        for ($i = 0; $i < count($rq->book_id); $i++) {
            // create goods_received_note_detail
            $detail = new GoodsReceivedNoteDetail();
            $detail->goods_received_note_id = $createGoodsReceivedNote->id;
            $detail->book_id = $rq->book_id[$i];
            $detail->quantity = $rq->quantity[$i];
            $detail->cost_price = $rq->import_unit_price[$i];
            $detail->selling_price = $rq->export_unit_price[$i];
            $detail->save();

            // update total 
            $total += $rq->total[$i];

            // update quantity and export price
            $updateBook = Book::find($rq->book_id[$i]);
            $updateBook->quantity += $rq->quantity[$i];
            $updateBook->unit_price = $rq->export_unit_price[$i];
            $updateBook->save();
        }
        //update total goods_received_note
        $updateGPN = GoodsReceivedNote::find($createGoodsReceivedNote->id);
        $updateGPN->total = $total;
        $updateGPN->save();

        return redirect()->route('goods-received-note.index')->with('successMsg', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = GoodsReceivedNoteDetail::where('goods_received_note_id', $id)->get();
        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }

    public function dataTableDetail(string $id)
    {
        $book_name = GoodsReceivedNoteDetail::with('book')->where('goods_received_note_id', $id)->get();
        return Datatables::of($book_name)->addColumn('book_name', function ($book_name) {
            return $book_name->book->name;
        })->make(true);
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
