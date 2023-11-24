<?php

namespace App\Http\Controllers;
use App\Models\goods_received_note;
use App\Models\goods_received_note_details;
use App\Models\supplier;
use App\Models\admin;
use App\Models\book;
use Auth;
use Illuminate\Http\Request;

class GoodsReceivedNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSupplier = supplier::all();
        $listGoodsReceivedNote= goods_received_note::paginate(10);
        $listAdmin=admin::all();
        $id = 1;
        return view('goods_received_note.index',compact('listGoodsReceivedNote','listSupplier','listAdmin' ,'id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listSupplier = supplier::all();
        $listbook=book::all();
        
        return view('goods_received_note.create', compact('listSupplier','listbook'));
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $rq)
    {
        dd($rq);
        $createGoodsReceivedNote=new goods_received_note();
        $createGoodsReceivedNote->supplier_id=$rq->supplier;
        $createGoodsReceivedNote->formality=null;
        $createGoodsReceivedNote->admin_id=Auth::user()->id;
        $createGoodsReceivedNote->total=null;
        $createGoodsReceivedNote->status=1;
        $createGoodsReceivedNote->save();

        $total = 0;

        for($i = 0; $i < count($rq->book_id); $i++){
            // create goods_received_note_detail
            $detail = new goods_received_note_details();
            $detail->goods_received_note_id = $createGoodsReceivedNote->id;
            $detail->book_id = $rq->book_id[$i];
            $detail->quantity = $rq->quantity[$i];
            $detail->import_unit_price = $rq->import_unit_price[$i];
            $detail->export_unit_price = $rq->export_unit_price[$i];
            $detail->save();

            
            $total += $rq->total[$i];

            // update quantity and export price
            $updateBook = book::find($rq->book_id[$i]);
            $updateBook->quantity =  $rq->quantity[$i];
            $updateBook->unit_price =  $rq->export_unit_price[$i];
            $updateBook->save();
        }
        //update total goods_received_note
        $updateGPN = goods_received_note::find($createGoodsReceivedNote->id);
        $updateGPN->total = $total;
        $updateGPN->save();

        return redirect()->route('goods-received-note.index')->with('successMsg', 'Thêm thành công!');
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
