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
$category_parent_id = Category::where(['id'=>$product->category_id])->first()->parent_id;
if ($category_parent_id !== 0){
    $category_parent = Category::where(['id'=>$category_parent_id])->first()->name;
}else{
    $category_parent = Category::where(['id'=>$product->category_id])->first()->name;
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
                                <img class="img-fluid" src="{{ asset('/images/backend_images/products/large/'.$product->image) }}" alt="">
                            </div>
                            <span class="price">{{ $product->price }}</span>
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
                            <span><a href="#"><i class="lni-alarm-clock"></i> {{ ProductController::getCreatedAtAttribute($product->created_at) }}</a></span>
                            <span><a href="#"><i class="lni-map-marker"></i>  {{ City::where(['id'=>$product->send_id])->first()->city }}</a></span>
                            <span><a href="#"><i class="lni-eye"></i> 299 View</a></span>
                        </div>
                        <p class="mb-4">{!! $product->description !!}</p>
                        <hr />
                        <h4 class="title-small mb-3">Параметри:</h4>
                        <ul class="list-specification">
                            <li><i class="lni-check-mark-circle"></i> Номер: {{ $product->id }}</li>
                            <li><i class="lni-check-mark-circle"></i> Код: {{ $product->product_code }}</li>
                            <li><i class="lni-check-mark-circle"></i> Наименование: {{ $product->product_name }}</li>
                            <li><i class="lni-check-mark-circle"></i> Категория: <i class="{{ Category::where(['id'=>$product->category_id])->first()->icon }}"></i>&nbsp;{{ $category_parent }}</li>
                            <li><i class="lni-check-mark-circle"></i> Празник: {{ HolidayController::getHolidayById($product->holiday_id)->name }}</li>
                            <li><i class="lni-check-mark-circle"></i> Цена: {{ $product->price }}</li>
                            <li><i class="lni-check-mark-circle"></i> Основен цвят: {{ $product->first_color }}</li>
                            <li><i class="lni-check-mark-circle"></i> Втори цвят: {{ $product->second_color }}</li>
                            @php
                            switch ($product->age) {
                                case 'child':
                                    $age_txt = 'За деца';
                                    break;
                                case 'adult':
                                    $age_txt = 'За възрастни';
                                    break;
                            }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Възрастова група: {{ $age_txt }}</li>
                            @php
                            switch ($product->pol) {
                                case 'woman':
                                    $pol_txt = 'За жени';
                                    break;
                                case 'man':
                                    $pol_txt = 'За мъже';
                                    break;
                            }
                            @endphp
                            <li><i class="lni-check-mark-circle"></i> Пол: {{ $pol_txt }}</li>
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
                            <li><i class="lni-check-mark-circle"></i> Състояние: {{ $condition_txt }}</li>
                            <li><i class="lni-check-mark-circle"></i> Изпраща се с: {{ SpeditorController::getSpeditorById($product->send_id)->name }}</li>
                            <li><i class="lni-check-mark-circle"></i> Изпраща се от: {{ CityController::getCityById($product->send_from_id)->city }}&nbsp;, област: {{ CityController::getCityById($product->send_from_id)->oblast }}</li>
                            <li><i class="lni-check-mark-circle"></i> Цена за изпращане: {{ $product->price_send }}</li>
                            <li><i class="lni-check-mark-circle"></i> Безплатна доставка: @if ($product->send_free === 1) Да @else Не @endif</li>
                            <li><i class="lni-check-mark-circle"></i> Важи за: {{ CityController::getCityById($product->send_free_id)->city }}&nbsp;, област: {{ CityController::getCityById($product->send_free_id)->oblast }}</li>
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
                            <li><i class="lni-check-mark-circle"></i> Може да се вземе от обект: @if ($product->object == 1) Да @else Не @endif</li>
                            <li><i class="lni-check-mark-circle"></i> Адрес на обекта: {{ $product->object_name }}</li>
                            <li><i class="lni-check-mark-circle"></i> Възможност за персонализиране: @if ($product->personalize == 1) Да @else Не @endif</li>
                        </ul>
                        <hr />
                        <p class="mb-4">
                        @foreach (ProductsTags::where(['product_id'=>$product->id])->get() as $product_tag)
                            <button type="button" class="btn btn-outline-info">{{ Tag::where(['id'=>$product_tag->tag_id])->first()->name }}</button>
                        @endforeach
                        </p>
                    </div>
                    <div class="tag-bottom">
                        <div class="float-left">
                            <ul class="advertisement">
                                <li>
                                    <p><strong><i class="lni-folder"></i> Категория:</strong> <a href="#">{{ $category_parent }}</a></p>
                                </li>
                                <li>
                                    <p><strong><i class="lni-archive"></i> Състояние:</strong> <a href="#">{{ $condition_txt }}</a></p>
                                </li>
                            </ul>
                        </div>
                        <div class="float-right">
                            <div class="share">
                                <div class="social-link">
                                    <a class="facebook" data-toggle="tooltip" data-placement="top" title="facebook" href="#"><i class="lni-facebook-filled"></i></a>
                                    <a class="twitter" data-toggle="tooltip" data-placement="top" title="twitter" href="#"><i class="lni-twitter-filled"></i></a>
                                    <a class="linkedin" data-toggle="tooltip" data-placement="top" title="linkedin" href="#"><i class="lni-linkedin-fill"></i></a>
                                    <a class="google" data-toggle="tooltip" data-placement="top" title="google plus" href="#"><i class="lni-google-plus"></i></a>
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
                        <h4 class="widget-title">Продукт на:</h4>
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
                                            <span><a href="#"><i class="lni-map-marker"></i> {{ CityController::getCityById($item->send_from_id)->city }}</a></span>
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
