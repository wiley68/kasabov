<?php use App\ProductsImage; ?>
<?php use App\City; ?>
<?php use App\User; ?>
<?php use App\Http\Controllers\ProductController; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
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

                        <h4 class="title-small mb-3">Параметри:</h4>
                        <ul class="list-specification">
                            <li><i class="lni-check-mark-circle"></i> 256GB PCIe flash storage</li>
                            <li><i class="lni-check-mark-circle"></i> 2.7 GHz dual-core Intel Core i5</li>
                            <li><i class="lni-check-mark-circle"></i> Turbo Boost up to 3.1GHz</li>
                            <li><i class="lni-check-mark-circle"></i> Intel Iris Graphics 6100</li>
                            <li><i class="lni-check-mark-circle"></i> 8GB memory</li>
                            <li><i class="lni-check-mark-circle"></i> 10 hour battery life</li>
                            <li><i class="lni-check-mark-circle"></i> 13.3" Retina Display</li>
                            <li><i class="lni-check-mark-circle"></i> 1 Year international warranty</li>
                        </ul>
                        <p class="mb-4">
                            Up for sale we have a vintage Raleigh Sport Men’s Bicycle. This bike does have some general wear and surface corrosion on
                            some of the parts but is overall in good shape. It has been checked out and does work. Brakes
                            and gears work. Seat is fully intact. Frame and fenders are in nice shape with minimal wear.
                            A few minor dents in the fenders but most of the paint is intact.
                        </p>
                    </div>
                    <div class="tag-bottom">
                        <div class="float-left">
                            <ul class="advertisement">
                                <li>
                                    <p><strong><i class="lni-folder"></i> Categories:</strong> <a href="#">Electronics</a></p>
                                </li>
                                <li>
                                    <p><strong><i class="lni-archive"></i> Condition:</strong> New</p>
                                </li>
                                <li>
                                    <p><strong><i class="lni-package"></i> Brand:</strong> <a href="#">Apple</a></p>
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
                                    <a href="#"><img src="assets/img/productinfo/agent.jpg" alt=""></a>
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
                        <h4 class="widget-title">More Ads From Seller</h4>
                        <ul class="posts-list">
                            <li>
                                <div class="widget-thumb">
                                    <a href="#"><img src="assets/img/details/img1.jpg" alt="" /></a>
                                </div>
                                <div class="widget-content">
                                    <h4><a href="#">Little Harbor Yacht 38</a></h4>
                                    <div class="meta-tag">
                                        <span>
                            <a href="#"><i class="lni-user"></i> Smith</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-map-marker"></i> New Your</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-tag"></i> Radio</a>
                          </span>
                                    </div>
                                    <h4 class="price">$480.00</h4>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="widget-thumb">
                                    <a href="#"><img src="assets/img/details/img2.jpg" alt="" /></a>
                                </div>
                                <div class="widget-content">
                                    <h4><a href="#">Little Harbor Yacht 38</a></h4>
                                    <div class="meta-tag">
                                        <span>
                            <a href="#"><i class="lni-user"></i> Smith</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-map-marker"></i> New Your</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-tag"></i> Radio</a>
                          </span>
                                    </div>
                                    <h4 class="price">$480.00</h4>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="widget-thumb">
                                    <a href="#"><img src="assets/img/details/img3.jpg" alt="" /></a>
                                </div>
                                <div class="widget-content">
                                    <h4><a href="#">Little Harbor Yacht 38</a></h4>
                                    <div class="meta-tag">
                                        <span>
                            <a href="#"><i class="lni-user"></i> Smith</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-map-marker"></i> New Your</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-tag"></i> Radio</a>
                          </span>
                                    </div>
                                    <h4 class="price">$480.00</h4>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="widget-thumb">
                                    <a href="#"><img src="assets/img/details/img4.jpg" alt="" /></a>
                                </div>
                                <div class="widget-content">
                                    <h4><a href="#">Little Harbor Yacht 38</a></h4>
                                    <div class="meta-tag">
                                        <span>
                            <a href="#"><i class="lni-user"></i> Smith</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-map-marker"></i> New Your</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-tag"></i> Radio</a>
                          </span>
                                    </div>
                                    <h4 class="price">$480.00</h4>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="widget-thumb">
                                    <a href="#"><img src="assets/img/details/img5.jpg" alt="" /></a>
                                </div>
                                <div class="widget-content">
                                    <h4><a href="#">Little Harbor Yacht 38</a></h4>
                                    <div class="meta-tag">
                                        <span>
                            <a href="#"><i class="lni-user"></i> Smith</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-map-marker"></i> New Your</a>
                          </span>
                                        <span>
                            <a href="#"><i class="lni-tag"></i> Radio</a>
                          </span>
                                    </div>
                                    <h4 class="price">$480.00</h4>
                                </div>
                                <div class="clearfix"></div>
                            </li>
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
