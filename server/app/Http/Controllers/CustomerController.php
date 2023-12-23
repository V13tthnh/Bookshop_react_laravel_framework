<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class CustomerController extends Controller
{
    public function index(){
        return view('customer.index');
    }
    public function dataTable(){
        $customers = Customer::all();
        return Datatables::of($customers)->make(true);
    }
}
