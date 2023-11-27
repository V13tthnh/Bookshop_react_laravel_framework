<?php

namespace App\Http\Controllers;
use App\Models\order;
use App\Models\order_detail;
use App\Models\user;
use Illuminate\Http\Request;

class APIOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listOrder = order::all();
        return response()->json([
            'success' => true,
            'data' => $listOrder
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
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

            $listOrder = new order();
        
            $listOrder->user_id=1;
            $listOrder->name=$rq->name;
            $listOrder->address=$rq->address;
            $listOrder->phone=$rq->phone;
            $listOrder->total=null;
            $listOrder->shipping_fee=$rq->shipping_fee;
            $listOrder->note=$rq->note;
            $listOrder->status=1;
            $listOrder->save();

            for($i=0;$i< count($rq->book_id);$i++)
            {
                $detail= new order_detail();
                $detail->order_id= $listOrder->id;
                $detail->book_id=$rq->book_id[$i];
                $detail->quantity=$rq->quantity[$i];
                $detail->unit_price =$rq->unit_price[$i];
                $detail->sale_price=$rq->sale_price[$i];
                $detail->review_status=$rq->review_status[$i];
            }

            return response()->json([
                'success'=>true,
                'message'=> 'Them loai san pham thanh cong'
            ]);
       
        $listOrder = order::where('name',$rq->name)->first();
        if(!empty($listOrder)){
            return response()->json([
                'success'=> false,
                'message'=> "Loai san pham {$rq->name} da ton tai"
            ]);
        }
    
      
       
    }
    public function details($id)
    {
        $listOrder=order::with('user')->find($id);
        if(empty($listOrder))
        {
            return response()->json([
                'success' => false,
                'message'   => "San Pham Khong Ton Tai"
            ]);
        }
        return response()->json([
            'success' => true,
            'data'  => $listOrder
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $rq)
    {
        // $count = order_detail::where('order_id',$rq->id)->count();
        // if(empty($rq->name)|| $count==0){
        //     return response()->json([
        //         'success' => false,
        //         'message' => "tim that bai"
        //     ]);
        // }
         
        $findOrder = order_detail::where('order_id',$rq->id)->get();
        return response()->json([
            'success' => true,
            'data' => $findOrder
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $rq, $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $listOrder=order::find($id);
        // if(empty($listOrder)){
        //     return response()->json([
        //         'success' => false,
        //         'message'=> "Hoa don ID={$id} khong ton tai"
        //     ]);
            
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        // $listOrder=order::find($id);
        // if(empty($listOrder)){
        //     return reponse()->json([
        //         'success'=>false,
        //         'message'=>"Loai san pham ID={$id} khong ton tai"
        //     ]);
        // }

        // $listOrder->delete();

        // return reponse()->json([
        //     'success'=>true,
        //     'message'=>"Xoa loai san pham thanh cong"
        // ]);
    }
}
