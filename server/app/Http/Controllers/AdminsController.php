<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\admin;

class AdminsController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginHandler(Request $request){
        if(Auth::attempt(['email'=> $request->email, 'password'=>$request->password])){
            return redirect()->route('admin.index')->with('notification', "Đăng nhập thành công!");
        }
        return redirect()->back()->with('notification', "Sai email hoặc mật khẩu!");
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
        return view('admin.index', compact('admins'));
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
        dd($request);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
