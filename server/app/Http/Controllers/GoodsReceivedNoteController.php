<?php

namespace App\Http\Controllers;

use App\Imports\GoodsReceivedNoteDetailImport;
use App\Models\GoodsReceivedNote;
use App\Models\GoodsReceivedNoteDetail;
use App\Models\Supplier;
use App\Models\Admin;
use App\Models\Book;
use Auth;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateUpdateGoodsReceivedNoteRequest;
use Illuminate\Http\Request;

class GoodsReceivedNoteController extends Controller
{
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
        })->make(true);
    }

    public function import(Request $request){
        // if($request->hasFile('file_excel')){
        //     $path = $request->file('file_excel')->getRealPath();
        //     Excel::import(new GoodsReceivedNoteDetailImport, $path);
        //     return back()->with('successMsg', 'Nhập thành công!');
        // }
        // return back()->with('errorMsg', 'Nhập không thành công!');
    }

    public function create()
    {
        $listSupplier = Supplier::all();
        $listbook = Book::all();
        return view('goods_received_note.create', compact('listSupplier', 'listbook'));
    }

    public function store(CreateUpdateGoodsReceivedNoteRequest $rq)
    {
        //dd($rq);
        $createGoodsReceivedNote = new GoodsReceivedNote();
        $createGoodsReceivedNote->supplier_id = $rq->supplier_id;
        $createGoodsReceivedNote->formality =  $rq->formality;
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
            $updateBook->e_book_price = $rq->export_unit_price[$i] - 10000;
            $updateBook->supplier_id = $rq->supplier_id;
            $updateBook->save();
        }
        //update total goods_received_note
        $updateGPN = GoodsReceivedNote::find($createGoodsReceivedNote->id);
        $updateGPN->total = $total;
        $updateGPN->save();

        return response()->json([
            'success' => true,
            'message' => "Thêm phiếu nhập thành công!"
        ]);
    }

    public function show(string $id)
    {
        $detail = GoodsReceivedNote::with('supplier', 'admin', 'goodReceivedNoteDetails.book')->find($id);
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
}
