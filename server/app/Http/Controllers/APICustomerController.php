<?php

namespace App\Http\Controllers;

use App\Http\Requests\APIRegisterRequest;
use App\Http\Requests\APIUpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Hash;
use Storage;
use Str;
use URL;
use Mail;

class APICustomerController extends Controller
{

    public function index()
    {
        $listCustomer = Customer::all();
        return response()->json([
            'success' => true,
            'data' => $listCustomer
        ]);
    }

    public function register(APIRegisterRequest $request)
    {
        if ($request->confirm_password != $request->password) {
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

    public function forgetPassword(Request $request)
    {
        try {
            $customer = Customer::where('email', $request->email)->get();
            if (count($customer) > 0) {
                $token = Str::random(40);
                $domain = URL::to('http://localhost:3000');
                $url = $domain . '/reset-password?token=' . $token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = "BookShop - Reset Password";
                $data['body'] = "Please click on below link to reset your password";

                Mail::send('emails.check_email_forget', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $datetime = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                );
                return response()->json(['success' => true, 'msg' => 'Please check your mail to reset password !']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Not found!']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function resetpasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->get();
        if (isset($request->token) && count($resetData) > 0) {
            $customer = Customer::where('email', $resetData[0]['email'])->get();
        } else {
            return response()->json(['success' => false, 'url' => '404']);
        }
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' =>
                [
                    'required',
                    'string',
                    'min:6',
                    'confirmed'
                ]
        ]);

        $customer = Customer::find($request->id);
        $customer->password = Hash::make($request->password);
        $customer->save();
        PasswordReset::where('email', $customer->email)->delete();
        return '<h1> Your password has been reset! </h1>';
    }

    public function store(Request $rq)
    {
        $listCustomer = Customer::where('email', $rq->name)->first();
        if (!empty($listCustomer)) {
            return response()->json([
                'success' => false,
                'message' => "Email {$rq->email} đã tồn tại"
            ]);
        }
        $listCustomer = new Customer;
        $listCustomer->name = $rq->name;
        $listCustomer->address = $rq->address;
        $listCustomer->phone = $rq->phone;
        $listCustomer->status = 1;
        $listCustomer->email = $rq->email;
        $listCustomer->password = $rq->password;
        if ($rq->hasFile('image')) {
            $file = $rq->image;
            $path = $file->store('uploads/customers');
            $listCustomer->image = $path;
        }
        $listCustomer->save();
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

        $findCustomer = Customer::where('name', $rq->name)->get();
        return response()->json([
            'success' => true,
            'data' => $findCustomer
        ]);
    }

    public function update(APIUpdateCustomerRequest $request, $id)
    {
        $Customer = Customer::find($id);
        if (empty($Customer)) {
            return response()->json([
                'success' => false,
                'message' => "Không có dữ liệu người dùng!"
            ]);
        }
        // Kiểm tra request có yêu cầu cập nhật mật khẩu không nếu có thì cập nhật không thì bỏ qua
        if (!empty($request->password)) {
            // Kiểm tra mật khẩu cũ có khớp trong csdl nếu không thông báo lỗi
            if (!Hash::check($request->oldPassword, $Customer->password)) {
                return response()->json([
                    'success' => false,
                    'message' => "Mật khẩu không trùng khớp!",
                ]);
            }
            $Customer->password = Hash::make($request->password);
        }
        // Kiểm tra request có yêu cầu cập nhật email không nếu có thì cập nhật không thì bỏ qua
        if (!empty($request->email)) {
            $Customer->email = $request->email;
        }
        //Kiểm tra request có file ảnh không nếu có thì cập nhật ảnh còn không thì bỏ qua
        if ($request->hasFile('image')) {
            if ($Customer->image) {
                Storage::delete($Customer->image);
            }
            $file = $request->file('image');
            $fileName = date('His') . $file->getClientOriginalName();
            $path = $request->file('image')->storeAs('uploads/customers', $fileName, 'local');
            $Customer->image = $path;
        }
        $Customer->name = $request->name;
        $Customer->address = $request->address;
        $Customer->phone = $request->phone;
        $Customer->save();
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thông tin tài khoản thành công!"
        ]);
    }

    public function update_image(Request $request, $id)
    {
        $Customer = Customer::find($id);
        //Kiểm tra request có file ảnh không nếu có thì thêm ảnh còn không thì bỏ qua
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = date('His') . $file->getClientOriginalName();
            $path = $request->file('image')->storeAs('uploads/', $fileName, 'public');
            $Customer->image = $path;
        }
    }
}
