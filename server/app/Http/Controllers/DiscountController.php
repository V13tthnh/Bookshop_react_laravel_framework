<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateDiscountRequest;
use App\Models\Book;
use App\Models\Discount;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DiscountController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('discount.index', compact('books'));
    }

    public function dataTable(){
        $discounts = Discount::with('book')->get();
        return Datatables::of($discounts)->addColumn('book_name', function ($discounts) {
            return $discounts->book->name;
        })->addColumn('start_date', function($discounts){
            return \Carbon\Carbon::parse($discounts->start_date)->format('d-m-Y');
        })->addColumn('end_date', function($discounts){
            return \Carbon\Carbon::parse($discounts->end_date)->format('d-m-Y');
        })->make(true);
    }

    public function store(CreateUpdateDiscountRequest $request)
    {
        $discount = new Discount;
        $discount->book_id = $request->book_id;
        $discount->percent = $request->percent;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();
        return response()->json([
            'success' => true,
            'message' => "Thêm giảm giá thành công"
        ]);
    }

    public function edit(string $id)
    {
        $discount = Discount::find($id);
        if(empty($discount)){
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy giảm giá!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $discount
        ]);
    }

    public function update(CreateUpdateDiscountRequest $request, string $id)
    {
        $discount = Discount::find($id);
        if(empty($discount)){
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy giảm giá!"
            ]);
        }
        $discount->book_id = $request->book_id;
        $discount->percent = $request->percent;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thành công!"
        ]);
    }
}
