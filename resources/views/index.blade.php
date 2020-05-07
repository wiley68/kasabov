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
            @foreach ($categories_top as $category_top)
            @php
            $categories_parent = Category::where(['parent_id'=>$category_top->id])->get();
            $categories_in[] = $category_top->id;
            foreach ($categories_parent as $category_parent) {
                $categories_in[] = $category_parent->id;
            }
            $products = Product::whereIn('category_id', $categories_in);
            $products = $products->where(['status'=>'active']);
            $products = $products->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")));
            $category_ids = [];
            $category_ids[] = $category_top->id;
            @endphp
            <div class="col-lg-3 col-md-6 col-xs-12">
                <div class="category-box border-1 wow fadeInUpQuick" data-wow-delay="0.3s">
                    <div class="icon">
                        <a href="{{ route('products', ['category_id'=>$category_ids]) }}"><i class="{{ $category_top->icon }}"></i></a>
                    </div>
                    <div class="category-header" style="height:80px;">  
                        <a href="{{ route('products', ['category_id'=>$category_ids]) }}"><h4>{{ $category_top->name }}&nbsp;({{ $products->count() }})</h4></a>
                    </div>
                    <div class="category-content">
                    <ul>
                        @php
                            $count_cat = 0;
                        @endphp
                        @foreach ($categories_parent as $cat_parent)
                        @php
                            $productsin = Product::where(['category_id' => $cat_parent->id]);
                            $productsin = $productsin->where(['status'=>'active']);
                            $productsin = $productsin->where('active_at', '>=', date("Y-m-d", strtotime("-1 months")));
                            $category_idsin = [];
                            $category_idsin[] = $cat_parent->id;
                        @endphp
                        @if ($count_cat < 6)
                        <li>
                            <span class="category-counter">{{ $productsin->count() }}</span>
                        </li>
                        <li>
                            <a href="{{ route('products', ['category_id'=>$category_idsin]) }}">{{ $cat_parent->name }}</a>
                        </li>  
                        @else 
                        @if ($count_cat == 6)
                        <li style="border-top:1px solid #EEEEEE;">
                            <a href="#" onclick="changeOther(event, {{ $cat_parent->id }});">Покажи всички&nbsp;&raquo;</a>
                        </li>                            
                        <div  style="display:none;" id="div_{{ $cat_parent->id }}">
                        @endif
                        <li>
                            <span class="category-counter">{{ $productsin->count() }}</span>
                        </li>
                        <li>
                            <a href="{{ route('products', ['category_id'=>$category_idsin]) }}">{{ $cat_parent->name }}</a>
                        </li>
                        @endif
                        @php
                            $count_cat++;
                        @endphp
                        @endforeach
                        </div>  
                    </ul>
                  </div>
                </div>
              </div>
            @php
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
                        @php
                            if(!empty(Holiday::where(['id'=>$featured_product->holiday_id])->first())){
                                $holiday_name = Holiday::where(['id'=>$featured_product->holiday_id])->first()->name;
                            }else{
                                $holiday_name = '';
                            }
                        @endphp
                        <div class="homes-tag featured">{{ $holiday_name }}</div>
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
                            @php
                                if(!empty(City::where(['id'=>$featured_product->send_from_id])->first())){
                                    $city_name = City::where(['id'=>$featured_product->send_from_id])->first()->city;
                                }else{
                                    $city_name = '';
                                }
                            @endphp
                            <i class="lni-map-marker"></i> {{ $city_name }}
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
                        $top_image = asset('/images/backend_images/products/medium/'.$top->image);
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
                                        @php
                                            if(!empty(City::where(['id'=>$top->send_from_id])->first())){
                                                $city_name = City::where(['id'=>$top->send_from_id])->first()->city;
                                            }else{
                                                $city_name = '';
                                            }
                                        @endphp
                                        <i class="lni-map-marker"></i> {{ $city_name }}
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
                <div style="font-size: 14px;line-height: normal;padding-top:94px;"><a href="{{ route('index') }}">partybox.bg</a> е единственият по рода си сайт, който обединява на едно място всичко необходимо за парти организирането. Регистрирай се в сайта и се абонирай за имейл предложения от нас с най-актуалните оферти, съобразени с твоите предпочитания.</div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="fas fa-search"></i>
                    </div>
                    <p>НАМЕРИ НАЙ-ДОБРИТЕ ПАРТИ ОФЕРТИ ЗА ТЕБ</p>
                </div>
                <div style="font-size: 14px;line-height: normal;padding-top:60px;">
                    Тук можеш да откриеш най-изгодните и подходящи за теб продукти и услуги, с които ще направиш своето парти перфектно. Въведи населено място при търсене и сайта ще ти покаже всички оферти близо до теб - украса за партито, ресторанти, парти агенции, доставка на кетъринг, аниматори и всичко друго, от което имаш нужда.
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <p>ИСКАШ ДА ПРОДАВАШ ЧРЕЗ <a href="{{ route('index') }}">PARTYBOX.BG</a>?</p>
                </div>
                <div style="font-size: 14px;line-height: normal;padding-top:60px;">
                    Регистрирай се като търговец в сайта и започни да продаваш. Получаваш правото на 10 безплатни обяви и възможност да промотираш и рекламираш своите продукти и услуги на нашата платформа.
                </div>
            </div>
            <hr class="works-line">
        </div>
    </div>
</section>
<!-- Works Section End -->

@endsection

@section('scripts')
    <script>
    function changeOther(event, id){
        event.preventDefault();
        $("#div_"+id).toggle();
    }
    </script>
@endsection
