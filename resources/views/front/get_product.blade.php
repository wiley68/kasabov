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
                            <span class="price">{{ $product->price }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="details-box">
                    <div class="ads-details-info">
                        <h2>{{ $product->product_name }}</h2>
                        <div class="details-meta">
                            <span title="Добавен на"><i class="lni-alarm-clock"></i> {{ ProductController::getCreatedAtAttribute($product->created_at) }}</span>
                            <span title="Изпраща се от, населено място"><i class="lni-map-marker"></i>  {{ City::where(['id'=>$product->send_id])->first()->city }} - {{ City::where(['id'=>$product->send_id])->first()->oblast }}</span>
                            <span title="Брой прегледа на обявата"><i class="lni-eye"></i> {{ $product->views }}</span>
                        </div>
                        <p class="mb-4">{!! $product->description !!}</p>
                        <hr />
                        <h4 class="title-small mb-3">Параметри:</h4>
                        <ul class="list-specification">
                            <li><i class="lni-check-mark-circle"></i> Номер: {{ $product->id }}</li>
                            <li><i class="lni-check-mark-circle"></i> Код: {{ $product->product_code }}</li>
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
                            <li><i class="lni-check-mark-circle"></i> Важи за: {{ CityController::getCityById($product->send_free_id) }}&nbsp;, област: {{ CityController::getOblastById($product->send_free_id) }}</li>
                            @php
                            switch ($product->available_for) {
                                case 'city':
                                    $available_for_txt = 'Населено място';
                                    break;
                                case 'cities':
                                    $available_for_txt = 'Населени места';
                                    break;
                                case 'area':
                                    $available_for_txt = 'Област';
                                    break;
                                case 'country':
                                    $available_for_txt = 'Цялата страна';
                                    break;
                            }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Доставя за: {{ $available_for_txt }}</li>
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
                        <h4 class="widget-title">Продукт на: {{ User::where(['id'=>$product->user_id])->first()->name }}</h4>
                        <div class="agent-inner">
                            <div class="mb-4">
                                <object style="border:0; height: 230px; width: 100%;" data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d34015.943594576835!2d-106.43242624069771!3d31.677719472407432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86e75d90e99d597b%3A0x6cd3eb9a9fcd23f1!2sCourtyard+by+Marriott+Ciudad+Juarez!5e0!3m2!1sen!2sbd!4v1533791187584"></object>
                            </div>
                            <div class="agent-title">
                                <div class="agent-photo">
                                    <a href="#"><img src="{{ asset('images/frontend_images/productinfo/agent.jpg') }}" alt=""></a>
                                </div>
                                <div class="agent-details">
                                    <h3><a href="#">{{ User::where(['id'=>$product->user_id])->first()->name }}</a></h3>
                                    <span><i class="lni-phone-handset"></i>(123) 123-456</span>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Вашият Email">
                            <input type="text" class="form-control" placeholder="Вашият телефон">
                            <p>Интересувам се от Вашия продукт с код [{{ $product->product_code }}] и бих искал да получа повече детайли.</p>
                            <button class="btn btn-common fullwidth mt-4">Изпрати съобщението</button>
                        </div>
                    </div>
                    <!-- Popular Posts widget -->
                    <div class="widget">
                        <h4 class="widget-title">Продукти от продавача</h4>
                        <ul class="posts-list">
                            @foreach (ProductController::frontGetProductByUser($product->user_id) as $item)
                                <li>
                                    <div class="widget-thumb">
                                        <a href="#"><img src="{{ asset('/images/backend_images/products/small/'.$item->image) }}" alt="" /></a>
                                    </div>
                                    <div class="widget-content">
                                        <h4><a href="#">{{ $item->product_name }}</a></h4>
                                        <div class="meta-tag">
                                            <span><a href="#"><i class="lni-map-marker"></i> {{ CityController::getCityById($item->send_from_id) }}</a></span>
                                        </div>
                                        <h4 class="price">{{ $item->price }}</h4>
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
