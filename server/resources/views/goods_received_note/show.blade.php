@extends('layout')

@section('js')
<script>
    $(document).ready(function(){
        $('#printBtn').click(function(){
            window.addEventListener("load", window.print());
        });
    });

</script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chi tiết hóa đơn nhập</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Chi tiết hóa đơn nhập</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> BookShop.
                                <small class="float-right">Ngày: {{$detail->created_at}}</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>{{$detail->supplier->name}}</strong><br>
                                {{$detail->supplier->address}}<br>
                                SĐT: {{$detail->supplier->phone}}<br>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong>BookShop</strong><br>
                                Hẻm 48<br>
                                Bùi Thị Xuân<br>
                                Phone: (069) 69 696 969<br>
                                Email: bookshop@wowy.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice #{{$detail->id}}</b><br>
                            <br>
                            <b>Order ID:</b> {{$detail->id}}<br>
                            <b>Payment Due:</b> #{{$detail->formality}}<br>
                            <b>Account:</b> {{$detail->admin->name}}
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sách</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($detail->goodReceivedNoteDetails as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->book->name}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{number_format($item->cost_price, 0, '', ',')}}</td>
                                            <td>{{number_format($item->quantity * $item->cost_price, 0, '', ',')}}</td>
                                        </tr>
                                    @empty
                                        <tr colspan=5>
                                            Không có sản phẩm nào trong hóa đơn
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-6">
                            <p class="lead">Payment Methods:</p>
                            <img src="../../dist/img/credit/visa.png" alt="Visa">
                            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                            <img src="../../dist/img/credit/american-express.png" alt="American Express">
                            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya
                                handango imeem
                                plugg
                                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{number_format($detail->total, 0, '', ',')}} vnđ</td>
                                    </tr>
                                    <!-- <tr>
                                        <th>Tax (9.3%)</th>
                                        <td>$10.34</td>
                                    </tr> 
                                    <tr>
                                        <th>Shipping:</th>
                                        <td>0</td>
                                    </tr>-->
                                    <tr>
                                        <th>Total:</th>
                                        <td>{{number_format($detail->total, 0, '', ',')}} vnđ</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <a id="printBtn" rel="noopener" target="_blank" class="btn btn-default"><i
                                    class="fas fa-print"></i> Print
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection