<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slider;
use App\Models\book;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSlider=slider::all();
        $listBook=book::all();
        $id = 1;
        return view('slider.index',compact('listSlider', 'id', 'listBook'));
    }

    public function dataTable()
    {
        $listSlider=slider::all();
        return response()->json([
            'success'=>true,
            'data'=>$listSlider
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('image')){ 
            $file = $request->image;
            $path = $file->store('uploads');

            $slider=new slider();
            $slider->name=$request->name;
            $slider->start_date=$request->start_date;
            $slider->end_date=$request->end_date;
            $slider->book_id=$request->book_id;
            $slider->image = $path; 
            $slider->save();
        }
        else{
            $slider=new slider();
            $slider->name=$request->name;
            $slider->start_date=$request->start_date;
            $slider->end_date=$request->end_date;
            $slider->book_id=$request->book_id;
            $slider->save();
        }
        return redirect()->route('slider.index')->with('successMsg', "Thêm thành công!");

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
        $slider=slider::find($id);
        if($slider == null){
            return redirect()->back()->with('errorMsg', "Dữ liệu không tồn tại!");
        }
        return response()->json([
            'success' => 200,
            'data' => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if($request->hasFile('image')){ 
            $slider=slider::find($request->id);
            $file = $request->image;
            $path = $file->store('uploads');
            $slider->name=$request->name;
            $slider->start_date=$request->start_date;
            $slider->end_date=$request->end_date;
            $slider->book_id=$request->book_id;
            $slider->image = $path; 
            $slider->save();
        }
        else{
            $slider=slider::find($request->id);
            $slider->name=$request->name;
            $slider->start_date=$request->start_date;
            $slider->end_date=$request->end_date;
            $slider->book_id=$request->book_id;
            $slider->save();
        }
        return redirect()->route('slider.index')->with('successMsg', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider=slider::find($id)->delete();
        return redirect()->route('slider.index')->with('successMsg', 'Xoa thành công!');
    }
    public function trash(){
        $trash = slider::onlyTrashed()->get();
        $id=1;
        return view('slider.trash', compact('trash','id'));
    }

    public function untrash($id)
    {   
        slider::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
