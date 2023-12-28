<?php

namespace App\Http\Controllers;

use App\Imports\AuthorsImport;
use Illuminate\Http\Request;
use App\Models\Author;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateUpdateAuthorRequest;
use Maatwebsite\Excel\Facades\Excel;
use Str;
class AuthorController extends Controller
{
    public function index(Request $request){
        return view('author.index');
    }

    public function dataTable(Request $request){
        $listAuthor=Author::all();
        return Datatables::of($listAuthor)->make(true);
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
                Excel::import(new AuthorsImport, $path);
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

    public function store(CreateUpdateAuthorRequest $request)
    {
        if($request->hasFile('avatar')){
            $file = $request->avatar;
            $path = $file->store('uploads/authors');
            $author = Author::updateOrCreate(
                ['name' => $request->name], 
                ['description' => $request->description, 'slug' => Str::slug($request->name),'image' => $path]
            );
            return response()->json([
                'success' => true,
                'message' => "Thêm thành công!"
            ]);
        }
        $author = Author::updateOrCreate(
            ['name' => $request->name], 
            ['description' => $request->description, 'slug' => Str::slug($request->name),]
        );
        return response()->json([
            'success' => true,
            'message' => "Thêm thành công!"
        ]);
    }

    public function edit($id)
    {
        $author=Author::find($id);
        return response()->json([
            'success' => true,
            'data' =>  $author
        ]);
    }

    public function update(CreateUpdateAuthorRequest $request, $id)
    {
        if($request->hasFile('avatar')){
            $file = $request->avatar;
            $path = $file->store('uploads/authors');
            $author = Author::updateOrCreate(
                ['id' => $id], 
                ['name' => $request->name,'description' => $request->description, 'slug' => Str::slug($request->name),'image' => $path]
            );
            return response()->json([
                'success' => true,
                'message' => "Cập nhật thành công!"
            ]);
        }
        $author = Author::updateOrCreate(
            ['id' => $id], 
            ['name' => $request->name, 'description' => $request->description, 'slug' => Str::slug($request->name)]
        );
        return response()->json([
            'success' => true,
                'message' => "Cập nhật thành công!"
        ]);
      
    }

    public function destroy(string $id)
    {
        $author = Author::find($id);
        $author->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }

    public function dataTableTrash(){
        $trash = Author::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }
    public function trash(){
        return view('author.trash');
    }
    public function untrash($id)
    {   
        Author::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
