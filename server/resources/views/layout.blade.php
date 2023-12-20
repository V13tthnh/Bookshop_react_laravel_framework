<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookShop Dashboard</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.cs')}}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{asset('plugins/dropzone/min/dropzone.min.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
    
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('dist/img/book.png')}}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.logout')}}" role="button">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <img src="{{asset('dist/img/book.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">BookShop</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @auth
                        @if(Auth::user()->avatar != null)
                        <img src="{{asset('/'.Auth::user()->avatar)}}" class="img-circle elevation-2" alt="User Image">
                        @else
                        <img src="{{asset('dist/img/user.jpg')}}" class="img-circle elevation-2" alt="User Image">
                        @endif
                        @endauth
                    </div>
                    <div class="info">
                        <a href="{{route('admin.profile')}}" class="d-block">{{Auth::user()->name}}</a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{route('dashboard.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Trang chủ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('book.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Sách
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('book.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Danh sách</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('category.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="fas fa-tag nav-icon"></i>
                                        <p>Thể loại</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('author.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="fas fa-pen nav-icon"></i>
                                        <p>Tác giả</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('publisher.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="fas fa-building nav-icon"></i>
                                        <p>Nhà xuất bản</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('supplier.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="fas fa-truck nav-icon"></i>
                                        <p>Nhà cung cấp</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('combo.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="fas fa-box nav-icon"></i>
                                        <p>Combo sách</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>
                                    Tài khoản
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Nhân viên</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="nav-icon fas fa-user-tie"></i>
                                        <p>Khách hàng</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item menu-open">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>
                                    Hóa đơn
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('goods-received-note.index')}}" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Hóa đơn nhập</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./index2.html" class="nav-link">
                                        <i class="fas fa-arrow-right nav-icon"></i>
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Hóa đơn bán</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('goods-received-note.create')}}" class="nav-link">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    Nhập hàng
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('slider.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-ad"></i>
                                <p>Banner</p>
                            </a>
                        </li>
                </nav>
            </div>
        </aside>

        <!-- Main content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2023
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widgridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    @if(session('loginSuccessMsg'))
    <script>
        Swal.fire({
            title: '{{session('loginSuccessMsg')}}',
            text: 'Xin chào {{Auth::user()->name}}',
            icon: 'success',
            confnText: 'OK'
        });
    </script>
    @endif
    <!-- bs-custom-file-input -->
    <script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <!-- dropzonejs -->
    <script src="{{asset('plugins/dropzone/min/dropzone.min.js')}}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.js')}}"></script>
    <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    @yield('js')
</body>

</html>