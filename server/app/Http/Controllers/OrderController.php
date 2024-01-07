<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Combo;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function dataTable(){
        $orders = Order::with('customer')->get();
        //dd(\Carbon\Carbon::parse($orders->created_at)->format('d-m-Y'));
        return Datatables::of($orders)->addColumn('customer_name', function($orders){
            return $orders->customer->name;
        })->addColumn('created_at', function($orders){
            return \Carbon\Carbon::parse($orders->created_at)->format('d-m-Y');
        })->make(true);
    }

    public function dataTableDetail($id)
    {
        $orderDetail = OrderDetail::with('book', 'combo')->where('order_id', $id)->get();   

        return Datatables::of($orderDetail)->addColumn('book_name', function ($orderDetail) {
            return $orderDetail->book->name ?? "N/A";
        })->addColumn('combo_name', function ($orderDetail) {
            return $orderDetail->combo->name ?? "N/A";
        })->make(true);
    }
    
    public function editStatus($id)
    {
        $orderStatus = Order::find($id);
        return response()->json([
            'success' => true,
            'data' => $orderStatus
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $orderStatus = Order::find($id);
        if($orderStatus->status == 5){
            return response()->json([
                'success' => false,
                'message' => "Đơn hàng này đã được hủy rồi!"
            ]);
        }
        if($request->status == 5){
            $orderItems = OrderDetail::where('order_id',  $id)->get();
            foreach ($orderItems as $item) {
                 // Trả số lượng sách về kho nếu hủy đơn
                $book = Book::find($item->book_id);
                $book->quantity += $item->book_quantity;
                $book->save();
                // Trả số lượng combo về kho nếu hủy đơn
                $book = Combo::find($item->combo_id);
                $book->quantity += $item->combo_quantity;
                $book->save();
            }
        }
        //Cập nhật trạng thái hóa đơn
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        return response()->json([
            'success' => true,
            'message' => "Đã cập nhật trạng thái!"
        ]);
    }
}
