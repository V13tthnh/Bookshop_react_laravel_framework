<?php

namespace App\Http\Controllers;

use App\Http\Requests\APIUpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Hash;
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

    public function register()
    {

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
        //dd($request->hasFile('image'));
        $user = Customer::find($id);
        if(empty($user)){
            return response()->json([
                'success' => false,
                'message' => "Không có dữ liệu người dùng!"
            ]);
        }
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        if($request->hasFile('image')){
            $file = $request->image;
            $path = $file->store('uploads/customers');
            $user->image = $path;
        }
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        if(!empty($request->email)){
            $user->email = $request->email;
        }
        $user->save();
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thông tin tài khoản thành công!"
        ]);
    }

}
