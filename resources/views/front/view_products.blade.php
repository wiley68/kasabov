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
                    <div class="Show-item">
                        <span>Подреждане на резултатите</span>
                        <select id="order_by" class="orderby">
                            <option @if(request('sort_by') == '') selected @endif value="all">Без подредба</option>
                            <option @if((request('sort_by') == 'product_name') && (request('sort') == 'asc')) selected @endif value="name_asc">Име A-Я</option>
                            <option @if((request('sort_by') == 'product_name') && (request('sort') == 'desc')) selected @endif value="name_desc">Име Я-А</option>
                            <option @if((request('sort_by') == 'price') && (request('sort') == 'asc')) selected @endif value="price_asc">Цена възходящо</option>
                            <option @if((request('sort_by') == 'price') && (request('sort') == 'desc')) selected @endif value="price_desc">Цена низходящо</option>
                        </select>
                    </div>
                </div>
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
    $("#order_by").change(function(){
        sort_request = $(this).val();
        switch(sort_request) {
            case 'name_asc':
                sort = 'asc';
                sort_by = 'product_name';
            break;
            case 'name_desc':
                sort = 'desc';
                sort_by = 'product_name';
            break;
            case 'price_asc':
                sort = 'asc';
                sort_by = 'price';
            break;
            case 'price_desc':
                sort = 'desc';
                sort_by = 'price';
            break;
            case 'all':
                sort = '';
                sort_by = '';
            break;
            default:
                sort = '';
                sort_by = '';
        }

        // base url
        url = '{{ route('products') }}';

        //sort_by url
        if (sort_by !== ''){
            sort_by_url = '&sort_by=' + sort_by;
        }else{
            sort_by_url = '';
        }

        //sort url
        if (sort !== ''){
            sort_url = '&sort=' + sort;
        }else{
            sort_url = '';
        }

        // go to location filter
        if ((sort_by == '') && (sort == '')){
            window.location = url;
        }else{
            window.location = url + '?filter=yes' + sort_by_url + sort_url;
        }
    });

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
</script>
@endsection
