<?php use App\Category; ?>
<?php use App\User; ?>
<?php use App\City; ?>
@extends('layouts.frontLayout.front_design_index')
@section('content')

<!-- Categories item Start -->
<section id="categories" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">Категории продукти</h1>
                    <h4 class="sub-title">някакъв обяснителен текст</h4>
                </div>
            </div>
            @php
                $bg_count = 1;
            @endphp
            @foreach ($categories_top as $category_top)
            <div class="col-lg-2 col-md-3 col-xs-12">
                <a href="#">
                    <div class="category-icon-item lis-bg{{ $bg_count }}">
                        <div class="icon-box">
                            <div class="icon">
                                <i class="{{ $category_top->icon }}"></i>
                            </div>
                            <h4>{{ $category_top->name }}</h4>
                            <p class="categories-listing">{{ Category::where(['parent_id'=>$category_top->id])->count() }} продукта</p>
                        </div>
                    </div>
                </a>
            </div>
            @php
                $bg_count++;
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
                    <h1 class="section-title">Най-харесвани продукти</h1>
                    <h4 class="sub-title">някакъв обяснителен текст</h4>
                </div>
            </div>
            @foreach ($latest as $item)
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="featured-box">
                    <figure>
                        <div class="homes-tag featured">{{ $item->name }}</div>
                        <div class="homes-tag rent"><i class="lni-heart"></i> 202</div>
                        <span class="price-save">{{ $item->price }}</span>
                        <a href="#"><img class="img-fluid" src="{{ asset('/images/backend_images/products/small/'.$item->image) }}" alt=""></a>
                    </figure>
                    <div class="content-wrapper">
                        <div class="feature-content">
                            <h4><a href="ads-details.html">{{ $item->product_name }}</a></h4>
                            <p class="listing-tagline">{{ $item->product_code }}</p>
                            <div class="meta-tag">
                                <div class="listing-review">
                                    <span class="review-avg">4.5</span>
                                </div>
                                <div class="user-name">
                                    <a href="#"><i class="lni-user"></i> {{ User::where(['id'=>$item->user_id])->first()->name }}</a>
                                </div>
                                <div class="listing-category">
                                    <a href="#"><i class="{{ Category::where(['id'=>$item->category_id])->first()->icon }}"></i>{{ Category::where(['id'=>$item->category_id])->first()->name }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="listing-bottom clearfix">
                            <a href="#" class="float-left"><i class="lni-map-marker"></i> {{ City::where(['id'=>$item->send_id])->first()->city }}</a>
                            <a href="ads-details.html" class="float-right">Прегледай Детайлно</a>
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
                    <h1 class="section-title">Featured Products</h1>
                    <h4 class="sub-title">Discover & connect with top-rated local businesses</h4>
                </div>
            </div>
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                <div id="new-products" class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="assets/img/product/img1.jpg" alt="">
                                <div class="overlay">
                                    <div>
                                        <a class="btn btn-common" href="ads-details.html">View Details</a>
                                    </div>
                                </div>
                                <div class="btn-product bg-sale">
                                    <a href="#">Sale</a>
                                </div>
                                <span class="price">$999.00</span>
                            </div>
                            <div class="product-content-inner">
                                <div class="product-content">
                                    <h3 class="product-title"><a href="ads-details.html">Macbook Pro 2020</a></h3>
                                    <span>Electronic / Computers</span>
                                    <div class="icon">
                                        <span><i class="lni-bookmark"></i></span>
                                        <span><i class="lni-heart"></i></span>
                                    </div>
                                </div>
                                <div class="card-text clearfix">
                                    <div class="float-left">
                                        <span class="icon-wrap">
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star"></i>
                          </span>
                                        <span class="count-review">
                            (12 Review)
                          </span>
                                    </div>
                                    <div class="float-right">
                                        <a class="address" href="#"><i class="lni-map-marker"></i> New York</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="assets/img/product/img2.jpg" alt="">
                                <div class="overlay">
                                    <div>
                                        <a class="btn btn-common" href="ads-details.html">View Details</a>
                                    </div>
                                </div>
                                <span class="price">$269.00</span>
                            </div>
                            <div class="product-content-inner">
                                <div class="product-content">
                                    <h3 class="product-title"><a href="ads-details.html">Nikon Camera</a></h3>
                                    <span>Electronic / Camera</span>
                                    <div class="icon">
                                        <span><i class="lni-bookmark"></i></span>
                                        <span><i class="lni-heart"></i></span>
                                    </div>
                                </div>
                                <div class="card-text clearfix">
                                    <div class="float-left">
                                        <span class="icon-wrap">
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                          </span>
                                        <span class="count-review">
                            (2 Review)
                          </span>
                                    </div>
                                    <div class="float-right">
                                        <a class="address" href="#"><i class="lni-map-marker"></i> California</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="assets/img/product/img3.jpg" alt="">
                                <div class="overlay">
                                    <div>
                                        <a class="btn btn-common" href="ads-details.html">View Details</a>
                                    </div>
                                </div>
                                <div class="btn-product bg-slod">
                                    <a href="#">Sold</a>
                                </div>
                                <span class="price">$799.00</span>
                            </div>
                            <div class="product-content-inner">
                                <div class="product-content">
                                    <h3 class="product-title"><a href="ads-details.html">iPhone X Refurbished</a></h3>
                                    <span>Electronic / Phones</span>
                                    <div class="icon">
                                        <span><i class="lni-bookmark"></i></span>
                                        <span><i class="lni-heart"></i></span>
                                    </div>
                                </div>
                                <div class="card-text clearfix">
                                    <div class="float-left">
                                        <span class="icon-wrap">
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star"></i>
                          </span>
                                        <span class="count-review">
                            (8 Review)
                          </span>
                                    </div>
                                    <div class="float-right">
                                        <a class="address" href="#"><i class="lni-map-marker"></i> New York</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="assets/img/product/img4.jpg" alt="">
                                <div class="overlay">
                                    <div>
                                        <a class="btn btn-common" href="ads-details.html">View Details</a>
                                    </div>
                                </div>
                                <span class="price">$99.00</span>
                            </div>
                            <div class="product-content-inner">
                                <div class="product-content">
                                    <h3 class="product-title"><a href="ads-details.html">Brown Leather Bag</a></h3>
                                    <span>Sports / Bag</span>
                                    <div class="icon">
                                        <span><i class="lni-bookmark"></i></span>
                                        <span><i class="lni-heart"></i></span>
                                    </div>
                                </div>
                                <div class="card-text clearfix">
                                    <div class="float-left">
                                        <span class="icon-wrap">
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star"></i>
                          </span>
                                        <span class="count-review">
                            (12 Review)
                          </span>
                                    </div>
                                    <div class="float-right">
                                        <a class="address" href="#"><i class="lni-map-marker"></i> New York</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="assets/img/product/img5.jpg" alt="">
                                <div class="overlay">
                                    <div>
                                        <a class="btn btn-common" href="ads-details.html">View Details</a>
                                    </div>
                                </div>
                                <span class="price">$99.00</span>
                            </div>
                            <div class="product-content-inner">
                                <div class="product-content">
                                    <h3 class="product-title"><a href="ads-details.html">iMac Pro 2020</a></h3>
                                    <span>Sports / Display</span>
                                    <div class="icon">
                                        <span><i class="lni-bookmark"></i></span>
                                        <span><i class="lni-heart"></i></span>
                                    </div>
                                </div>
                                <div class="card-text clearfix">
                                    <div class="float-left">
                                        <span class="icon-wrap">
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star"></i>
                          </span>
                                        <span class="count-review">
                            (12 Review)
                          </span>
                                    </div>
                                    <div class="float-right">
                                        <a class="address" href="#"><i class="lni-map-marker"></i> New York</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="assets/img/product/img6.jpg" alt="">
                                <div class="overlay">
                                    <div>
                                        <a class="btn btn-common" href="ads-details.html">View Details</a>
                                    </div>
                                </div>
                                <div class="btn-product bg-sale">
                                    <a href="#">Sale</a>
                                </div>
                                <span class="price">$99.00</span>
                            </div>
                            <div class="product-content-inner">
                                <div class="product-content">
                                    <h3 class="product-title"><a href="ads-details.html">Baby Toy</a></h3>
                                    <span>Sports / Baby Toys</span>
                                    <div class="icon">
                                        <span><i class="lni-bookmark"></i></span>
                                        <span><i class="lni-heart"></i></span>
                                    </div>
                                </div>
                                <div class="card-text clearfix">
                                    <div class="float-left">
                                        <span class="icon-wrap">
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star-filled"></i>
                            <i class="lni-star"></i>
                          </span>
                                        <span class="count-review">
                            (12 Review)
                          </span>
                                    </div>
                                    <div class="float-right">
                                        <a class="address" href="#"><i class="lni-map-marker"></i> New York</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <h1 class="section-title">How It Works?</h1>
                    <h4 class="sub-title">Discover & connect with top-rated local businesses</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="lni-users"></i>
                    </div>
                    <p>Create an Account</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="lni-bookmark-alt"></i>
                    </div>
                    <p>Post Free Ad</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="lni-thumbs-up"></i>
                    </div>
                    <p>Deal Done</p>
                </div>
            </div>
            <hr class="works-line">
        </div>
    </div>
</section>
<!-- Works Section End -->

<!-- Services Section Start -->
<section class="services bg-light section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">Key Features</h1>
                    <h4 class="sub-title">Find the best places</h4>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="lni-leaf"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">Elegant Design</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis.</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.4s">
                    <div class="icon">
                        <i class="lni-display"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">Responsive Design</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis.</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.6s">
                    <div class="icon">
                        <i class="lni-color-pallet"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">Clean UI</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis.</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.8s">
                    <div class="icon">
                        <i class="lni-emoji-smile"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">UX Friendly</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis.</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="1s">
                    <div class="icon">
                        <i class="lni-pencil-alt"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">Easily Customizable</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis.</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="1.2s">
                    <div class="icon">
                        <i class="lni-headphone-alt"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">Security Support</a></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo aut magni perferendis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Pricing section Start -->
<section id="pricing-table" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">Pricing Plan</h1>
                    <h4 class="sub-title">Discover & connect with top-rated local businesses</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-gift"></i>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">$29</p>
                    </div>
                    <div class="title">
                        <h3>Basic</h3>
                    </div>
                    <ul class="description">
                        <li>Free ad posting</li>
                        <li>No Featured ads availability</li>
                        <li>Access to limited features</li>
                        <li>For 30 days</li>
                        <li>100% Secure!</li>
                    </ul>
                    <button class="btn btn-common">Purchase</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table" id="active-tb">
                    <div class="icon">
                        <i class="lni-leaf"></i>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">$49</p>
                    </div>
                    <div class="title">
                        <h3>Standard</h3>
                    </div>
                    <ul class="description">
                        <li>Free ad posting</li>
                        <li>10 Featured ads availability</li>
                        <li>Access to unlimited features</li>
                        <li>For 30 days</li>
                        <li>100% Secure!</li>
                    </ul>
                    <button class="btn btn-common">Purchase</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table">
                    <div class="icon">
                        <i class="lni-layers"></i>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">$69</p>
                    </div>
                    <div class="title">
                        <h3>Premium</h3>
                    </div>
                    <ul class="description">
                        <li>Free ad posting</li>
                        <li>100 Featured ads availability</li>
                        <li>Access to unlimited features</li>
                        <li>For 30 days</li>
                        <li>100% Secure!</li>
                    </ul>
                    <button class="btn btn-common">Purchase</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Pricing Table Section End -->

<!-- Testimonial Section Start -->
<section class="testimonial section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="testimonials" class="owl-carousel">
                    <div class="item">
                        <div class="img-thumb">
                            <img src="assets/img/testimonial/img1.png" alt="">
                        </div>
                        <div class="testimonial-item">
                            <div class="content">
                                <p class="description">Eiusmod tempor incidiunt labore velit dolore magna aliqu sed eniminim veniam quis nostrud
                                    exercition eullamco laborisaa, Eiusmod tempor incidiunt labore velit dolore magna.</p>
                                <div class="info-text">
                                    <h2><a href="#">Josh Rossi</a></h2>
                                    <h4><a href="#">CEO of Fiverr</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item">
                            <div class="img-thumb">
                                <img src="assets/img/testimonial/img2.png" alt="">
                            </div>
                            <div class="testimonial-item">
                                <div class="content">
                                    <p class="description">Eiusmod tempor incidiunt labore velit dolore magna aliqu sed eniminim veniam quis nostrud
                                        exercition eullamco laborisaa, Eiusmod tempor incidiunt labore velit dolore magna.</p>
                                    <div class="info-text">
                                        <h2><a href="#">Jessica</a></h2>
                                        <h4><a href="#">CEO of Dropbox</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item">
                            <div class="img-thumb">
                                <img src="assets/img/testimonial/img3.png" alt="">
                            </div>
                            <div class="testimonial-item">
                                <div class="content">
                                    <p class="description">Eiusmod tempor incidiunt labore velit dolore magna aliqu sed eniminim veniam quis nostrud
                                        exercition eullamco laborisaa, Eiusmod tempor incidiunt labore velit dolore magna.</p>
                                    <div class="info-text">
                                        <h2><a href="#">Johnny Zeigler</a></h2>
                                        <h4><a href="#">CEO of Fiverr</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item">
                            <div class="img-thumb">
                                <img src="assets/img/testimonial/img4.png" alt="">
                            </div>
                            <div class="testimonial-item">
                                <div class="content">
                                    <p class="description">Eiusmod tempor incidiunt labore velit dolore magna aliqu sed eniminim veniam quis nostrud
                                        exercition eullamco laborisaa, Eiusmod tempor incidiunt labore velit dolore magna.</p>
                                    <div class="info-text">
                                        <h2><a href="#">Josh Rossi</a></h2>
                                        <h4><a href="#">CEO of Fiverr</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item">
                            <div class="img-thumb">
                                <img src="assets/img/testimonial/img5.png" alt="">
                            </div>
                            <div class="testimonial-item">
                                <div class="content">
                                    <p class="description">Eiusmod tempor incidiunt labore velit dolore magna aliqu sed eniminim veniam quis nostrud
                                        exercition eullamco laborisaa, Eiusmod tempor incidiunt labore velit dolore magna.</p>
                                    <div class="info-text">
                                        <h2><a href="#">Priyanka</a></h2>
                                        <h4><a href="#">CEO of Dropbox</a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial Section End -->

<!-- Blog Section -->
<section id="blog" class="section-padding">
    <!-- Container Starts -->
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="heading">
                    <h1 class="section-title">Blog Post</h1>
                    <h4 class="sub-title">Discover & connect with top-rated local businesses</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 blog-item">
                <!-- Blog Item Starts -->
                <div class="blog-item-wrapper">
                    <div class="blog-item-img">
                        <a href="single-post.html">
                    <img src="assets/img/blog/img-1.jpg" alt="">
                  </a>
                    </div>
                    <div class="blog-item-text">
                        <div class="meta-tags">
                            <span class="user float-left"><a href="#"><i class="lni-user"></i> Posted By Admin</a></span>
                            <span class="date float-right"><i class="lni-calendar"></i> 24 May, 2020</span>
                        </div>
                        <h3>
                            <a href="single-post.html">Recently Launching Our Iphone X</a>
                        </h3>
                        <p>
                            Reprehenderit nemo quod tempore doloribus ratione distinctio quis quidem vitae sunt reiciendis, molestias omnis soluta.
                        </p>
                        <a href="single-post.html" class="btn btn-common">Read More</a>
                    </div>
                </div>
                <!-- Blog Item Wrapper Ends-->
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12 blog-item">
                <!-- Blog Item Starts -->
                <div class="blog-item-wrapper">
                    <div class="blog-item-img">
                        <a href="single-post.html">
                    <img src="assets/img/blog/img-2.jpg" alt="">
                  </a>
                    </div>
                    <div class="blog-item-text">
                        <div class="meta-tags">
                            <span class="user float-left"><a href="#"><i class="lni-user"></i> Posted By Admin</a></span>
                            <span class="date float-right"><i class="lni-calendar"></i> 24 May, 2020</span>
                        </div>
                        <h3>
                            <a href="single-post.html">How to get more ad views</a>
                        </h3>
                        <p>
                            Reprehenderit nemo quod tempore doloribus ratione distinctio quis quidem vitae sunt reiciendis, molestias omnis soluta.
                        </p>
                        <a href="single-post.html" class="btn btn-common">Read More</a>
                    </div>
                </div>
                <!-- Blog Item Wrapper Ends-->
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12 blog-item">
                <!-- Blog Item Starts -->
                <div class="blog-item-wrapper">
                    <div class="blog-item-img">
                        <a href="single-post.html">
                    <img src="assets/img/blog/img-3.jpg" alt="">
                  </a>
                    </div>
                    <div class="blog-item-text">
                        <div class="meta-tags">
                            <span class="user float-left"><a href="#"><i class="lni-user"></i> Posted By Admin</a></span>
                            <span class="date float-right"><i class="lni-calendar"></i> 24 May, 2020</span>
                        </div>
                        <h3>
                            <a href="single-post.html">Writing a better product description</a>
                        </h3>
                        <p>
                            Reprehenderit nemo quod tempore doloribus ratione distinctio quis quidem vitae sunt reiciendis, molestias omnis soluta.
                        </p>
                        <a href="single-post.html" class="btn btn-common">Read More</a>
                    </div>
                </div>
                <!-- Blog Item Wrapper Ends-->
            </div>
        </div>
    </div>
</section>
<!-- blog Section End -->

<!-- Subscribe Section Start -->
<section class="subscribes section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="subscribes-inner">
                    <div class="icon">
                        <i class="lni-pointer"></i>
                    </div>
                    <div class="sub-text">
                        <h3>Subscribe to Newsletter</h3>
                        <p>and receive new ads in inbox</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form>
                    <div class="subscribe">
                        <input class="form-control" name="EMAIL" placeholder="Enter your Email" required="" type="email">
                        <button class="btn btn-common" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Subscribe Section End -->
@endsection
