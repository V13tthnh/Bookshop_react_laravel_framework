<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Customer;
use App\Models\GoodsReceivedNote;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    public function overview(){
        $totalOrders = Order::count();
        $books = Book::count();
        $customers = Customer::count();
        $goodsReceivedNotes = GoodsReceivedNote::sum('total');
        return view('dashboard.index', compact('totalOrders', 'books', 'customers', 'goodsReceivedNotes'));
    }

    public function getChart(){
        $ordersTotal = Order::where('status', 4)->get('total');
        $ordersDate = Order::where('status', 4)->get('created_at');
        $orderStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray(); 
        $bookTotal = DB::table('order_details')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->leftJoin('books', 'order_details.book_id', '=', 'books.id')
            ->where('orders.status','=', 4)
            ->where('order_details.book_id','<>', null)
            ->where('books.book_type','=', 0)
            ->sum(DB::raw('order_details.unit_price * order_details.quantity'));
        $ebookTotal = DB::table('order_details')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->leftJoin('books', 'order_details.book_id', '=', 'books.id')
            ->where('orders.status','=', 4)
            ->where('order_details.book_id','<>', null)
            ->where('books.book_type','=', 1)
            ->sum(DB::raw('order_details.unit_price * order_details.quantity'));
        $comboTotal = DB::table('order_details')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status','=', 4)
            ->where('order_details.combo_id','<>', null)
            ->sum(DB::raw('order_details.unit_price * order_details.quantity'));
        return response()->json([
            'success' => true,
            'orderTotal' => $ordersTotal,
            'orderStatus' => $orderStatus,
            'orderDate' => $ordersDate,
            'bookTotal' =>  $bookTotal,
            'comboTotal' => $comboTotal,
            'ebookTotal' => $ebookTotal
        ]);
    }

    public function hotSelling(){
        $comboSales = OrderDetail::with('combo')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->select('order_details.combo_id', 'order_details.unit_price', DB::raw('SUM(order_details.quantity) as total_sold'))
            ->where('order_details.combo_id', '<>', null)
            ->where('orders.status', '=', 4) 
            ->groupBy('order_details.combo_id', 'order_details.unit_price')
            ->get();
        $bookSales = OrderDetail::with('book')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->select('order_details.book_id', 'order_details.unit_price', DB::raw('SUM(order_details.quantity) as total_sold'))
            ->where('order_details.book_id', '<>', null)
            ->where('orders.status', '=', 4) 
            ->groupBy('order_details.book_id', 'order_details.unit_price')
            ->get();
        return response()->json([
            'success' => true,
            'BookHotSelling' => $bookSales,
            'comboHotSelling' => $comboSales,
        ]);
    }

    public function filterOrder(Request $request){
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $revenueData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->get();
        return response()->json([
            'success' => true,
            'filterData' => $revenueData
        ]);
    }
}
