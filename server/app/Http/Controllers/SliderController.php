<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Book;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateUpdateSliderRequest;
class SliderController extends Controller
{
    public function index()
    {
        $listBook=Book::all();
        return view('slider.index',compact('listBook'));
    }

    public function dataTable()
    {
        $listSlider=Slider::with('book')->get();
        return Datatables::of($listSlider)->addColumn('book_name', function($listSlider){
            return  $listSlider->book->name;
        })->make(true);
        
    }

    public function create()
    {
        //
    }

    public function store(CreateUpdateSliderRequest $request)
    {
        $slider=new Slider();
        $slider->name=$request->name;
        $slider->start_date=$request->start_date;
        $slider->end_date=$request->end_date;
        $slider->book_id=$request->book_id;
        if($request->hasFile('image')){ 
            $file = $request->image;
            $path = $file->store('uploads/sliders');
            $slider->image = $path; 
           
        }
        $slider->save();
        return response()->json([
            'success' => true,
            'message' => "Thêm thành công!"
        ]);
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
        $slider=Slider::find($id);
        return response()->json([
            'success' => true,
            'data' => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if($request->hasFile('image')){ 
            $slider=Slider::find($id);
            $file = $request->image;
            $path = $file->store('uploads/sliders');
            $slider->name=$request->name;
            $slider->start_date=$request->start_date;
            $slider->end_date=$request->end_date;
            $slider->book_id=$request->book_id;
            $slider->image = $path; 
            $slider->save();
        }
        else{
            $slider=Slider::find($id);
            $slider->name=$request->name;
            $slider->start_date=$request->start_date;
            $slider->end_date=$request->end_date;
            $slider->book_id=$request->book_id;
            $slider->save();
        }
        return response()->json([
            'success' => true,
            'message' => "Sửa thành công!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Slider::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }
    public function trash(){
        return view('slider.trash');
    }

    public function dataTableTrash(){
        $trash = Slider::onlyTrashed()->with('book')->get();
        return Datatables::of($trash)->addColumn('book_name', function($trash){
            return $trash->book->name;
        })->make(true);
    }

    public function untrash($id)
    {   
        Slider::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
