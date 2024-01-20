@extends('layout')

@section('js')
<script>
  $(document).ready(function () {
    var total = [];
    var date = [];
    var orderChart = null;
    $('#hot_selling').append('');
    $('#date_range_picker').daterangepicker({
      startDate: moment().add(5, 'day'),
      locale: {
        format: 'DD-MM-YYYY'
      }
    });

    //Lấy dữ liệu hóa đơn đã thanh toán
    $.ajax({
      url: '{{route('dashboard.chart')}}',
      method: 'get',
    }).done(function (res) {
      res.orderDate.map(item => date.push(item.created_at));
      res.orderTotal.map(item => total.push(item.total));
      var areaChartData = {
        labels: date,
        datasets: [
          {
            label: 'Hóa đơn thanh toán',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: total
          },
        ]
      }
      var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: { display: false },
        scales: {
          xAxes: [{
            gridLines: {
              display: false,
            }
          }],
          yAxes: [{
            gridLines: {
              display: false,
            }
          }]
        }
      }
      var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
      orderChart = new Chart(areaChartCanvas, {
        type: 'bar',
        data: areaChartData,
        options: areaChartOptions
      })
      //Lấy số liệu trạng thái tất cả hóa đơn
      var donutData = {
        labels: [
          'Chờ xác nhận',
          'Đã xác nhận',
          'Đang giao',
          'Đã giao',
          'Đã hủy',],
        datasets: [
          {
            data: [res.orderStatus[1], res.orderStatus[2], res.orderStatus[3], res.orderStatus[4], res.orderStatus[5]],
            backgroundColor: ['#f39c12', '#3c8dbc', '#00c0ef', '#00a65a', '#f56954'],
          }
        ]
      }
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieData = donutData;
      var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      });
      //Lấy số liệu doanh thu
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData = {
        labels: [
          'Sách in',
          'Combo',
          'Ebook',
        ],
        datasets: [
          {
            data: [res.bookTotal, res.comboTotal, res.ebookTotal],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }

      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }

      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      });
    });

    //Lấy số liệu sách bán chạy
    $.ajax({
      method: 'get',
      url: '{{route('dashboard.hot.selling')}}',
      method: 'get'
    }).done(function (res) {
      //Render sách bán chạy
      res.BookHotSelling.map(book => {
        $('#hot_selling').append(`
          <tr>
            <td>
              ${book.book.name}
            </td>
            <td>${book.unit_price}</td>
            <td>
              <small class="text-success mr-1">
                <i class="fas fa-arrow-up"></i>
                12%
              </small>
              ${book.total_sold}
            </td>
            <td>
              <a href="{{route('book.index')}}" class="text-muted">
                <i class="fas fa-search"></i>
              </a>
            </td>
          </tr>`);
      });
      //Render combo bán chạy
      res.comboHotSelling.map(combo => {
        $('#combo_hot_selling').append(`
          <tr>
            <td>
              ${combo.combo.name}
            </td>
            <td>${combo.unit_price}</td>
            <td>
              <small class="text-success mr-1">
                <i class="fas fa-arrow-up"></i>
                12%
              </small>
              ${combo.total_sold}
            </td>
            <td>
              <a href="{{route('combo.index')}}" class="text-muted">
                <i class="fas fa-search"></i>
              </a>
            </td>
          </tr>`);
      });
    });

    $('#date_range_picker').on('apply.daterangepicker', function (ev, picker) {
      var startDate = picker.startDate.format('YYYY-MM-DD');
      var endDate = picker.endDate.format('YYYY-MM-DD');
      $('#store_start_date').val(startDate);
      $('#store_end_date').val(endDate);
      console.log(startDate, endDate);
    });

    function filterDataByDate(data, startDate, endDate) {
      return data.filter(function (item) {

        var date = new Date(item);
        return date >= startDate && date <= endDate;
      });
    }

    $('#filterBtn').click(function () {
      var start_date = new Date( $('#store_start_date').val());
      var end_date = new Date( $('#store_end_date').val());
      var filterByDate = filterDataByDate(date, start_date, end_date);
      
    });
  });
</script>
@endsection

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Trang chủ</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        </ol>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$totalOrders}}</h3>
            <p>Tổng hóa đơn</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$books}}<sup style="font-size: 20px"></sup></h3>
            <p>Tổng sách tồn kho</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{route('book.index')}}" class="small-box-footer">Xem thêm <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$customers}}</h3>
            <p>Khách hàng đăng ký</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$goodsReceivedNotes}}</h3>
            <p>Tổng tiền nhập</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{route('goods-received-note.index')}}" class="small-box-footer">Xem thêm <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- ------------------------------------------ -->
    <!-- Biểu đồ thống kê hóa đơn bán và trạng thái -->
    <!-- ------------------------------------------ -->
    <div class="row">
      <section class="col-lg-7 connectedSortable">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <div class="form-group">
                <label>Ngày bắt đầu - Ngày kết thúc:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="date_range_picker">
                  <input type="date" id="store_start_date" class="form-control" hidden>
                  <input type="date" id="store_end_date" class="form-control" hidden>
                  <button class="btn btn-primary ml-2" id="filterBtn">Lọc</button>
                </div>
              </div>
            </h3>
            <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                  <a class="nav-link active" href="#sales-chart" data-toggle="tab">Hóa đơn đã giao</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#pie-chart" data-toggle="tab">Trạng thái hóa đơn</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content p-0">
              <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 300px;">
                <canvas id="areaChart" width="800" height="400"></canvas>
              </div>
              <div class="chart tab-pane" id="pie-chart" style="position: relative; height: 300px;">
                <canvas id="pieChart" height="300" style="height: 300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- ------------- -->
      <!-- Sách bán chạy -->
      <!-- ------------- -->
      <section class="col-lg-5 connectedSortable">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Sách bán chạy</h3>
            <div class="card-tools">
              <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
              </a>
              <a href="{{route('book.index')}}" class="btn btn-tool btn-sm">
                <i class="fas fa-bars"></i>
              </a>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>Sách</th>
                  <th>Giá</th>
                  <th>Đã bán</th>
                  <th>Thông tin</th>
                </tr>
              </thead>
              <tbody id="hot_selling">
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <section class="col-lg-7 connectedSortable">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Doanh thu</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="donutChart"
                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </section>
      <!-- -------------- -->
      <!-- Combo bán chạy -->
      <!-- -------------- -->
      <section class="col-lg-5 connectedSortable">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Combo bán chạy</h3>
            <div class="card-tools">
              <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
              </a>
              <a href="{{route('combo.index')}}" class="btn btn-tool btn-sm">
                <i class="fas fa-bars"></i>
              </a>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>Combo</th>
                  <th>Giá</th>
                  <th>Đã bán</th>
                  <th>Thông tin</th>
                </tr>
              </thead>
              <tbody id="combo_hot_selling">
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
  </div>
</section>
@endsection