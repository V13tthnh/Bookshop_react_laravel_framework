<?php

namespace App\Http\Controllers;

use App\Http\Requests\APIRegisterRequest;
use App\Http\Requests\APIUpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Hash;
use Storage;
class APICustomerController extends Controller
{

    public function index()
    {
        $listUser = Customer::all();
        return response()->json([
            'success' => true,
            'data' => $listUser
        ]);
    }

    public function register(APIRegisterRequest $request)
    {
        if($request->confirm_password != $request->password){
            return response()->json([
                'success' => false,
                'message' => "* Mật khẩu xác nhận phải trùng khớp với trường mật khẩu!"
            ]);
        }
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->status = 1;
        $customer->save();
        return response()->json([
            'success' => true,
            'message' => "Đăng ký tài khoản thành công!"
        ]);
    }

    public function store(Request $rq)
    {
        $listUser = Customer::where('email', $rq->name)->first();
        if (!empty($listUser)) {
            return response()->json([
                'success' => false,
                'message' => "Email {$rq->email} đã tồn tại"
            ]);
        }
        $listUser = new Customer;
        $listUser->name = $rq->name;
        $listUser->address = $rq->address;
        $listUser->phone = $rq->phone;
        $listUser->status = 1;
        $listUser->email = $rq->email;
        $listUser->password = $rq->password;
        if ($rq->hasFile('image')) {
            $file = $rq->image;
            $path = $file->store('uploads/customers');
            $listUser->image = $path;
        }
        $listUser->save();
        return response()->json([
            'success' => true,
            'message' => 'Lưu thông tin thành công'
        ]);
    }

    public function show(Request $rq)
    {
        $count = Customer::where('name', $rq->name)->count();
        if (empty($rq->name) || $count == 0) {
            return response()->json([
                'success' => false,
                'message' => "tim that bai"
            ]);
        }

        $findUser = Customer::where('name', $rq->name)->get();
        return response()->json([
            'success' => true,
            'data' => $findUser
        ]);
    }

    public function update(APIUpdateCustomerRequest $request, $id)
    {
        $user = Customer::find($id);
        if (empty($user)) {
            return response()->json([
                'success' => false,
                'message' => "Không có dữ liệu người dùng!"
            ]);
        }
        // Kiểm tra request có yêu cầu cập nhật mật khẩu không nếu có thì cập nhật không thì bỏ qua
        if (!empty($request->password)) {
            // Kiểm tra mật khẩu cũ có khớp trong csdl nếu không thông báo lỗi
            if (!Hash::check($request->oldPassword, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => "Mật khẩu không trùng khớp!",
                ]);
            }
            $user->password = Hash::make($request->password);
        }
        // Kiểm tra request có yêu cầu cập nhật email không nếu có thì cập nhật không thì bỏ qua
        if (!empty($request->email)) {
            $user->email = $request->email;
        }
        //Kiểm tra request có file ảnh không nếu có thì cập nhật ảnh còn không thì bỏ qua
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete($user->image);
            }
            $file = $request->file('image');
            $fileName = date('His') . $file->getClientOriginalName();
            $path = $request->file('image')->storeAs('uploads/customers', $fileName, 'local');
            $user->image = $path;
        }
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thông tin tài khoản thành công!"
        ]);
    }

    public function update_image(Request $request, $id)
    {
        $user = Customer::find($id);
        //Kiểm tra request có file ảnh không nếu có thì thêm ảnh còn không thì bỏ qua
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = date('His') . $file->getClientOriginalName();
            $path = $request->file('image')->storeAs('uploads/', $fileName, 'public');
            $user->image = $path;
        }
    }
}
