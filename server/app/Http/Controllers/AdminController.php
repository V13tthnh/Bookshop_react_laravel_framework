<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use Hash;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginHandler(Request $request){
        if(Auth::attempt(['email'=> $request->email, 'password'=>$request->password])){
            return redirect()->route('admin.index')->with('loginSuccessMsg', "Đăng nhập thành công!");
        }
        return redirect()->back()->with('errorMsg', "Sai email hoặc mật khẩu!");
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function index()
    {
        $admins = Admin::all();
        $id = 1;
        return view('admin.index', compact('admins', 'id'));
    }

    public function dataTable(Request $request)
    {
        return Datatables::of(Admin::query())->make(true);
    }

    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $email = Admin::where('email', $request->email)->first();
        if($email != null){
            //return redirect()->back()->with('errorMsg', "Email đã tồn tại!");
            return response()->json([
                'success'=> false,
                'message'=> "Email đã tồn tại!"
            ]);
        }

        if($request->hasFile('avatar')){ 
            $file = $request->avatar;
            $path = $file->store('uploads/admins');

            $admin = new Admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->avatar = $path; 
            $admin->save();
        }
        else{
            $admin = new Admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->save();
        }
        //return redirect()->route('admin.index')->with('successMsg', "Thêm thành công!");
        return response()->json([
            'success'=>true,
            'message'=> "Thêm thành công!"
        ]);
    }

    public function edit(string $id)
    {   
        $admin = Admin::find($id);
        if($admin == null){
            //return redirect()->back()->with('errorMsg', "Dữ liệu không tồn tại!");
            return response()->json([
                'success'=>false,
                'message'=> "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $admin
        ]);
    }

    public function update(Request $request)
    {
        //dd($request->id);       
        $email = Admin::where('id', '<>', $request->id)->where('email', $request->email)->first();
        if($email != null){
            //return redirect()->back()->with('errorMsg', "Email đã tồn tại!");
            return response()->json([
                'success'=>false,
                'message'=> "Email đã tồn tại!"
            ]);
        }
        if($request->hasFile('avatar')){ 
            $file = $request->avatar;
            $path = $file->store('uploads/admins');
            $admin = Admin::find($request->id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->avatar = $path; 
            $admin->save();
        }
        else{
            $admin = Admin::find($request->id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->save();
        }
        //return redirect()->back()->with('successMsg', "Cập nhật thành công!");
        return response()->json([
            'success'=> true,
            'message'=> "Cập nhật thành công!"
        ]);
    }

    public function destroy(string $id)
    {
        Admin::find($id)->delete();
        return response()->json([
            'success'=> true,
            'message'=> "Xóa thành công!"
        ]);
    }

    public function trash(){
        return view('admin.trash');
    }

    public function dataTableTrash(){
        $trash = Admin::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }

    public function untrash($id)
    {   
        Admin::withTrashed()->find($id)->restore();
        //return back()->with('successMsg', 'Khôi phục thành công!');
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
