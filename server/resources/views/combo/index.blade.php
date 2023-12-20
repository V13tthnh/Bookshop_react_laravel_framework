@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        $('#showDetail').hide();
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
            "ajax": { url: "{{route('combo.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'price', render: $.fn.dataTable.render.number('.', 2, '') },
                { data: 'quantity', name: 'quantity' },
                { data: 'image', render: function(data, type, row){ 
                    if(data != null){
                        return '<img src="'+data+'" alt="" sizes="40" srcset="" style="height:100px;width:100px">';
                    }
                    return "Không có ảnh";
                    }},
                {
                    data: 'id', render: function (data, type, row) {
                        return '<button class="btn btn-warning showDetail" value="' + data + '" data-toggle="modal" data-target="#modal-detail"><i class="nav-icon fa fa-eye"></i></button>';
                    }
                },
            ],
        });

        $('#myTable').on('click', '.showDetail', function(){
            var id = $(this).val();
            //alert(id);
            $.ajax({
                url: "combo/data-table-detail/" + id, method: "get", dataType: "json",
            }).done(function(res){
                //console.log(res.data);
                res.data.map(item => {
                    $('#tableDetail').append(
                        `<tr> 
                            <td>${item.pivot.combo_id}</td>
                            <td>${item.name}</td>
                        </tr>`);
                });
            })
        });
        
        $('#modal-detail').on('hidden.bs.modal', function(){
            $('#tableDetail tbody').text('');
        });
    });
</script>
@endsection

@section('content')
<div class="modal fade" id="modal-detail" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chi tiết combo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tableDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Sách</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<input type="text" id="idDetail" hidden>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách Combo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <a type="button" href="{{route('combo.create')}}" class="btn btn-success" >
                        <i class="nav-icon fas fa-edit"></i> Thêm Combo
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
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
                                    <th>Tổng tiền</th>
                                    <th>Số lượng</th>
                                    <th>Ảnh</th>
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