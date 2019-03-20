<?php use App\Category; ?>
<?php use App\User; ?>
<?php use App\City; ?>
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
                        <span>Showing (1 - 12 products of 7371 products)</span>
                    </div>
                    <div class="Show-item">
                        <span>Show Items</span>
                        <form class="woocommerce-ordering" method="post">
                            <label>
                      <select name="order" class="orderby">
                        <option selected="selected" value="menu-order">49 items</option>
                        <option value="popularity">popularity</option>
                        <option value="popularity">Average ration</option>
                        <option value="popularity">newness</option>
                        <option value="popularity">price</option>
                      </select>
                    </label>
                        </form>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#grid-view"><i class="lni-grid"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#list-view"><i class="lni-list"></i></a>
                        </li>
                    </ul>
                </div>
                <!-- Product filter End -->

                <!-- Adds wrapper Start -->
                <div class="adds-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show">
                            <div class="row">
                                @foreach ($products as $product)
                                @php
                                $category_parent_id = Category::where(['id'=>$product->category_id])->first()->parent_id;
                                if ($category_parent_id !== 0){
                                    $category_parent = Category::where(['id'=>$category_parent_id])->first()->name;
                                }else{
                                    $category_parent = Category::where(['id'=>$product->category_id])->first()->name;
                                }
                                @endphp
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="featured-box">
                                        <figure>
                                            <div class="homes-tag featured">{{ Category::where(['id'=>$product->category_id])->first()->name }}</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> 202</div>
                                            <span class="price-save">{{ $product->price }}</span>
                                            <a href="#"><img class="img-fluid" src="{{ asset('/images/backend_images/products/small/'.$product->image) }}" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="ads-details.html">{{ $product->product_name }}</a></h4>
                                                <p class="listing-tagline">{{ $product->product_code }}</p>
                                                <div class="meta-tag">
                                                    <div class="listing-review">
                                                        <span class="review-avg">4.5</span>
                                                    </div>
                                                    <div class="user-name">
                                                        <a href="#"><i class="lni-user"></i> {{ User::where(['id'=>$product->user_id])->first()->name }}</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        <a href="#"><i class="{{ Category::where(['id'=>$product->category_id])->first()->icon }}"></i>{{ $category_parent }} </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                <a href="#" class="float-left"><i class="lni-map-marker"></i> {{ City::where(['id'=>$product->send_id])->first()->city }}</a>
                                                <a href="ads-details.html" class="float-right">Прегледай Детайлно</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="list-view" class="tab-pane fade">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="featured-box">
                                        <figure>
                                            <div class="homes-tag featured">Cameras</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> 200</div>
                                            <span class="price-save">
                              $200
                            </span>
                                            <a href="#"><img class="img-fluid" src="assets/img/featured/img-1.jpg" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="ads-details.html">Canon SX Powershot ...</a></h4>
                                                <p class="listing-tagline">Club and shop for you</p>
                                                <div class="meta-tag">
                                                    <div class="listing-review">
                                                        <span class="review-avg">4.5</span> 2 Ratings
                                                    </div>
                                                    <div class="user-name">
                                                        <a href="#"><i class="lni-user"></i> Jone</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        <a href="#"><i class="lni-display"></i>Electronic </a>
                                                    </div>
                                                </div>
                                                <p class="dsc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                    Lorem Ipsum has been the industry.</p>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                <a href="#" class="float-left"><i class="lni-map-marker"></i> New York, US</a>
                                                <a href="ads-details.html" class="float-right">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="featured-box">
                                        <figure>
                                            <div class="homes-tag featured">Laptop</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> 152</div>
                                            <span class="price-save">
                              $1499
                            </span>
                                            <a href="#"><img class="img-fluid" src="assets/img/featured/img-2.jpg" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="ads-details.html">Apple Macbook Pro ...</a></h4>
                                                <p class="listing-tagline">Club and shop for you</p>
                                                <div class="meta-tag">
                                                    <div class="listing-review">
                                                        <span class="review-avg">4.5</span> 2 Ratings
                                                    </div>
                                                    <div class="user-name">
                                                        <a href="#"><i class="lni-user"></i> Jessica</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        <a href="#"><i class="lni-laptop"></i>Computers</a>
                                                    </div>
                                                </div>
                                                <p class="dsc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                    Lorem Ipsum has been the industry.</p>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                <a href="#" class="float-left"><i class="lni-map-marker"></i> California, US</a>
                                                <a href="ads-details.html" class="float-right">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="featured-box">
                                        <figure>
                                            <div class="homes-tag featured">Cars</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> 155</div>
                                            <span class="price-save">
                              $2000
                            </span>
                                            <a href="#"><img class="img-fluid" src="assets/img/featured/img-3.jpg" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="ads-details.html">Mercedes Benz E200 ...</a></h4>
                                                <p class="listing-tagline">Club and shop for you</p>
                                                <div class="meta-tag">
                                                    <div class="listing-review">
                                                        <span class="review-avg">4.5</span> 3 Ratings
                                                    </div>
                                                    <div class="user-name">
                                                        <a href="#"><i class="lni-user"></i> Maria Barlow</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        <a href="#"><i class="lni-car"></i>Vehicle </a>
                                                    </div>
                                                </div>
                                                <p class="dsc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                    Lorem Ipsum has been the industry.</p>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                <a href="#" class="float-left"><i class="lni-map-marker"></i> Washington, US</a>
                                                <a href="ads-details.html" class="float-right">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="featured-box">
                                        <figure>
                                            <div class="homes-tag featured">Bags</div>
                                            <div class="homes-tag rent"><i class="lni-heart"></i> 129</div>
                                            <span class="price-save">
                              $30
                            </span>
                                            <a href="#"><img class="img-fluid" src="assets/img/featured/img-4.jpg" alt=""></a>
                                        </figure>
                                        <div class="content-wrapper">
                                            <div class="feature-content">
                                                <h4><a href="ads-details.html">Brown Leather Bag ...</a></h4>
                                                <p class="listing-tagline">Club and shop for you</p>
                                                <div class="meta-tag">
                                                    <div class="listing-review">
                                                        <span class="review-avg">4.5</span> 5 Ratings
                                                    </div>
                                                    <div class="user-name">
                                                        <a href="#"><i class="lni-user"></i> Rossi Josh</a>
                                                    </div>
                                                    <div class="listing-category">
                                                        <a href="#"><i class="lni-leaf"></i>Others</a>
                                                    </div>
                                                </div>
                                                <p class="dsc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                    Lorem Ipsum has been the industry.</p>
                                            </div>
                                            <div class="listing-bottom clearfix">
                                                <a href="#" class="float-left"><i class="lni-map-marker"></i> Chicago, US</a>
                                                <a href="ads-details.html" class="float-right">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Adds wrapper End -->

                <!-- Start Pagination -->
                <div class="pagination-bar">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- End Pagination -->

            </div>
        </div>
    </div>
</div>
<!-- Main container End -->
@endsection
