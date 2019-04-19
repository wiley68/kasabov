<?php use App\Category; ?>
<?php use App\Holiday; ?>
<?php use App\User; ?>
<?php use App\City; ?>
<?php use App\Product; ?>
@extends('layouts.frontLayout.front_design_index')
@section('content')

<!-- Categories item Start -->
<section id="categories" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">КАТЕГОРИИ</h1>
                    <h4 class="sub-title"><a href="{{ route('products') }}">ПОКАЖИ ВСИЧКИ ОФЕРТИ</a></h4>
                </div>
            </div>
            @php
                $bg_count = 1;
            @endphp
            @foreach ($categories_top as $category_top)
            @php
            $categories_parent = Category::where(['parent_id'=>$category_top->id])->get();
            $categories_in[] = $category_top->id;
            foreach ($categories_parent as $category_parent) {
                $categories_in[] = $category_parent->id;
            }
            $products_count = Product::whereIn('category_id', $categories_in)->count();
            @endphp
            <div class="col-lg-2 col-md-3 col-xs-12">
                @php
                    $category_ids = [];
                    $category_ids[] = $category_top->id;
                @endphp
                <a href="{{ route('products', ['category_id'=>$category_ids]) }}">
                    <div class="category-icon-item lis-bg{{ $bg_count }}" style="height:150px;">
                        <div class="icon-box">
                            <div class="icon">
                                <i class="{{ $category_top->icon }}"></i>
                            </div>
                            <h4>{{ $category_top->name }}</h4>
                            <p class="categories-listing">{{ $products_count }} продукта</p>
                        </div>
                    </div>
                </a>
            </div>
            @php
                $bg_count++;
                $categories_in = null;
            @endphp
            @endforeach
        </div>
    </div>
</section>
<!-- Categories item End -->

<!-- Featured Section Start -->
<section class="featured section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">НАЙ-ХАРЕСВАНИ ОФЕРТИ</h1>
                </div>
            </div>
            @foreach ($featured_products as $featured_product)
            @php
                if(!empty($featured_product->image)){
                    $featured_image = asset('/images/backend_images/products/medium/'.$featured_product->image);
                }else{
                    $featured_image = asset('/images/backend_images/products/medium/no-image-600.png');
                }
            @endphp
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="featured-box">
                    <figure>
                        <div class="homes-tag featured">{{ Holiday::where(['id'=>$featured_product->holiday_id])->first()->name }}</div>
                        <div class="homes-tag rent"><i class="lni-heart"></i> {{ $featured_product->likes }}</div>
                        <span class="price-save">{{ number_format($featured_product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</span>
                        <a href="{{ route('product', ['id'=>$featured_product->product_code]) }}"><img class="img-fluid" src="{{ $featured_image }}" alt=""></a>
                    </figure>
                    <div class="content-wrapper">
                        <div class="feature-content">
                            <h4><a href="{{ route('product', ['id'=>$featured_product->product_code]) }}">{{ $featured_product->product_name }}</a></h4>
                            <p class="listing-tagline">{{ $featured_product->product_code }}</p>
                            <div class="meta-tag">
                                <div class="user-name">
                                    <a href="{{ route('products', ['user_id'=>$featured_product->user_id]) }}"><i class="lni-user"></i> {{ User::where(['id'=>$featured_product->user_id])->first()->name }}</a>
                                </div>
                                <div class="listing-category">
                                    @php
                                        $category_ids = [];
                                        $category_ids[] = $featured_product->category_id;
                                    @endphp
                                    <a href="{{ route('products', ['category_id'=>$category_ids]) }}"><i class="{{ Category::where(['id'=>$featured_product->category_id])->first()->icon }}"></i>{{ Category::where(['id'=>$featured_product->category_id])->first()->name }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="listing-bottom clearfix">
                            <i class="lni-map-marker"></i> {{ City::where(['id'=>$featured_product->send_id])->first()->city }}
                            <a href="{{ route('product', ['id'=>$featured_product->product_code]) }}" class="float-right">Прегледай Детайлно</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Featured Listings Start -->
<section class="featured-lis section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">ТОП ОФЕРТИ</h1>
                </div>
            </div>
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                <div id="new-products" class="owl-carousel owl-theme">
                    @foreach ($tops as $top)
                    @php
                    if(!empty($top->image)){
                        $top_image = asset('/images/backend_images/products/medium/'.$featured_product->image);
                    }else{
                        $top_image = asset('/images/backend_images/products/medium/no-image-600.png');
                    }
                    @endphp
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="{{ $top_image }}" alt="">
                                <div class="overlay">
                                    <div>
                                        <a class="btn btn-common" href="{{ route('product', ['id'=>$top->product_code]) }}">Виж детайлно</a>
                                    </div>
                                </div>
                                <div class="btn-product bg-sale">
                                    <a>Топ</a>
                                </div>
                                <span class="price">{{ number_format($top->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</span>
                            </div>
                            <div class="product-content-inner">
                                <div class="product-content">
                                    <h3 class="product-title"><a href="{{ route('product', ['id'=>$top->product_code]) }}">{{ $top->product_name }}</a></h3>
                                    <span>{{ Category::where(['id'=>$top->category_id])->first()->name }} / {{ Category::where(['id'=>$top->category_id])->first()->name }}</span>
                                    <div class="icon">
                                        <i class="lni-heart" title="Харесайте този продукт"></i> {{ $top->likes }}
                                    </div>
                                </div>
                                <div class="card-text clearfix">
                                    <div class="float-right">
                                        <i class="lni-map-marker"></i> {{ City::where(['id'=>$top->send_id])->first()->city }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Featured Listings End -->

<!-- Works Section Start -->
<section class="works section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">КАК РАБОТИ <a href="{{ route('index') }}">PARTYBOX.BG</a></h1>
                    <h4 class="sub-title">Достъп до хиляди парти оферти всеки ден</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="far fa-user"></i>
                    </div>
                    <p>НАПРАВИ РЕГИСТРАЦИЯ В САЙТА</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="fas fa-search"></i>
                    </div>
                    <p>НАМЕРИ НАЙ-ДОБРИТЕ ПАРТИ ОФЕРТИ ЗА ТЕБ</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <p>ПОРЪЧАЙ ЛЕСНО И БЪРЗО</p>
                </div>
            </div>
            <hr class="works-line">
        </div>
    </div>
</section>
<!-- Works Section End -->

@endsection
