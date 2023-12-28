<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function login()
    {

    }

    public function register()
    {

    }

    public function create()
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
        $count = User::where('name', $rq->name)->count();
        if (empty($rq->name) || $count == 0) {
            return response()->json([
                'success' => false,
                'message' => "tim that bai"
            ]);
        }

        $findUser = user::where('name', $rq->name)->get();
        return response()->json([
            'success' => true,
            'data' => $findUser
        ]);
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
