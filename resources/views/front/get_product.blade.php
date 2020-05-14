<?php use App\ProductsImage; ?>
<?php use App\City; ?>
<?php use App\User; ?>
<?php use App\Category; ?>
<?php use App\Http\Controllers\ProductController; ?>
<?php use App\Http\Controllers\HolidayController; ?>
<?php use App\Http\Controllers\SpeditorController; ?>
<?php use App\Http\Controllers\CityController; ?>
<?php use App\ProductsTags; ?>
<?php use App\Tag; ?>
<?php use App\ProductsCitySend; ?>
<?php use App\ProductsCity; ?>

@extends('layouts.frontLayout.front_design')
@section('content')
@php
if(!empty($product->image)){
    $image = asset('/images/backend_images/products/large/'.$product->image);
}else{
    $image = asset('/images/backend_images/products/large/no-image-1200.png');
}
@endphp
<!-- Ads Details Start -->
<div class="section-padding">
    <div class="container">
        <!-- Product Info Start -->
        <div class="product-info row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div class="ads-details-wrapper">
                    <div id="owl-demo" class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="product-img">
                                <img class="img-fluid" src="{{ $image }}" alt="">
                            </div>
                            <span class="price">{{ number_format($product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</span>
                        </div>
                        @foreach (ProductsImage::where(['product_id'=>$product->id])->get() as $item)
                        <div class="item">
                            <div class="product-img">
                                <img class="img-fluid" src="{{ asset('/images/backend_images/products/large/'.$item->image) }}" alt="">
                            </div>
                            <span class="price">{{ number_format($product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="details-box">
                    <div class="ads-details-info">
                        <h2>{{ $product->product_name }}</h2>
                        <div class="details-meta">
                            <span title="Добавен на"><i class="lni-alarm-clock"></i> {{ ProductController::getCreatedAtAttribute($product->created_at) }}</span>
                            @php
                                if(!empty(City::where(['id'=>$product->send_from_id])->first())){
                                    $city_name = City::where(['id'=>$product->send_from_id])->first()->city;
                                    $city_oblast = City::where(['id'=>$product->send_from_id])->first()->oblast;
                                }else{
                                    $city_name = '';
                                    $city_oblast = '';
                                }
                            @endphp
                            <span title="Изпраща се от, населено място"><i class="lni-map-marker"></i>  {{ $city_name }} - {{ $city_oblast }}</span>
                            <span title="Брой прегледа на обявата"><i class="lni-eye"></i> {{ $product->views }}</span>
                            @auth
                            <div class="float-right">
                                <button id="btn_add_favorites" class="btn btn-common fullwidth mt-4">Добави към любими</button>
                            </div>
                            @endauth
                        </div>
                        <p class="mb-4">{!! nl2br(e($product->description)) !!}</p>
                        <hr />
                        <h4 class="title-small mb-3">Параметри:</h4>
                        <ul class="list-specification">
                            <li><i class="lni-check-mark-circle"></i> Наименование: {{ $product->product_name }}</li>
                            @php
                                $category_ids = [];
                                $category_ids[] = $product->category_id;
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Категория: <i class="{{ Category::where(['id'=>$product->category_id])->first()->icon }}"></i>&nbsp;<a href="{{ route('products', ['category_id'=>$category_ids]) }}" title="Покажи всички обяви от тази категория">{{ Category::where(['id'=>$product->category_id])->first()->name }}</a></li>
                            @php
                                $holiday_ids = [];
                                $holiday_ids[] = $product->holiday_id;
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Празник: <a href="{{ route('products', ['holiday_id'=>$holiday_ids]) }}" title="Покажи всички обяви от този празник"> {{ HolidayController::getHolidayById($product->holiday_id) }}</a></li>
                            <li><i class="lni-check-mark-circle"></i> Цена: {{ number_format($product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</li>
                            @php
                                switch ($product->first_color) {
                                    case 'white':
                                        $first_color = 'Бял';
                                        break;
                                    case 'gray':
                                        $first_color = 'Сив';
                                        break;
                                    case 'black':
                                        $first_color = 'Черен';
                                        break;
                                    case 'red':
                                        $first_color = 'Червен';
                                        break;
                                    case 'yellow':
                                        $first_color = 'Жълт';
                                        break;
                                    case 'green':
                                        $first_color = 'Зелен';
                                        break;
                                    case 'blue':
                                        $first_color = 'Син';
                                        break;
                                    case 'brown':
                                        $first_color = 'Кафяв';
                                        break;
                                    case 'white':
                                        $first_color = 'Бял';
                                        break;
                                    case 'pink':
                                        $first_color = 'Розов';
                                        break;
                                    case 'orange':
                                        $first_color = 'Оранжев';
                                        break;
                                    case 'purple':
                                        $first_color = 'Лилав';
                                        break;
                                    case 'many':
                                        $first_color = 'Многоцветен';
                                        break;
                                    default:
                                        $first_color = 'Многоцветен';
                                }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Основен цвят: <i class="fas fa-square" style="color:{{ $product->first_color }};"></i><a href="{{ route('products', ['first_color'=>$product->first_color]) }}" title="Покажи всички обяви в този основен цвят"> {{ $first_color }}</a></li>
                            @php
                                switch ($product->second_color) {
                                    case 'white':
                                        $second_color = 'Бял';
                                        break;
                                    case 'gray':
                                        $second_color = 'Сив';
                                        break;
                                    case 'black':
                                        $second_color = 'Черен';
                                        break;
                                    case 'red':
                                        $second_color = 'Червен';
                                        break;
                                    case 'yellow':
                                        $second_color = 'Жълт';
                                        break;
                                    case 'green':
                                        $second_color = 'Зелен';
                                        break;
                                    case 'blue':
                                        $second_color = 'Син';
                                        break;
                                    case 'brown':
                                        $second_color = 'Кафяв';
                                        break;
                                    case 'white':
                                        $second_color = 'Бял';
                                        break;
                                    case 'pink':
                                        $second_color = 'Розов';
                                        break;
                                    case 'orange':
                                        $second_color = 'Оранжев';
                                        break;
                                    case 'purple':
                                        $second_color = 'Лилав';
                                        break;
                                    case 'many':
                                        $second_color = 'Многоцветен';
                                        break;
                                    default:
                                        $second_color = 'Многоцветен';
                                }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Втори цвят: <i class="fas fa-square" style="color:{{ $product->second_color }};"></i><a href="{{ route('products', ['second_color'=>$product->second_color]) }}" title="Покажи всички обяви в този втори цвят"> {{ $second_color }}</a></li>
                            @php
                            switch ($product->age) {
                                case 'child':
                                    $age_txt = 'За деца';
                                    break;
                                case 'adult':
                                    $age_txt = 'За възрастни';
                                    break;
                                case 'any':
                                    $age_txt = 'Без значение';
                                    break;
                            }
                            $holiday_ids = [];
                            $holiday_ids[] = $product->holiday_id;
                            @endphp
                        <li><i class="lni-check-mark-circle"></i> Възрастова група: <a href="{{ route('products', ['age'=>$product->age]) }}" title="Покажи всички обяви в тази възрастова група">{{ $age_txt }}</a></li>
                            @php
                            switch ($product->pol) {
                                case 'woman':
                                    $pol_txt = 'За жени';
                                    break;
                                case 'man':
                                    $pol_txt = 'За мъже';
                                    break;
                                case 'any':
                                    $pol_txt = 'Без значение';
                                    break;
                            }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Пол: <a href="{{ route('products', ['pol'=>$product->pol]) }}" title="Покажи всички обяви за този пол">{{ $pol_txt }}</a></li>
                            @php
                            switch ($product->condition) {
                                case 'old':
                                    $condition_txt = 'Употребяван';
                                    break;
                                case 'new':
                                    $condition_txt = 'Нов';
                                    break;
                            }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Състояние: <a href="{{ route('products', ['condition'=>$product->condition]) }}" title="Покажи всички обяви с това състояние">{{ $condition_txt }}</a></li>
                            <li><i class="lni-check-mark-circle"></i> Изпраща се с: <a href="{{ route('products', ['send_id'=>$product->send_id]) }}" title="Покажи всички обяви които се изпращат с този иапращач">{{ SpeditorController::getSpeditorById($product->send_id) }}</a></li>
                            <li><i class="lni-check-mark-circle"></i> Изпраща се от: {{ CityController::getCityById($product->send_from_id) }}&nbsp;, област: {{ CityController::getOblastById($product->send_from_id) }}</li>
                            <li><i class="lni-check-mark-circle"></i> Цена за изпращане: {{ number_format($product->price_send, 2, '.', '') }}{{ Config::get('settings.currency') }}</li>
                            <li><i class="lni-check-mark-circle"></i> Безплатна доставка: @if ($product->send_free === 1) <a href="{{ route('products', ['send_free'=>1]) }}" title="Покажи всички обяви с безплатна доставка">Да</a> @else <a href="{{ route('products', ['send_free'=>0]) }}" title="Покажи всички обяви без безплатна доставка">Не</a> @endif</li>
                            @php
                                switch ($product->send_free_available_for) {
                                    case 'country':
                                        $vaziza = "Цялата страна";
                                        $vazicity = "";
                                        break;
                                    case 'area':
                                        $vaziza = "Област: ";
                                        $vazicity = CityController::getOblastById($product->send_free_id);
                                        break;
                                    case 'cities':
                                        $vaziza = "Населени места: ";
                                        $vazicity = "";
                                        foreach (ProductsCitySend::where(['product_id' => $product->id])->get() as $city_send) {
                                            $vazicity .= CityController::getCityById($city_send->city_id) . " - " . CityController::getOblastById($city_send->city_id) . ", ";
                                        }
                                        break;
                                    case 'city':
                                        $vaziza = "Населено място: ";
                                        $vazicity = CityController::getCityById($product->send_free_id) . " - " . CityController::getOblastById($product->send_free_id);
                                        break;                    
                                    default:
                                        $vaziza = "Цялата страна";
                                        $vazicity = "";
                                        break;
                                }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Важи за: {{ $vaziza }}{{ $vazicity }}</li>
                            @php
                                switch ($product->available_for) {
                                    case 'country':
                                        $available_for_txt = "Цялата страна";
                                        $availablecity = "";
                                        break;
                                    case 'area':
                                        $available_for_txt = "Област: ";
                                        $availablecity = CityController::getOblastById($product->available_for_city);
                                        break;
                                    case 'cities':
                                        $available_for_txt = "Населени места: ";
                                        $availablecity = "";
                                        foreach (ProductsCity::where(['product_id' => $product->id])->get() as $city_send) {
                                            $availablecity .= CityController::getCityById($city_send->city_id) . " - " . CityController::getOblastById($city_send->city_id) . ", ";
                                        }
                                        break;
                                    case 'city':
                                        $available_for_txt = "Населено място: ";
                                        $availablecity = CityController::getCityById($product->available_for_city) . " - " . CityController::getOblastById($product->available_for_city);
                                        break;                    
                                    default:
                                        $available_for_txt = "Цялата страна";
                                        $availablecity = "";
                                        break;
                                }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Доставя за: {{ $available_for_txt }}{{ $availablecity }}</li>
                            <li><i class="lni-check-mark-circle"></i> Може да се вземе от обект: @if ($product->object == 1) <a href="{{ route('products', ['object'=>1]) }}" title="Покажи всички обяви които могат да се вземат от обект">Да</a> @else <a href="{{ route('products', ['object'=>0]) }}" title="Покажи всички обяви които не могат да се вземат от обект">Не</a> @endif</li>
                            <li><i class="lni-check-mark-circle"></i> Адрес на обекта: {{ $product->object_name }}</li>
                            <li><i class="lni-check-mark-circle"></i> Възможност за персонализиране: @if ($product->personalize == 1) <a href="{{ route('products', ['personalize'=>1]) }}" title="Покажи всички обяви които могат да се персонализират">Да</a> @else <a href="{{ route('products', ['personalize'=>0]) }}" title="Покажи всички обяви които не могат да се персонализират">Не</a> @endif</li>
                        </ul>
                        <hr />
                        <p class="mb-4">
                        @foreach (ProductsTags::where(['product_id'=>$product->id])->get() as $product_tag)
                            <a href="{{ route('products', ['tag'=>$product_tag->tag_id]) }}" type="button" class="btn btn-outline-info">{{ Tag::where(['id'=>$product_tag->tag_id])->first()->name }}</a>
                        @endforeach
                        </p>
                    </div>
                    <div class="tag-bottom">
                        <div class="float-left">
                            <ul class="advertisement">
                                <li>
                                    <p><strong><i class="lni-folder"></i> Категория:</strong> <a href="{{ route('products', ['category_id'=>$category_ids]) }}" title="Покажи всички обяви от тази категория">{{ Category::where(['id'=>$product->category_id])->first()->name }}</a></p>
                                </li>
                                <li>
                                    <p><strong><i class="lni-archive"></i> Състояние:</strong> <a href="{{ route('products', ['condition'=>$product->condition]) }}" title="Покажи всички обяви с това състояние">{{ $condition_txt }}</a></p>
                                </li>
                            </ul>
                        </div>
                        <div class="float-right">
                            <div class="share">
                                <div class="social-link">
                                    <a class="facebook" data-toggle="tooltip" data-placement="top" title="facebook" href="{{ User::where(['id'=>$product->user_id])->first()->facebook }}"><i class="lni-facebook-filled"></i></a>
                                    <a class="twitter" data-toggle="tooltip" data-placement="top" title="twitter" href="{{ User::where(['id'=>$product->user_id])->first()->twitter }}"><i class="lni-twitter-filled"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <!--Sidebar-->
                <aside class="details-sidebar">
                    <div class="widget">
                        <h4 class="widget-title">Продукт на: <a href="{{ route('products', ['user_id'=>$product->user_id]) }}" title="Покажи всички продукти на този търговец.">{{ User::where(['id'=>$product->user_id])->first()->name }}</a></h4>
                        <div class="agent-inner">
                            <div class="mb-4">
                                <p>{{ User::where(['id'=>$product->user_id])->first()->info }}</p>
                            </div>
                            <hr />
                            <div class="mb-4">
                                <div class="mapouter">
                                    <div class="gmap_canvas">
                                        @php
                                            $citi_name = '';
                                            if(User::where(['id'=>$product->user_id])->first()->city_id != 0){
                                                $citi_name = City::where(['id'=>User::where(['id'=>$product->user_id])->first()->city_id])->first()->city;
                                            }
                                            $city_address = User::where(['id'=>$product->user_id])->first()->address;
                                        @endphp
                                        <strong>Адрес</strong>: {{ $citi_name }} {{ $city_address }}
                                        <iframe id="gmap_canvas" src="https://maps.google.com/maps?q={{ $citi_name }}%20{{ $city_address }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:center;">
                                <p style="font-size:16px;color:black;font-weight:bold;">ПРОДУКТ НА</p>
                                <p style="font-size:30px;font-weight:bold;"><a href="{{ route('products', ['user_id'=>$product->user_id]) }}" title="Покажи всички продукти на този търговец.">{{ User::where(['id'=>$product->user_id])->first()->name }}</a></p>
                                <span><i class="lni-phone-handset"></i>&nbsp;{{ User::where(['id'=>$product->user_id])->first()->phone }}</span>
                            </div>
                            <div style="text-align:center;padding-top:20px;padding-bottom:20px;">
                                <p style="font-size:16px;color:black;">
                                Имаш въпроси относно този продукт или искаш да го поръчаш?
                                </p>
                                <p style="font-size:16px;color:black;">
                                Изпрати ни съобщение тук:
                                </p>
                                </div>
                            @guest
                            <p>Моля направете си регистрация или влезте с профила си в сайта, ако желаете да направите заявка за този продукт към търговеца!</p>
                            <a href="{{ route('users-login-register') }}" class="btn btn-common fullwidth mt-4">Вход | Регистрация</a>
                            @else
                            @if (Session::has('flash_message_success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{!! session('flash_message_success') !!}</strong>
                                </div>
                            @endif
                            <form enctype="multipart/form-data" action="{{ route('add-order') }}" method="post" name="order_products" id="order_products" novalidate="novalidate">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="text" name="user_phone" class="form-control" value="{{ User::where(['id'=>Auth::user()->id])->first()->phone }}">
                                <input type="text" name="user_email" class="form-control" value="{{ User::where(['id'=>Auth::user()->id])->first()->email }}">
                                <textarea name="message" class="form-controll" style="width:100%;" rows="6" placeholder="Съдържание на съобщението"></textarea>
                                <button class="btn btn-common fullwidth mt-4" type="submit">Изпрати съобщението</button>
                            </form>
                            @endguest
                        </div>
                    </div>
                    <!-- Popular Posts widget -->
                    <div class="widget">
                        <a href="{{ route('products', ['user_id'=>$product->user_id]) }}" title="Покажи всички продукти на този търговец.">
                            <div style="text-align:center;font-size:16px;color:black;padding-top:10px;">
                            всички продукти на
                            </div>
                            <div style="text-align:center;font-size:30px;font-weight:bold;border-bottom:1px solid whitesmoke;margin-bootom:10px;">
                                {{ User::where(['id'=>$product->user_id])->first()->name }}
                            </div>
                        </a>
                        <ul class="posts-list">
                            @foreach (ProductController::frontGetProductByUser($product->user_id) as $item)
                                @php
                                if(!empty($item->image)){
                                    $image = asset('/images/backend_images/products/small/'.$item->image);
                                }else{
                                    $image = asset('/images/backend_images/products/small/no-image-300.png');
                                }
                                @endphp
                                <li>
                                    <div class="widget-thumb">
                                        <a href="{{ route('product', ['id'=>$item->product_code]) }}"><img src="{{ $image }}" alt="" /></a>
                                    </div>
                                    <div class="widget-content">
                                        <h4><a href="{{ route('product', ['id'=>$item->product_code]) }}">{{ $item->product_name }}</a></h4>
                                        <div class="meta-tag">
                                            <span><i class="lni-map-marker"></i> {{ CityController::getCityById($item->send_from_id) }}</span>
                                        </div>
                                        <h4 class="price">{{ number_format($item->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</h4>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </aside>
                <!--End sidebar-->
            </div>
        </div>
        <!-- Product Info End -->

    </div>
</div>
<!-- Ads Details End -->
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btn_add_favorites").click(function(e){
            e.preventDefault();
            var product_id = '{{ $product->id }}';
            $.ajax({
                type:'POST',
                url:'/add-favorite',
                data:{product_id : product_id},
                success:function(data){
                    if(data.add_favorite == 'yes'){
                        alert('Успешно добавихте продукта към любими.');
                    }
                }
            });
        });
    </script>
@endsection
