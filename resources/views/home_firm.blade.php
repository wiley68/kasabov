<?php use App\Favorite; ?>
<?php use App\Order; ?>
<?php use App\Product; ?>
<?php use App\Reklama; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<script type="text/javascript">
    function deleteProduct(url){
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
                        @if (Session::has('flash_message_success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_success') !!}</strong>
                        </div>
                        @endif
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Панел управление</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <div class="dashboard-sections">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-write"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-firm-adds', ['payed' => 'No']) }}">Общо оферти</a></h2>
                                                <h3>{{ Product::where(['user_id'=>Auth::user()->id])->count() }} бр.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-add-files"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-firm-adds', ['payed' => 'Yes']) }}">Промоции</a></h2>
                                                <h3>{{ Product::where(['user_id'=>Auth::user()->id, 'featured'=>1])->count()
                                                    }} бр.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-support"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-firm-orders') }}">Поръчки</a></h2>
                                                @php
                                                $products_ids = [];
                                                $products_loc = Product::where(['user_id'=>Auth::user()->id])->get();
                                                foreach ($products_loc as $product){
                                                    $products_ids[] = $product->id;
                                                }
                                                @endphp
                                                <h3>{{ Order::whereIn('product_id', $products_ids)->count() }} бр.</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-sections">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <p>Общо достъпни за публикуване Оферти от Безплатни и Платени пакети: <strong style="color:brown;">{{ $active_payments }} бр.</strong></p>
                                        <p>От тях използвани до момента Оферти: <strong style="color:brown;">{{ $active_products }} бр.</strong></p>
                                        <p>Оставащи свободни за използване Оферти: <strong style="color:brown;">{{ $products_ostatak }} бр.</strong></p>
                                        <hr />
                                        <p>Общо достъпни за активиране Промоции от Платени пакети: <strong style="color:brown;">{{ $active_reklama }} бр.</strong></p>
                                        <p>От тях използвани до момента Промоции: <strong style="color:brown;">{{ $featured_products }} бр.</strong></p>
                                        <p>Оставащи свободни за използване Промоции: <strong style="color:brown;">{{ $featured_ostatak }} бр.</strong></p>
                                        <hr />
                                        <p>Направени плащания, активни в момента: <strong style="color:brown;">{{ $active_payments_all }} бр.</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
