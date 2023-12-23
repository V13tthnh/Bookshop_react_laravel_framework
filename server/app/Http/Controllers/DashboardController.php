<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Customer;
use App\Models\GoodsReceivedNote;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overview(){
        $orders = Order::count();
        $books = Book::count();
        $customers = Customer::count();
        $goodsReceivedNotes = GoodsReceivedNote::sum('total');
        return view('dashboard.index', compact('orders', 'books', 'customers', 'goodsReceivedNotes'));
    }
}
