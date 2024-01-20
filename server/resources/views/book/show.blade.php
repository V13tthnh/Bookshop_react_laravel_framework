@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$book->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{$book->name}}</h3>
                    <div class="col-12">
                        <img src="/{{count($book->images) != 0 ? $book->images[0]->front_cover : 'Sách chưa có ảnh!'}}" class="product-image" alt="Product Image">
                    </div>
                    <div class="col-12 product-image-thumbs">
                        <div class="product-image-thumb active"><img src="/{{count($book->images) != 0 ? $book->images[0]->front_cover : 'Sách chưa có ảnh!'}}"
                                alt="Product Image"></div>
                        @foreach($book->images as $item)
                            <div class="product-image-thumb"><img src="/{{$item->front_cover}}" alt="Product Image"></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{$book->name}}</h3>
                    <hr>
                    <h4>Danh mục</h4>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach($book->categories as $item)
                        <label class="btn btn-default text-center active">
                            <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                            {{$item->name}}
                            <br>
                        </label>
                        @endforeach
                    </div>
                    <h4 class="mt-3">Tác giả</h4>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach($book->authors as $item)
                        <label class="btn btn-default text-center">
                            <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                            {{$item->name}}
                            <br>
                        </label>
                        @endforeach
                    </div>
                    <table class="table border mt-3 mb-2">
                        <tbody>
                            <tr>
                                <th class="py-2">Loại sách:</th>
                                <td class="py-2">{{$book->book_type == 0 ? 'Sách in' : 'Ebook'}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Mã nhà cung cấp:</th>
                                <td class="py-2">{{$book->code}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Số lượng:</th>
                                <td class="py-2">{{$book->quantity}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Trọng lượng:</th>
                                <td class="py-2">{{$book->weight}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Kích thước:</th>
                                <td class="py-2">{{$book->size}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Hình thức:</th>
                                <td class="py-2">{{$book->format}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Năm XB:</th>
                                <td class="py-2">{{$book->year}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Ngôn ngữ:</th>
                                <td class="py-2">{{$book->language}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Số trang:</th>
                                <td class="py-2">{{$book->num_pages}}</td>
                            </tr>
                            <tr>
                                <th class="py-2">Người dịch:</th>
                                <td class="py-2">{{$book->translator}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="bg-gray py-2 px-3 mt-4">
                        <h2 class="mb-0">
                            {{$book->e_book_price != null ? number_format($book->e_book_price, 0, '.') :
                            number_format($book->unit_price, 0, '.')}} vnđ
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <nav class="w-100">
                    <div class="nav nav-tabs" id="product-tab" role="tablist">
                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc"
                            role="tab" aria-controls="product-desc" aria-selected="true">Mô tả</a>
                        <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
                            href="#product-comments" role="tab" aria-controls="product-comments"
                            aria-selected="false">Bình luận</a>
                        <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating"
                            role="tab" aria-controls="product-rating" aria-selected="false">Đánh giá</a>
                    </div>
                </nav>
                <div class="tab-content p-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                        aria-labelledby="product-desc-tab"> {{$book->description}}
                    </div>
                    <div class="tab-pane fade" id="product-comments" role="tabpanel"
                        aria-labelledby="product-comments-tab"> {{$book->overrate}} </div>
                    <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
                        <div class="d-flex justify-content-center">
                            <div class="content text-center" style="width: 420px; margin-top: 100px;">
                                <div class="ratings" style="background-color:#fff;
                                            padding: 54px;
                                            border: 1px solid rgba(0, 0, 0, 0.1);
                                            box-shadow: 0px 10px 10px #E0E0E0;">
                                    <span class="product-rating" style="font-size: 50px;">{{$book->overrate}}</span><span>/5</span>
                                    <div class="stars">
                                        <i class="fa fa-star" style="font-size: 18px; color: #28a745;"></i>
                                        <i class="fa fa-star" style="font-size: 18px; color: #28a745;"></i>
                                        <i class="fa fa-star" style="font-size: 18px; color: #28a745;"></i>
                                        <i class="fa fa-star" style="font-size: 18px; color: #28a745;"></i>
                                    </div>
                                    <div class="rating-text" style="margin-top: 10px;">
                                        <span>{{$book->overrate}} ratings & {{count($book->reviews)}} reviews</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection