<?php

namespace App\Http\Controllers;

use App\Imports\AdminsImport;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use Hash;
use App\Http\Requests\CreateUpdateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\ValidateFormDashBoardLoginRequest;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginHandler(ValidateFormDashBoardLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard.index')->with('loginSuccessMsg', "Đăng nhập thành công!");
        }
        return redirect()->back()->with('loginErrorMsg', "Tài khoản hoặc mật khẩu không đúng!");;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function index()
    {
        $admins = Admin::all();
        $id = 1;
        return view('admin.index', compact('admins', 'id'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function dataTable(Request $request)
    {
        return Datatables::of(Admin::query())->make(true);
    }

    public function create()
    {
        return view('admin.create');
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
                Excel::import(new AdminsImport, $path);
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

    public function store(CreateUpdateAdminRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $path = $file->store('uploads/admins');
            $admin = Admin::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'avatar' => $path
                ]
            );
        } else {
            $admin = Admin::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]
            );
        }
        return response()->json([
            'success' => true,
            'message' => "Thêm thành công!"
        ]);
    }

    public function edit(string $id)
    {
        $admin = Admin::find($id);
        if ($admin == null) {
            return response()->json([
                'success' => false,
                'message' => "Dữ liệu không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $admin
        ]);
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $path = $file->store('uploads/admins');
            $admin = Admin::updateOrCreate(
                ['id' => $id],
                [
                    'email' => $request->email,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'role' => $request->role,
                    'avatar' => $path
                ]
            );
        } else {
            $admin = Admin::updateOrCreate(
                ['id' => $id],
                [
                    'email' => $request->email,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'role' => $request->role
                ]
            );
        }
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thành công!"
        ]);
    }

    public function destroy(string $id)
    {
        Admin::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }

    public function trash()
    {
        return view('admin.trash');
    }

    public function dataTableTrash()
    {
        $trash = Admin::onlyTrashed()->get();
        return Datatables::of($trash)->make(true);
    }

    public function untrash($id)
    {
        Admin::withTrashed()->find($id)->restore();
        return response()->json([
            'success' => true,
            'message' => "Khôi phục thành công!"
        ]);
    }
}
