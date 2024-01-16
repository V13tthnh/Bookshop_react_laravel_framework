@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10,
            "dom": 'Bfrtip',
            "buttons": [{ extend: "copy", text: "Sao chép" }, //custom các button
            { extend: "csv", text: "Xuất csv" },
            { extend: "excel", text: "Xuất Excel" },
            { extend: "pdf", text: "Xuất PDF" },
            { extend: "print", text: `<i class="fas fa-print"></i> In` },
            { extend: "colvis", text: "Hiển thị cột" }],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('goods-received-note.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'supplier_name', name: 'supplier.name' },
                { data: 'admin_name', name: 'admin.name' },
                { data: 'total', render: $.fn.dataTable.render.number('.', 2, '') },
                { data: 'formality', name: 'formality' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning showDetail" value="' + data + '" data-toggle="modal" data-target="#modal-detail"><i class="nav-icon fa fa-eye"></i></button>';
                    }
                },
            ],
        });

        $('#myTable').on('click', '.showDetail', function () {
            var id = $(this).val();
            $.ajax({
                url: '/goods-received-note/show/' + id,
                method: 'get'
            }).done(function (res) {
                $('#invoices').append(`<section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-globe"></i> BookShop.
                                                <small class="float-right">Ngày: ${res.data.created_at}</small>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            From
                                            <address>
                                                <strong>${res.data.supplier.name}</strong><br>
                                                ${res.data.supplier.address}<br>
                                                Phone: ${res.data.supplier.phone}<br>
                                            </address>
                                        </div>
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
                                        <div class="col-sm-4 invoice-col">
                                            <b>Invoice #${res.data.id}</b><br>
                                            <br>
                                            <b>Order ID:</b>${res.data.id} <br>
                                            <b>Payment Due:</b>${res.data.formality} <br>
                                            <b>Account:${res.data.admin.name}</b> 
                                        </div>
                                    </div>

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
                                                <tbody id="detailTable">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- accepted payments column -->
                                        <div class="col-6">
                                            <p class="lead">Payment Methods:</p>
                                            <img src="../../dist/img/credit/visa.png" alt="Visa">
                                            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                                            <img src="../../dist/img/credit/american-express.png"
                                                alt="American Express">
                                            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
                                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly
                                                ning heekya
                                                handango imeem
                                                plugg
                                                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td> ${res.data.total.toLocaleString('vi-VN', {style: 'currency',currency: 'VND'})}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td>${res.data.total.toLocaleString('vi-VN', {style: 'currency',currency: 'VND'})}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row no-print">
                                        <div class="col-12">
                                            <a href="invoice-print.html" rel="noopener" target="_blank"
                                                class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                            <button type="button" class="btn btn-primary float-right"
                                                style="margin-right: 5px;">
                                                <i class="fas fa-download"></i> Generate PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>`);

                res.data.good_received_note_details.map(item => {
                    $('#detailTable').append(`<tr>
                                            <td>${item.id}</td>
                                            <td>${item.book.name}</td>
                                            <td>${item.quantity}</td>
                                            <td>${item.cost_price.toLocaleString('vi-VN', {style: 'currency',currency: 'VND'})}</td>
                                            <td>${(item.quantity * item.cost_price).toLocaleString('vi-VN', {style: 'currency',currency: 'VND'})}</td>
                                        </tr>`);
                });
            });
        });

        $('#modal-detail').on('hidden.bs.modal', function (){
            $('#invoices').text('');
        });
    });
</script>
@endsection

@section('content')
<div class="modal fade" id="modal-detail" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chi tiết phiếu nhập</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id='invoices'></div>
        </div>
    </div>
</div>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách phiếu nhập</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a type="button" href="{{route('goods-received-note.create')}}" class="btn btn-success">
                        <i class="nav-icon fas fa-edit"></i> Nhập hàng
                    </a>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách phiếu nhập</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th>Tên admin</th>
                                    <th>Tổng tiền</th>
                                    <th>Hình thức</th>
                                    <th>Ngày lập</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection