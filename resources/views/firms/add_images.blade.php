<?php

use App\Order; ?>
<?php

use App\Product; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<script type="text/javascript">
    function deleteProductImages(url) {
        swal({
                title: "Сигурни ли сте?",
                text: "Ще бъде изтрита снимката за този продукт. Операцията е невъзвратима!",
                icon: "warning",
                buttons: ["Отказ!", "Съгласен съм!"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location = url;
                } else {
                    return false;
                }
            });
        return false;
    };
</script>
<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
                <aside>
                    <div class="sidebar-box">
                        <div class="user">
                            @if ($user->image != null)
                            <figure>
                                <img src="{{ asset('/images/backend_images/users/'.$user->image) }}" alt="">
                            </figure>
                            @endif
                            <div class="usercontent">
                                <h3>Здравейте {{ Auth::user()->name }}!</h3>
                                <h4>Търговец</h4>
                            </div>
                        </div>
                        <nav class="navdashboard">
                            <ul>
                                <li>
                                    <a class="active" href="{{ route('home-firm') }}">
                                        <i class="lni-dashboard"></i><span>Панел управление</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-settings') }}">
                                        <i class="lni-cog"></i><span>Настройки профил</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-adds', ['payed' => 'No']) }}">
                                        <i class="lni-layers"></i><span>Моите оферти</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-orders') }}">
                                        <i class="lni-envelope"></i><span>Поръчки</span>
                                        @php
                                        $products_ids = [];
                                        $products_loc = Product::where(['user_id'=>Auth::user()->id])->get();
                                        foreach ($products_loc as $prod){
                                        $products_ids[] = $prod->id;
                                        }

                                        $order_count = Order::whereIn('product_id', $products_ids)->where(['status'=>'unread'])->count();
                                        @endphp
                                        @if($order_count == 0)
                                        <span style="float:right;padding-right:10px;">
                                            <p>{{ $order_count }} бр.</p>
                                        </span>
                                        @else
                                        <span style="float:right;padding-right:10px;">
                                            <p class="order_blink">{{ $order_count }} бр.</p>
                                        </span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-payments') }}">
                                        <i class="lni-wallet"></i><span>Плащания</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-privacy') }}">
                                        <i class="lni-star"></i><span>Лични</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout-front-firm') }}">
                                        <i class="lni-enter"></i><span>Изход</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="widget">
                        <h4 class="widget-title">Advertisement</h4>
                        <div class="add-box">
                            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
                        </div>
                    </div>
                </aside>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="page-content">
                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Снимки за продукта: {{ $product->product_name }}</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            @if (Session::has('flash_message_error'))
                            <div class="alert alert-error alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_error') !!}</strong>
                            </div>
                            @endif @if (Session::has('flash_message_success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_success') !!}</strong>
                            </div>
                            @endif
                            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-add-product-images', ['id'=>$product->id]) }}" name="add_images" id="add_images" novalidate="novalidate">
                                @csrf
                                <div class="control-group">
                                    <label class="control-label">Продукт:</label>
                                    <label class="control-label"><strong>{{ $product->product_name }}</strong> - {{ $product->product_code }}</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Снимки</label>
                                    <div class="controls">
                                        <input type="file" name="image[]" id="image" multiple="multiple">
                                    </div>
                                </div>
                                <div style="padding-bottom:10px;"></div>
                                <div class="form-actions">
                                    <input type="submit" value="Добави избраните снимки" class="btn btn-common">
                                    <a href="{{ route('home-firm-adds', ['payed' => 'No']) }}" class="btn btn-common" style="background-color: #28A745;color:white;">Обратно в моите оферти</a>
                                </div>
                            </form>
                            <hr />
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Снимка №</th>
                                        <th>Продукт</th>
                                        <th>Снимка</th>
                                        <th>Управление</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->images as $image)
                                    <tr>
                                        <td>{{ $image->id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>
                                            @if (!empty($image->image))
                                            <a href="#imageModal{{ $image->id }}" data-toggle="modal" title="Покажи снимката в голям размер."><img src="{{ asset('/images/backend_images/products/small/'.$image->image) }}" style="width:50px;"></a> @endif
                                        </td>
                                        <td class="center">
                                            <button onclick="deleteProductImages('{{ route('admin.delete-product-images', ['id' => $image->id]) }}');" class="btn btn-danger">Изтрий</button>
                                        </td>
                                    </tr>
                                    <div id="imageModal{{ $image->id }}" class="modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $product->product_name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><img src="{{ asset('/images/backend_images/products/medium/'.$image->image) }}"></p>
                                                </div>
                                                <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection