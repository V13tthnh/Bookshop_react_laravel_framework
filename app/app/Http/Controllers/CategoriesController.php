<?php

namespace App\Http\Controllers;
use App\Models\categorie;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.detailsCategories');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listCategories = categorie::all();
        return view("admin.categories.categories",compact('listCategories'));
    }
    public function actionCreate(Request $rq)
    {
        $categories = new categorie();
        $categories->name= $rq->ten_danh_muc;
        $categories->description=$rq->mo_ta;
        $categories->slug=$rq->book_slug;
        $categories->save();
        // return redirect()->route('sanpham.trangchu')->with('thong_bao', 'thành công');
        return 'them thanh cong';
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $listCategories = categorie::all();
        return view("admin.categories.listCategories",compact('listCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $editCategories=categorie::find($id);
        return view("admin.categories.editCategories",compact('editCategories'));
    }
    public function editHandle(Request $rq,$id)
    {
        $editCategories=categorie::find($id);
        if($editCategories)
        {
            $editCategories->name=$rq->ten_danh_muc;
            $editCategories->description=$rq->mo_ta;
            $editCategories->slug=$rq->book_slug;
            $editCategories->save();
        }
        return 'thanh cong';
    }

    /**
     * Update the specified resource in storage.
     */
    public function deleteHandle($id)
    {
        $deleteCategories=categorie::find($id);
        if($deleteCategories)
        {
            $deleteCategories->delete();
            return view('admin.categories.listCategories');
        }
        else
            return 'xoa that bai';
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
