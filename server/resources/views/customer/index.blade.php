@extends('layout')

@section('js')
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false, //tùy chỉnh kích thước, phân trang
            "paging": true, "ordering": true, "searching": true,
            "pageLength": 10, 
            "dom": 'Bfrtip', 
            "buttons": [{extend:"copy", text:"Sao chép"}, //custom các button
                        {extend:"csv", text:"Xuất csv"}, 
                        {extend:"excel",text:"Xuất Excel"}, 
                        {extend:"pdf",text:"Xuất PDF"}, 
                        {extend:"print",text:"In"}, 
                        {extend:"colvis",text:"Hiển thị cột"}],
            "language": { search: "Tìm kiếm:" },
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": { url: "{{route('customer.data.table')}}", method: "get", dataType: "json", },
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'image', render: function(data, type, row){ 
                    if(data != null){
                        return '<img src="'+data+'" alt="" sizes="40" srcset="" style="height:100px;width:100px">';
                    }
                    return `<img src="{{asset('dist/img/user.jpg')}}" alt="" sizes="40" srcset="" style="height:100px;width:100px">`;
                    } 
                },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                
            ],
        });
    });
</script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách khách hàng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   
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
                        <h3 class="card-title">Danh sách admin</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Avatar</td>
                                    <td>Tên</td>
                                    <td>Địa chỉ</td>
                                    <td>Số điện thoại</td>
                                    <td>Email</td>
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