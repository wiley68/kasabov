<?php use App\Holiday; ?>
<!-- Header Area wrapper Starts -->
<header id="header-wrap">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
        <div class="container">
            <div class="theme-header clearfix">
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="navbar-nav mr-auto w-100 justify-content-left">
                        @foreach ($holidays as $holiday)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $holiday->name }}<i class="lni-chevron-down"></i>
                                </a>
                            <ul class="dropdown-menu">
                                @foreach (Holiday::where(['parent_id'=>$holiday->id])->get() as $item)
                                <li><a class="dropdown-item" href="#">{{ $item->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="#" aria-expanded="false">Всички празници ...</a>
                        </li>
                    </ul>
                    <div class="header-top-right float-right">
                        <a href="#" class="header-top-button"><i class="lni-lock"></i> Вход</a> |
                        <a href="#" class="header-top-button"><i class="lni-pencil"></i> Регистрация</a>
                    </div>&nbsp;
                    <div class="post-btn">
                        <a class="btn btn-common" href="#"><i class="lni-pencil-alt"></i> Публикувай</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-menu" data-logo="{{ asset('images/frontend_images/logo-mobile.png') }}"></div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Area Start -->
    <div id="hero-area">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-9 col-xs-12 text-center">
                    <div class="contents-ctg">
                        <h5>
                            <a href="{{ route('index') }}">В началото</a>
                            <i class="fas fa-chevron-right"></i>
                            @if(Route::current()->getName() == 'products')
                            <a href="{{ route('products') }}">Всички продукти</a>
                            @elseif(Route::current()->getName() == 'product')
                            <a href="{{ route('products') }}">Всички продукти</a>
                            <i class="fas fa-chevron-right"></i>
                            <a href="{{ route('product', ['id=>{{ $product->id }}']) }}">{{ $product->product_name }}</a>
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->

</header>
<!-- Header Area wrapper End -->
