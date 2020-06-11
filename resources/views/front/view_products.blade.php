<?php use App\Category; ?>
<?php use App\User; ?>
<?php use App\City; ?>
<?php use App\Holiday; ?>
@extends('layouts.frontLayout.front_design')
@section('content')

<!-- Main container Start -->
<div class="main-container section-padding">
    <div class="container">
        @if ($turgovetsName != '')
        <div class="row"> 
            <div class="col-lg-12 col-md-12 col-xs-12 product-filter" style="text-align:center;background-color:#333333;color:white;">
                <h6 style="padding-top:5px;">Търговец: <span class="text-xl">{{$turgovetsName}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Населено място: <span class="text-xl">{{$turgovetsCityName}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Продава в partybox.bg от дата: <span class="text-xl">{{$turgovetsDate}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Брой поръчки: <span class="text-xl">{{$numberOfOrders}}</span></h6>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-3 col-md-12 col-xs-12 page-sidebar">
                @include('layouts.frontLayout.front_sidebar')
            </div>
            <div class="col-lg-9 col-md-12 col-xs-12 page-content">
                <!-- Product filter Start -->
                <!-- Order by form -->
                <form enctype="multipart/form-data" action="{{ route('products') }}" method="post" name="order_products" id="order_products" novalidate="novalidate">
                <div class="product-filter">
                    <div class="short-name">
                        @php
                            $current_page = 1;
                            if (!empty(request('page'))){
                                $current_page = intval(request('page'));
                            }
                            $start_products_count = ($current_page - 1) * $paginate + 1;
                            $end_products_count = $start_products_count + $products->count() - 1;
                        @endphp
                        <span>Показани ({{ $start_products_count }} - {{ $end_products_count }} продукта от общо {{ $all_products_count }} продукта)</span>
                    </div>
                    @csrf
                    @foreach (Holiday::all() as $holiday)
                        <input style="display:none;" type="checkbox" @if(request()->has('holiday_id') AND in_array($holiday->id, request('holiday_id'))) checked @endif name="holiday_id[]" value="{{ $holiday->id }}">
                    @endforeach
                    @foreach (Category::all() as $category)
                        <input style="display:none;" type="checkbox" @if(request()->has('category_id') AND in_array($category->id, request('category_id'))) checked @endif name="category_id[]" value="{{ $category->id }}">
                    @endforeach
                    @foreach (City::all() as $city)
                        <input style="display:none;" type="checkbox" @if(request()->has('city_id') AND in_array($city->id, request('city_id'))) checked @endif name="city_id[]" value="{{ $city->id }}">
                    @endforeach
                    @php
                        if(request()->has('min_price')){
                            $min_price = request('min_price');
                        }else{
                            $min_price = 0;
                        }
                        if(request()->has('max_price')){
                            $max_price = request('max_price');
                        }else{
                            $max_price = 0;
                        }
                        if(request()->has('age')){
                            $age = request('age');
                        }else{
                            $age = "0";
                        }
                        if(request()->has('send_id')){
                            $send_id = request('send_id');
                        }else{
                            $send_id = "0";
                        }
                        if(request()->has('send_free')){
                            $send_free = request('send_free');
                        }else{
                            $send_free = 0;
                        }
                        if(request()->has('object')){
                            $object = request('object');
                        }else{
                            $object = 0;
                        }
                        if(request()->has('personalize')){
                            $personalize = request('personalize');
                        }else{
                            $personalize = 0;
                        }
                        if(request()->has('user_id')){
                            $user_id = request('user_id');
                        }else{
                            $user_id = 0;
                        }
                    @endphp
                    <input name="min_price" type="hidden" value="{{ $min_price }}">
                    <input name="max_price" type="hidden" value="{{ $max_price }}">
                    <input name="age" type="hidden" value="{{ $age }}">
                    <input name="send_id" type="hidden" value="{{ $send_id }}">
                    <input name="send_free" type="hidden" value="{{ $send_free }}">
                    <input name="object" type="hidden" value="{{ $object }}">
                    <input name="personalize" type="hidden" value="{{ $personalize }}">
                    <input name="user_id" type="hidden" value="{{ $user_id }}">
                    <div class="Show-item">
                        <span>Подреждане на резултатите</span>
                        <select id="order_by" name="order_by" class="orderby">
                            <option value="0">Без подредба</option>
                            <option value="product_name_asc" @if(request()->has('order_by') AND request('order_by') == 'product_name_asc') selected @endif>Име А-Я</option>
                            <option value="product_name_desc" @if(request()->has('order_by') AND request('order_by') == 'product_name_desc') selected @endif>Име Я-А</option>
                            <option value="price_asc" @if(request()->has('order_by') AND request('order_by') == 'price_asc') selected @endif>Цена възходящо</option>
                            <option value="price_desc" @if(request()->has('order_by') AND request('order_by') == 'price_desc') selected @endif>Цена низходящо</option>
                        </select>
                    </div>
                </div>
                </form>
                <!-- Order by form -->
                <!-- Product filter End -->

                <!-- Adds wrapper Start -->
                <div class="adds-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show">
                            <div class="row">
                                @foreach ($featureds as $featured)
                                @php
                                if(!empty($featured->image)){
                                    $image = asset('/images/backend_images/products/large/'.$featured->image);
                                }else{
                                    $image = asset('/images/backend_images/products/large/no-image-1200.png');
                                }
                                @endphp
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="featured-box">
                                        <figure>
                                            @php
                                                if(!empty(Holiday::where(['id'=>$featured->holiday_id])->first())){
                                                    $holiday_name = Holiday::where(['id'=>$featured->holiday_id])->first()->name;
                                                }else{
                                                    $holiday_name = '';
                                                }
                                            @endphp
                                            <div class="homes-tag featured">{{ $holiday_name }}</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> {{ $featured->likes }}</div>
                                            <span class="price-save">{{ number_format($featured->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</span>
                                            <a href="{{ route('product', ['id'=>$featured->product_code]) }}"><img class="img-fluid" src="{{ $image }}" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="{{ route('product', ['id'=>$featured->product_code]) }}">{{ $featured->product_name }}</a></h4>
                                                <p class="listing-tagline">{{ $featured->product_code }}</p>
                                                <div class="meta-tag">
                                                    <div class="user-name">
                                                        <a href="{{ route('products', ['user_id'=>$featured->user_id]) }}"><i class="lni-user"></i> {{ User::where(['id'=>$featured->user_id])->first()->name }}</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        @php
                                                            $category_ids = [];
                                                            $category_ids[] = $featured->category_id;
                                                        @endphp
                                                        <a href="{{ route('products', ['category_id'=>$category_ids]) }}">{{ Category::where(['id'=>$featured->category_id])->first()->name }} </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                @php
                                                    if(!empty(City::where(['id'=>$featured->send_from_id])->first())){
                                                        $city_name = City::where(['id'=>$featured->send_from_id])->first()->city;
                                                    }else{
                                                        $city_name = '';
                                                    }
                                                @endphp
                                                <i class="lni-map-marker"></i> {{ $city_name }}
                                                <a href="{{ route('product', ['id'=>$featured->product_code]) }}" class="float-right">Прегледай Детайлно</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <hr />
                            <div class="row">
                                @foreach ($products as $product)
                                @php
                                if(!empty($product->image)){
                                    $image = asset('/images/backend_images/products/large/'.$product->image);
                                }else{
                                    $image = asset('/images/backend_images/products/large/no-image-1200.png');
                                }
                                @endphp
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <div class="featured-box">
                                        <figure>
                                            @php
                                                if(!empty(Holiday::where(['id'=>$product->holiday_id])->first())){
                                                    $holiday_name = Holiday::where(['id'=>$product->holiday_id])->first()->name;
                                                }else{
                                                    $holiday_name = '';
                                                }
                                            @endphp
                                            <div class="homes-tag featured">{{ $holiday_name }}</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> {{ $product->likes }}</div>
                                            <span class="price-save">{{ number_format($product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</span>
                                            <a href="{{ route('product', ['id'=>$product->product_code]) }}"><img class="img-fluid" src="{{ $image }}" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="{{ route('product', ['id'=>$product->product_code]) }}">{{ $product->product_name }}</a></h4>
                                                <p class="listing-tagline">{{ $product->product_code }}</p>
                                                <div class="meta-tag">
                                                    <div class="user-name">
                                                        <a href="{{ route('products', ['user_id'=>$product->user_id]) }}"><i class="lni-user"></i> {{ User::where(['id'=>$product->user_id])->first()->name }}</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        @php
                                                            $category_ids = [];
                                                            $category_ids[] = $product->category_id;
                                                        @endphp
                                                        <a href="{{ route('products', ['category_id'=>$category_ids]) }}">{{ Category::where(['id'=>$product->category_id])->first()->name }} </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                @php
                                                    if(!empty(City::where(['id'=>$product->send_from_id])->first())){
                                                        $city_name = City::where(['id'=>$product->send_from_id])->first()->city;
                                                    }else{
                                                        $city_name = '';
                                                    }
                                                @endphp
                                                <i class="lni-map-marker"></i> {{ $city_name }}
                                                <a href="{{ route('product', ['id'=>$product->product_code]) }}" class="float-right">Прегледай Детайлно</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Adds wrapper End -->

                <!-- Start Pagination -->
                {{ $products->links() }}
                <!-- End Pagination -->

                <div style="padding-bottom:20px;"></div>
                <hr />
                <div class="widget">
                    @foreach ($reklami as $reklama)
                    <div class="add-box">
                        <h5>{{ $reklama->title }}</h5>
                        <p>{{ $reklama->description }}</p>
                        @php
                            if(!empty($reklama->image_large)){
                                $image_large = asset('/images/backend_images/reklama_large/'.$reklama->image_large);
                            }else{
                                $image_large = "";
                            }
                        @endphp
                        @if ($image_large != "")
                            @if ($reklama->url != "") <a target="_blank" href="{{ $reklama->url }}"> @endif <img class="img-fluid" style="border:1px solid #FAAA39" src="{{ $image_large }}" alt="{{ $reklama->title }}"> @if ($reklama->url != "") </a> @endif
                        @endif
                    </div>            
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Main container End -->
@endsection

@section('scripts')
<script>
    // On change price range filter
    $('#min_price').on('input', function () {
        $('#min_price_current').html(parseFloat($(this).val()).toFixed(2) + '{{ Config::get('settings.currency') }}');
        min_price_current = parseFloat($(this).val());
        max_price_current = parseFloat($('#max_price').val());
        if (min_price_current > max_price_current){
            $('#max_price').val(min_price_current);
            $('#max_price_current').html(max_price_current.toFixed(2) + '{{ Config::get('settings.currency') }}');
        }
    });
    $('#max_price').on('input', function () {
        $('#max_price_current').html(parseFloat($(this).val()).toFixed(2) + '{{ Config::get('settings.currency') }}');
        min_price_current = parseFloat($('#min_price').val());
        max_price_current = parseFloat($(this).val());
        if (min_price_current > max_price_current){
            $('#min_price').val(max_price_current);
            $('#min_price_current').html(min_price_current.toFixed(2) + '{{ Config::get('settings.currency') }}');
        }
    });
    // Submit order form on change
    $('#order_by').on('change', function() {
        document.forms['order_products'].submit();
    });
</script>
@endsection
