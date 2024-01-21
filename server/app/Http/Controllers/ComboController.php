<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateComboRequest;
use App\Models\Book;
use App\Models\Combo;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ComboController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $books = Book::all();
        return view('combo.index', compact('suppliers', 'books'));
    }

    public function dataTable()
    {
        $combos = Combo::all();
        return Datatables::of($combos)->make(true);
    }

    public function dataTableDetail($id)
    {
        $combo = Combo::find($id);
        return response()->json([
            'data' => $combo->books
        ]);
    }

    public function create()
    {
        $books = Book::where('book_type', 0)->get();
        $suppliers = Supplier::all();
        return view('combo.create', compact('books', 'suppliers'));
    }

    public function store(CreateUpdateComboRequest $request)
    {
        $combo = new Combo;
        $combo->supplier_id = $request->supplier_id;
        $combo->name = $request->name;
        $combo->price = $request->price;
        $combo->quantity = $request->quantity;
        $combo->overrate = 0;
        if ($request->hasFile('image')) {
            $file = $request->image;
            $path = $file->store('uploads/combos');
            $combo->image = $path;
        } else {
            $combo->image = null;
        }
        $combo->save();
        if (isset($request->book_ids)) {
            //Hàm explode() chuyển request từ string sang array vì hàm sync() chỉ nhận array
            //ví dụ: "2,3" => [2, 3]
            $bookIds = explode(',', $request->book_ids);
            $combo->books()->sync($bookIds);
        }
        return response()->json([
            'success' => true,
            'message' => "Tạo combo thành công!"
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $combo = Combo::find($id);
        return response()->json([
            'success' => true,
            'combo' => $combo,
            'books' => $combo->books
        ]);
    }

    public function update(CreateUpdateComboRequest $request, string $id)
    {

        $combo = Combo::find($id);
        if (empty($combo)) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy combo!"
            ]);
        }
        $combo->supplier_id = $request->supplier_id;
        $combo->name = $request->name;
        $combo->price = $request->price;
        $combo->quantity = $request->quantity;
        $combo->overrate = 0;
        if ($request->hasFile('image')) {
            $file = $request->image;
            $path = $file->store('uploads/combos');
            $combo->image = $path;
        }
        $combo->save();
        if (isset($request->book_ids)) {
            $bookIds = explode(',', $request->book_ids);
            $combo->books()->sync($bookIds);
        }
        return response()->json([
            'success' => true,
            'message' => "Sửa combo thành công!"
        ]);
    }

    public function destroy(string $id)
    {
        Combo::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }

    public function trash()
    {
        return view('combo.trash');
    }

    public function dataTableTrash()
    {
        $trash = Combo::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }

    public function untrash($id)
    {
        Combo::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
