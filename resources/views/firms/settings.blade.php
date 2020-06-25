<?php use App\Reklama; ?>
<?php use App\Order; ?>
<?php use App\Product; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<!-- Start Content -->
<script type="text/javascript">
    function deleteImage(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита снимката. Операцията е невъзвратима!",
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
                                    <a class="active" href="{{ route('home-firm-settings') }}">
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

                                            $order_count = Order::whereIn('product_id', $products_ids)->count();
                                        @endphp
                                        @if($order_count == 0)
                                            <span style="float:right;padding-right:10px;"><p>{{ $order_count }} бр.</p></span>
                                        @else
                                            <span style="float:right;padding-right:10px;"><p class="order_blink">{{ $order_count }} бр.</p></span>
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
                <div class="row page-content">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="inner-box">
                            @if (Session::has('flash_message_success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_success') !!}</strong>
                            </div>
                            @endif
                            <div class="tg-contactdetail">
                                <div class="dashboard-box">
                                    <h2 class="dashbord-title">Настройки за контакт</h2>
                                </div>
                                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-firm-settings') }}" name="home_settings"
                                    id="home_settings" novalidate="novalidate">
                                    @csrf
                                    <div class="dashboard-wrapper">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Потребител търговец</label>
                                            <input class="form-control input-md" disabled name="user_email" type="text" value="{{ $user->email }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label">Наименование търговец*</label>
                                            <input class="form-control input-md" name="user_name" type="text" value="{{ $user->name }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label">Телефон*</label>
                                            <input class="form-control input-md" name="user_phone" type="text" value="{{ $user->phone }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label">Адрес</label>
                                            <input class="form-control input-md" name="user_address" type="text" value="{{ $user->address }}">
                                        </div>
                                        <div class="form-group mb-3 tg-inputwithicon">
                                            <label class="control-label">Населено място</label>
                                            <div class="tg-select form-control">
                                                <select name="city_id">
                                                <option value="0" @if($user->city_id == 0) selected @endif>Избери населено място</option>
                                                @foreach ($cities as $city)
                                                    @if($city->city === $city->oblast)
                                                    <option value="{{ $city->id }}" @if($user->city_id == $city->id) selected @endif>{{ $city->city }}</option>
                                                    @endif
                                                    @if($city->city !== $city->oblast)
                                                    <option value="{{ $city->id }}" @if($user->city_id == $city->id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label">Представяне (можете да въведете кратък текст с който да представите Вашата дейност пред потенциалните си купувачи.)</label>
                                            <textarea class="form-control input-md" name="user_info">{{ $user->info }}</textarea>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Снимка</label>
                                            <div class="controls">
                                                <input type="file" name="image" id="image">
                                                <input type="hidden" name="current_image" id="current_image" value="{{ $user->image }}">
                                                @if (!empty($user->image))
                                                    <img style="width:50px;" src="{{ asset('/images/backend_images/users/'.$user->image) }}"> | <a style="cursor:pointer;color:white;" onclick="deleteImage('{{ route('delete-user-image', ['id' => $user->id]) }}');" class="btn btn-danger">Изтрий снимката</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="padding-bottom:10px;"></div>
                                        <hr />
                                        <div class="tg-checkbox">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="tg-agreetermsandrules" name="user_agrrement">
                                                <label class="custom-control-label" for="tg-agreetermsandrules">Съгласен съм с <a href="javascript:void(0);">Общите условия</a></label>
                                            </div>
                                        </div>
                                        <button class="btn btn-common" type="submit">Запиши промените</button>
                                    </div>
                                </form>
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
