<?php

namespace App\Http\Controllers;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategories = category::paginate(2);
        $id = 1;
        return view('category.index',compact('listCategories', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view("category.create");
    }
 
    public function store(Request $rq)
    {
        $name = category::where('name', $rq->name)->first();
        if($name != null){
            return redirect()->back()->with('errorMsg', 'Tên danh mục đã tồn tại!');
        }
        $categorys = new category();
        $categorys->name= $rq->name;
        $categorys->description=$rq->description;
        $categorys->slug=$rq->slug;
        $categorys->save();
        return redirect()->route('category.index')->with('successMsg', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }


    public function edit($id)
    {
        $editcategorys=category::find($id);
        return view("category.edit",compact('editcategorys'));
    }

    public function update(Request $rq,$id)
    {
        $editcategories=category::find($id);
        if($editcategories)
        {
            $editcategories->name=$rq->ten_danh_muc;
            $editcategories->description=$rq->mo_ta;
            $editcategories->slug=$rq->book_slug;
            $editcategories->save();
        }
        return 'thanh cong';
    }

    
    public function destroy(string $id)
    {
        category::find($id)->delete();
        return redirect()->route('category.index')->with('successMsg', 'Xóa thành công!');
    }

    public function trash(){
        $trash = category::onlyTrashed()->get();
        return view('category.trash', compact('trash'));
    }

    public function untrash($id)
    {   
        category::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
