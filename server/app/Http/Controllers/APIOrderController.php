<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;

class APIOrderController extends Controller
{
    public function index()
    {
        $order = Order::all();
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function store(Request $rq)
    {
        $order = new Order();
        $order->customer_id = $rq->customer_id;
        $order->name = $rq->name;
        $order->address = $rq->address;
        $order->phone = $rq->phone;
        $order->total = null;
        $order->shipping_fee = $rq->shipping_fee;
        $order->note = $rq->note;
        $order->status = 1;
        $order->save();

        $total = 0;

        for ($i = 0; $i < count($rq->book_id); $i++) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->book_id = $rq->book_id[$i];
            $orderDetail->combo_id = null;
            $orderDetail->quantity = $rq->quantity[$i];
            $orderDetail->unit_price = $rq->unit_price[$i];
            $orderDetail->sale_price = $rq->sale_price[$i];
            $orderDetail->review_status = 1;

            $total += $rq->total[$i];

            

        }

        return response()->json([
            'success' => true,
            'message' => 'Them loai san pham thanh cong'
        ]);
    }
    public function details($id)
    {
        $order = Order::with('user')->find($id);
        if (empty($order)) {
            return response()->json([
                'success' => false,
                'message' => "San Pham Khong Ton Tai"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $order
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

        $findOrder = OrderDetail::where('order_id', $rq->id)->get();
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
        // $order=Order::find($id);
        // if(empty($order)){
        //     return response()->json([
        //         'success' => false,
        //         'message'=> "Hoa don ID={$id} khong ton tai"
        //     ]);

        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $order=Order::find($id);
        // if(empty($order)){
        //     return reponse()->json([
        //         'success'=>false,
        //         'message'=>"Loai san pham ID={$id} khong ton tai"
        //     ]);
        // }

        // $order->delete();

        // return reponse()->json([
        //     'success'=>true,
        //     'message'=>"Xoa loai san pham thanh cong"
        // ]);
    }
}
