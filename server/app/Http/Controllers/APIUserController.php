<?php

namespace App\Http\Controllers;
use App\Models\order;
use App\Models\User;
use Illuminate\Http\Request;

class APIUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listUser= User::all();
        return response()->json([
            'success' => true,
            'data'  => $listUser
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $rq)
    {
        if(empty($rq->name))
        {
            return response()->json([
                'success' => false,
                'message' => 'Chua nhap ten khach hang'
            ]);
        }
        $listUser = User::where('email',$rq->name)->first();
        if(!empty($listUser)){
            return response()->json([
                'success'=> false,
                'message'=> "Email {$rq->email} da ton tai"
            ]);
        }
        $listUser = new User();
        $listUser->name=$rq->name;
        $listUser->address=$rq->address;
        $listUser->phone=$rq->phone;
        $listUser->status=1;
        $listUser->email=$rq->email;       
        $listUser->password=$rq->password;        
        $listUser->save();
        return response()->json([
            'success'=>true,
            'message'=> 'Thêm thông tin thành công'
        ]);
            
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $rq)
    {
        $count = User::where('name',$rq->name)->count();
        if(empty($rq->name)|| $count==0){
            return response()->json([
                'success' => false,
                'message' => "tim that bai"
            ]);
        }
        
        $findUser = user::where('name',$rq->name)->get();
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
