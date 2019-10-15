<?php use App\Holiday; ?>
<!-- Header Area wrapper Starts -->
<header id="header-wrap">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar" style="background: #333333;">
        <div class="container">
            <div class="theme-header clearfix">
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="navbar-nav mr-auto w-100 justify-content-left">
                        @foreach ($holidays as $holiday)
                            <li class="nav-item dropdown">
                                @php
                                    $holiday_ids = [];
                                    $holiday_ids[] = $holiday->id;
                                @endphp
                                <a class="nav-link dropdown-toggle" href="{{ route('products', ['holiday_id'=>$holiday_ids]) }}" aria-haspopup="true" aria-expanded="false">
                                    {{ $holiday->name }}<i class="lni-chevron-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach (Holiday::where(['parent_id'=>$holiday->id])->get() as $item)
                                        @php
                                            $item_ids = [];
                                            $item_ids[] = $item->id;
                                        @endphp
                                        <li><a class="dropdown-item" href="{{ route('products', ['holiday_id'=>$item_ids]) }}">{{ $item->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products') }}" aria-expanded="false">Всички празници ...</a>
                        </li>
                    </ul>
                    @guest
                    <div class="header-top-right float-right">
                        <a href="{{ route('users-login-register') }}" class="header-top-button"><i class="lni-lock"></i> Вход | Регистрация</a>
                    </div>
                    @else
                    <div class="header-top-right float-right">
                        @if(Auth::user()->admin == 0)
                        <a href="{{ route('home') }}" class="header-top-button"><i class="lni-user"></i> {{ Auth::user()->name }}</a> |
                        <a href="{{ route('logout-front-user') }}" class="header-top-button"><i class="lni-exit"></i> Изход</a>
                        @endif
                        @if(Auth::user()->admin == 2)
                        <a href="{{ route('home-firm') }}" class="header-top-button"><i class="lni-user"></i> {{ Auth::user()->name }}</a> |
                        <a href="{{ route('logout-front-firm') }}" class="header-top-button"><i class="lni-exit"></i> Изход</a>
                        @endif
                        @if(Auth::user()->admin == 1)
                        <i class="lni-user"></i> {{ Auth::user()->name }}
                        @endif
                    </div>
                    @endguest
                    &nbsp;
                    <div class="post-btn">
                        <a class="btn btn-common" href="{{ route('firms-login-register') }}"><i class="lni-pencil-alt"></i> За търговци</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-menu" data-logo="{{ asset('images/frontend_images/logo-mobile.png') }}"></div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Area Start -->
    <div id="hero-area-index">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-9 col-xs-12 text-center">
                    <div class="contents">
                        <h1 class="head-title"><a href="{{ route('index') }}"><img src="{{ asset('images/backend_images/logo.png') }}" alt="Logo" /></a></h1>
                        <h5 style="color:#333333;">Всичко за твоето парти на едно място</h5>
                        <div class="search-bar">
                            <div class="search-inner">
                                <form enctype="multipart/form-data" class="search-form" action="{{ route('products') }}" method="post" name="filter_products" id="filter_products" novalidate="novalidate">
                                @csrf
                                    <div class="form-group">
                                        <input type="text" id="custom_search" name="custom_search" class="form-control" placeholder="Въведете търсената дума?">
                                    </div>
                                    <div class="form-group inputwithicon">
                                        <div class="select" id="city_id_search">
                                            <select>
                                                <option value="0">Избери област</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <i class="lni-target"></i>
                                    </div>
                                    <div class="form-group inputwithicon">
                                        <div class="select">
                                            <select id="category_id_search">
                                                <option value='0'>Избери категория</option>
                                                @foreach ($categories_top as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <i class="lni-menu"></i>
                                    </div>
                                    <button class="btn btn-common" type="button" id="btn_search_form"><i class="lni-search"></i> Намери</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->

</header>
<!-- Header Area wrapper End -->
