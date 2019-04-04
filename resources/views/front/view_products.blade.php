<?php use App\Category; ?>
<?php use App\User; ?>
<?php use App\City; ?>
<?php use App\Holiday; ?>
@extends('layouts.frontLayout.front_design')
@section('content')

<!-- Main container Start -->
<div class="main-container section-padding">
    <div class="container">
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
                    @foreach ($holidays as $holiday)
                        <input style="display:none;" type="checkbox" @if(request()->has('holiday_id') AND in_array($holiday->id, request('holiday_id'))) checked @endif name="holiday_id[]" value="{{ $holiday->id }}">
                    @endforeach
                    @foreach ($categories as $category)
                        <input style="display:none;" type="checkbox" @if(request()->has('category_id') AND in_array($category->id, request('category_id'))) checked @endif name="category_id[]" value="{{ $category->id }}">
                    @endforeach
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
                                @foreach ($products as $product)
                                @php
                                if(!empty($product->image)){
                                    $image = asset('/images/backend_images/products/large/'.$product->image);
                                }else{
                                    $image = asset('/images/backend_images/products/large/no-image-1200.png');
                                }
                                @endphp
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="featured-box">
                                        <figure>
                                            <div class="homes-tag featured">{{ Holiday::where(['id'=>$product->holiday_id])->first()->name }}</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> 202</div>
                                            <span class="price-save">{{ $product->price }}</span>
                                            <a href="#"><img class="img-fluid" src="{{ $image }}" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="{{ route('product', ['id'=>$product->id]) }}">{{ $product->product_name }}</a></h4>
                                                <p class="listing-tagline">{{ $product->product_code }}</p>
                                                <div class="meta-tag">
                                                    <div class="listing-review">
                                                        <span class="review-avg">4.5</span>
                                                    </div>
                                                    <div class="user-name">
                                                        <a href="#"><i class="lni-user"></i> {{ User::where(['id'=>$product->user_id])->first()->name }}</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        <a href="#"><i class="{{ Category::where(['id'=>$product->category_id])->first()->icon }}"></i>{{ Category::where(['id'=>$product->category_id])->first()->name }} </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                <a href="#" class="float-left"><i class="lni-map-marker"></i> {{ City::where(['id'=>$product->send_id])->first()->city }}</a>
                                                <a href="{{ route('product', ['id'=>$product->id]) }}" class="float-right">Прегледай Детайлно</a>
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
