<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use App\Models\Order;
use App\Models\OrderDetail;

use Illuminate\Http\Request;

class APIOrderController extends Controller
{
    public function index()
    {
        $order = Order::all();
        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function store(Request $rq)
    {
        //dd($rq);
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
            if ($rq->book_id[$i] != null && $rq->book_quantity[$i] != null && $rq->book_price[$i] != null) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->book_id = $rq->book_id[$i];
                $orderDetail->quantity = $rq->book_quantity[$i];
                $orderDetail->unit_price = $rq->book_price[$i];
                $orderDetail->sale_price = null;
                $orderDetail->review_status = 0;
                $orderDetail->save();

                $total += $rq->book_total[$i];

                $bookQuantity = Book::find($rq->book_id[$i]);
                $bookQuantity->quantity -= $rq->book_quantity[$i];
                $bookQuantity->save();
            }

        }
        for ($i = 0; $i < count($rq->combo_id); $i++) {
            if ($rq->combo_id[$i] != null && $rq->combo_quantity[$i] != null && $rq->combo_price[$i] != null) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->combo_id = $rq->combo_id[$i];
                $orderDetail->quantity = $rq->combo_quantity[$i];
                $orderDetail->unit_price = $rq->combo_price[$i];
                $orderDetail->sale_price = null;
                $orderDetail->review_status = 0;
                $orderDetail->save();

                $total += $rq->combo_total[$i];

                $comboQuantity = Combo::find($rq->combo_id[$i]);
                $comboQuantity->quantity -= $rq->combo_quantity[$i];
                $comboQuantity->save();
            }

        }
        $orderTotal = Order::find($order->id);
        $orderTotal->total = $total + $rq->shipping_fee;
        $orderTotal->save();

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn đã mua hàng!'
        ]);
    }
    public function details($id)
    {
        $orderDetail = OrderDetail::with('book', 'combo')->where('order_id', $id)->get();
        if (empty($orderDetail)) {
            return response()->json([
                'success' => false,
                'message' => "Hóa đơn không tồn tại!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $orderDetail
        ]);
    }

    public function show(Request $rq, $id)
    {
        $findOrder = Order::with('orderDetails')->where('customer_id', $id)->get();
        if(empty($findOrder)){
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy hóa đơn!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $findOrder
        ]);
    }

    public function edit(Request $rq, $id)
    {

    }

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

    public function vnpay(Request $request)
    {
        session(['cost_id' => $request->id]);
        session(['url_prev' => url()->previous()]);
        $vnp_TmnCode = "UDOPNWS1"; //Mã website tại VNPAY 
        $vnp_HashSecret = "EBAHADUGCOEWYXCMYZRMTMLSHGKNRPBN"; //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/return-vnpay";
        $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->input('amount') * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
           // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }
}
