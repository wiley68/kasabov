<?php

use App\Order; ?>
<?php

use App\Product; ?>
<?php

use App\User; ?>
<?php

use App\Reklama; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<!-- Start Content -->
<script type="text/javascript">
    function deleteProduct(url) {
        swal({
                title: "Сигурни ли сте?",
                text: "Ще бъде изтрит продукта. Операцията е невъзвратима!",
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
                                    <a href="{{ route('home-firm') }}">
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
                                    <a class="active" href="{{ route('home-firm-orders') }}">
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
                        <h4 class="widget-title">Реклама</h4>
                        @php
                        $random_count = Reklama::where(['status'=>1])->count();
                        if ($random_count > 3){
                        $random_count = 3;
                        }
                        $reklami = Reklama::where(['status'=>1])->get()->random($random_count);
                        @endphp
                        @foreach ($reklami as $reklama)
                        <div class="add-box">
                            <h5>{{ $reklama->title }}</h5>
                            <p>{{ $reklama->description }}</p>
                            @php
                            if(!empty($reklama->image_small)){
                            $image_small = asset('/images/backend_images/reklama_small/'.$reklama->image_small);
                            }else{
                            $image_small = "";
                            }
                            @endphp
                            @if ($image_small != "")
                            @if ($reklama->url != "") <a target="_blank" href="{{ $reklama->url }}"> @endif <img class="img-fluid" src="{{ $image_small }}" alt="{{ $reklama->title }}"> @if ($reklama->url != "") </a> @endif
                            @endif
                        </div>
                        @endforeach
                    </div>
                </aside>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="page-content">
                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Поръчки</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <table class="table table-responsive dashboardtable tablemyads">
                                <thead>
                                    <tr>
                                        <th>Снимка</th>
                                        <th>Продукт</th>
                                        <th>Клиент</th>
                                        <th>Цена</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order) @php $product = Product::where(['id'=>$order->product_id])->first(); if(!empty($product->image)){
                                    $image = asset('/images/backend_images/products/small/'.$product->image); }else{ $image
                                    = asset('/images/backend_images/products/small/no-image-300.png'); }
                                    @endphp
                                    <tr>
                                        <td class="photo"><a href="#imageModal{{ $product->id }}" data-toggle="modal" title="Покажи снимката в голям размер."><img class="img-fluid" src="{{ $image }}" alt=""></a></td>
                                        <td data-title="Продукт">
                                            <h3>{{ $product->product_name }}</h3>
                                            <span>КОД: {{ $product->product_code }}</span>
                                        </td>
                                        <td data-title="Клиент"><span class="adcategories">{{ User::where(['id'=>$order->user_id])->first()->name }}</span></td>
                                        <td data-title="Цена">
                                            <h3>{{ number_format($product->price, 2, '.', '') }}{{ Config::get('settings.currency')
                                                }}</h3>
                                        </td>
                                        <td>
                                            <div class="btns-actions">
                                                <a class="btn-action btn-view" href="{{ route('product', ['id'=>$product->product_code]) }}" target="_blanc" title="Покажи продукта"><i class="lni-eye"></i></a>
                                                <a style="cursor:pointer;" class="btn-action btn-delete" onclick="deleteProduct('{{ route('delete-firm-order', ['id' => $order->id]) }}');" title="Изтрий тази поръчка"><i class="lni-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <p><strong>Дата на създаване</strong>: {{ date("d.m.Y H:i:s", strtotime($order->created_at)) }}</p>
                                            <p><strong>Съобщение</strong>: {{ $order->message }}</p>
                                            <p><strong>Email</strong>: {{ $order->email }}</p>
                                            <p><strong>Телефон</strong>: {{ $order->phone }}</p>
                                            @php
                                                if($order->status == "unread"){
                                                    $status = "Непрочетен";
                                                }else{
                                                    $status = "Прочетен";
                                                }
                                            @endphp
                                            <p style="margin: 0; display: inline;"><strong>Статус</strong>: {{$status}}</p>
                                            @if ($status == "Непрочетен")
                                                <p style="margin: 15px; display: inline;"><a href="{{ route('home-firm-orders-status', ['id'=>$order->id]) }}" class="btn btn-common">Отбележи като Прочетен</a></p>                                                 
                                            @else
                                                <p style="margin: 15px; display: inline;"><a href="{{ route('home-firm-orders-status', ['id'=>$order->id]) }}" class="btn btn-common">Отбележи като Непрочетен</a></p>
                                            @endif
                                        </td>
                                    </tr>
                                    <div id="imageModal{{ $product->id }}" class="modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $product->product_name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><img src="{{ asset('/images/backend_images/products/medium/'.$product->image) }}"></p>
                                                </div>
                                                <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Затвори</button></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr />
                            <!-- Start Pagination -->
                            {{ $orders->links() }}
                            <!-- End Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection