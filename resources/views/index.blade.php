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
                    <h1 class="section-title">{{ $property->category_title }}</h1>
                    <h4 class="sub-title"><a href="{{ route('products') }}">покажи всички продукти</a></h4>
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
                    <div class="category-icon-item lis-bg{{ $bg_count }}">
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
                    <h1 class="section-title">{{ $property->best_title }}</h1>
                    <h4 class="sub-title">{{ $property->best_subtitle }}</h4>
                </div>
            </div>
            @foreach ($featured_products as $featured_product)
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="featured-box">
                    <figure>
                        <div class="homes-tag featured">{{ Holiday::where(['id'=>$featured_product->holiday_id])->first()->name }}</div>
                        <div class="homes-tag rent"><i class="lni-heart"></i> {{ $featured_product->likes }}</div>
                        <span class="price-save">{{ number_format($featured_product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</span>
                        <a href="{{ route('product', ['id'=>$featured_product->product_code]) }}"><img class="img-fluid" src="{{ asset('/images/backend_images/products/small/'.$featured_product->image) }}" alt=""></a>
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
                    <h1 class="section-title">{{ $property->featured_title }}</h1>
                    <h4 class="sub-title">{{ $property->featured_subtitle }}</h4>
                </div>
            </div>
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                <div id="new-products" class="owl-carousel owl-theme">
                    @foreach ($tops as $top)
                    <div class="item">
                        <div class="product-item">
                            <div class="carousel-thumb">
                                <img class="img-fluid" src="{{ asset('/images/backend_images/products/small/'.$top->image) }}" alt="">
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
                    <h1 class="section-title">{{ $property->works_title }}</h1>
                    <h4 class="sub-title">{{ $property->works_subtitle }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="lni-users"></i>
                    </div>
                    <p>{{ $property->create_account }}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="lni-bookmark-alt"></i>
                    </div>
                    <p>{{ $property->post_add }}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="works-item">
                    <div class="icon-box">
                        <i class="lni-thumbs-up"></i>
                    </div>
                    <p>{{ $property->deal_done }}</p>
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
                    <h1 class="section-title">{{ $property->key_title }}</h1>
                    <h4 class="sub-title">{{ $property->key_subtitle }}</h4>
                </div>
            </div>
            <!-- feature 1 -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="{{ $property->key_icon1 }}"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">{{ $property->key_title1 }}</a></h3>
                        <p>{{ $property->key_description1 }}</p>
                    </div>
                </div>
            </div>
            <!-- feature 2 -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="{{ $property->key_icon2 }}"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">{{ $property->key_title2 }}</a></h3>
                        <p>{{ $property->key_description2 }}</p>
                    </div>
                </div>
            </div>
            <!-- feature 3 -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="{{ $property->key_icon3 }}"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">{{ $property->key_title3 }}</a></h3>
                        <p>{{ $property->key_description3 }}</p>
                    </div>
                </div>
            </div>
            <!-- feature 4 -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="{{ $property->key_icon4 }}"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">{{ $property->key_title4 }}</a></h3>
                        <p>{{ $property->key_description4 }}</p>
                    </div>
                </div>
            </div>
            <!-- feature 5 -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="{{ $property->key_icon5 }}"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">{{ $property->key_title5 }}</a></h3>
                        <p>{{ $property->key_description5 }}</p>
                    </div>
                </div>
            </div>
            <!-- feature 6 -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                    <div class="icon">
                        <i class="{{ $property->key_icon6 }}"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">{{ $property->key_title6 }}</a></h3>
                        <p>{{ $property->key_description6 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Testimonial Section Start -->
<section class="testimonial section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center"><hr/></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="testimonials" class="owl-carousel">
                    <div class="item">
                        <div class="img-thumb">
                            <img src="assets/img/testimonial/img1.png" alt="">
                        </div>
                        <div class="testimonial-item">
                            <div class="content">
                                <p class="description">{{ $property->testimonials_description1 }}</p>
                                <div class="info-text">
                                    <h2><a href="#">{{ $property->testimonials_name1 }}</a></h2>
                                    <h4><a href="#">{{ $property->testimonials_title1 }}</a></h4>
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
                                    <p class="description">{{ $property->testimonials_description2 }}</p>
                                    <div class="info-text">
                                        <h2><a href="#">{{ $property->testimonials_name2 }}</a></h2>
                                        <h4><a href="#">{{ $property->testimonials_title2 }}</a></h4>
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
                                    <p class="description">{{ $property->testimonials_description3 }}</p>
                                    <div class="info-text">
                                        <h2><a href="#">{{ $property->testimonials_name3 }}</a></h2>
                                        <h4><a href="#">{{ $property->testimonials_title3 }}</a></h4>
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
                    <h1 class="section-title">Новини</h1>
                    <h4 class="sub-title">някакъв обяснителен текст. някакъв обяснителен текст. някакъв обяснителен текст.</h4>
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
                        <a href="single-post.html" class="btn btn-common">Прочети още...</a>
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
                        <a href="single-post.html" class="btn btn-common">Прочети още...</a>
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
                        <a href="single-post.html" class="btn btn-common">Прочети още...</a>
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
                        <h3>Запиши се за новини</h3>
                        <p>ще можете да получавате актуална информация</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form>
                    <div class="subscribe">
                        <input class="form-control" name="EMAIL" placeholder="Въведете Вашия Email" required="" type="email">
                        <button class="btn btn-common" type="submit">Абонирай се</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Subscribe Section End -->
@endsection
