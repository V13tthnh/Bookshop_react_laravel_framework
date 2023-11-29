<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Str;
use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategories = Category::all();
        $id = 1;
        return view('category.index', compact('listCategories', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dataTable()
    {
        return Datatables::of(Category::query())->make(true);
    }
    public function create()
    {
        return view("category.create");
    }

    public function store(Request $rq)
    {
        $name = Category::where('name', $rq->name)->first();
        if ($name != null) {
            return response()->json([
                'success' => false,
                'message' => "Tên danh mục đã tồn tại!"
            ]);
        }
        $categories = new Category();
        $categories->name = $rq->name;
        $categories->description = $rq->description;
        $categories->slug = Str::slug($rq->name);
        $categories->save();
        return response()->json([
            'success' => true,
            'message' => "Thêm thành công!"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }


    public function edit($id)
    {
        $editCategories = Category::find($id);
        return response()->json([
            'success' => true,
            'data' => $editCategories
        ]);
    }

    public function update(Request $rq, $id)
    {
        //dd($rq);
        $category = Category::where('id', '<>', $id)->where('name', $rq->name)->first();
        if ($category != null) {
            return response()->json([
                'success' => false,
                'message' => "Tên danh mục đã tồn tại!"
            ]);
        }
        $editCategories = Category::find($id);
        $editCategories->name = $rq->name;
        $editCategories->description = $rq->description;
        $editCategories->slug = Str::slug($rq->name);
        $editCategories->save();
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

    public function dataTableTrash(){
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
