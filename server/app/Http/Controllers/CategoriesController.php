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
        $listCategories = categorie::paginate(5);
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
        $name = categorie::where('name', $rq->name)->first();
        if($name != null){
            return redirect()->back()->with('errorMsg', 'Tên danh mục đã tồn tại!');
        }
        $categories = new categorie();
        $categories->name= $rq->name;
        $categories->description=$rq->description;
        $categories->slug=$rq->slug;
        $categories->save();
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
        $editCategories=categorie::find($id);
        return response()->json([
            'success' => 200,
            'category' => $editCategories
        ]);
    }

    public function update(Request $rq)
    {
           //dd($rq);
       $category=categorie::where('id', '<>', $rq->id)->where('name', $rq->name)->first();
       if($category != null){
        return redirect()->back()->with('errorMsg', 'Tên danh mục đã tồn tại!');
            }
            $editCategories=categorie::find($rq->id);
            $editCategories->name=$rq->name;
            $editCategories->description=$rq->description;
            $editCategories->slug=$rq->slug;
            $editCategories->save();
            return redirect()->route('category.index')->with('successMsg', 'Sửa thành công!');
    }

    
    public function destroy(string $id)
    {
        categorie::find($id)->delete();
        return redirect()->route('category.index')->with('successMsg', 'Xóa thành công!');
    }

    public function trash(){
        $trash = categorie::onlyTrashed()->get();
        return view('category.trash', compact('trash'));
    }

    public function untrash($id)
    {   
        categorie::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
