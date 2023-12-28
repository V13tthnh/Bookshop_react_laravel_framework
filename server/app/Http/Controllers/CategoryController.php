<?php

namespace App\Http\Controllers;

use App\Imports\CategoriesImport;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUpdateCategoryRequest;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $listCategories = Category::all();
        $id = 1;
        return view('category.index', compact('listCategories', 'id'));
    }

    public function dataTable()
    {
        return Datatables::of(Category::query())->make(true);
    }
    public function create()
    {
        return view("category.create");
    }

    public function import(Request $request)
    {
        if($request->file_excel == "undefined"){
            return response()->json([
                'success' => false,
                'message' => "Vui lòng chọn file cần nhập!",
            ]);
        }
        if ($request->hasFile('file_excel')) {
            $path = $request->file('file_excel')->getRealPath();
            try{
                Excel::import(new CategoriesImport, $path);
            }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
                $failures = $e->failures(); //Lấy danh sách thông báo lỗi
                return response()->json([
                    'success' => false,
                    'message' => "Nhập không thành không!",
                    'errors' => $failures
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => "Nhập thành công!",
        ]);
    }

    public function store(CreateUpdateCategoryRequest $rq)
    {
        $categories = Category::updateOrCreate(['name' => $rq->name], ['description' => $rq->description]);
        return response()->json([
            'success' => true,
            'message' => "Thêm thành công!",
        ]);
    }

    public function edit($id)
    {
        $editCategories = Category::find($id);
        return response()->json([
            'success' => true,
            'data' => $editCategories
        ]);
    }

    public function update(CreateUpdateCategoryRequest $rq, $id)
    {
        $category = Category::where('id', '<>', $id)->where('name', $rq->name)->first();
        if ($category != null) {
            return response()->json([
                'success' => false,
                'message' => "Tên danh mục đã tồn tại!"
            ]);
        }
        $categories = Category::updateOrCreate(['id' => $id], ['name' => $rq->name, 'description' => $rq->description]);
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thành công!"
        ]);
    }


    public function destroy(string $id)
    {
        category::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }

    public function trash()
    {
        return view('category.trash');
    }

    public function dataTableTrash()
    {
        $trash = Category::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }

    public function untrash($id)
    {
        category::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
