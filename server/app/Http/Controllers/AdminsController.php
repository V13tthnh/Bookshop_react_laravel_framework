<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\admin;
use Hash;

class AdminsController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = admin::paginate(5);
        $id = 0;
        return view('admin.index', compact('admins', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $email = admin::where('email', $request->email)->first();
        if($email != null){
            return redirect()->back()->with('errorMsg', "Email đã tồn tại!");
        }

        if($request->hasFile('avatar')){ 
            $file = $request->avatar;
            $path = $file->store('uploads');

            $admin = new admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->avatar = $path; 
            $admin->save();
        }
        else{
            $admin = new admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->save();
        }
        return redirect()->route('admin.index')->with('successMsg', "Thêm thành công!");
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
        $admin = admin::find($id);
        if($admin == null){
            return redirect()->back()->with('errorMsg', "Dữ liệu không tồn tại!");
        }
        $role_list = admin::all();
        return view('admin.edit', compact('admin', 'role_list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $email = admin::where('id', '<>', $id)->where('email', $request->email)->first();
        if($email != null){
            return redirect()->back()->with('errorMsg', "Email đã tồn tại!");
        }
        if($request->hasFile('avatar')){ 
            $file = $request->avatar;
            $path = $file->store('uploads');
            $admin = admin::find($id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->avatar = $path; 
            $admin->save();
        }
        else{
            $admin = admin::find($id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $admin->role = $request->role;
            $admin->save();
        }
        return redirect()->route('admin.index')->with('successMsg', "Cập nhật thành công!");
    }

    public function destroy(string $id)
    {
        admin::find($id)->delete();
        return redirect()->route('admin.index')->with('successMsg', 'Xóa thành công!');
    }

    public function trash(){
        $trash = admin::onlyTrashed()->get();
        return view('admin.trash', compact('trash'));
    }

    public function untrash($id)
    {   
        admin::withTrashed()->find($id)->restore();
        return back()->with('successMsg', 'Khôi phục thành công!');
    }
}
