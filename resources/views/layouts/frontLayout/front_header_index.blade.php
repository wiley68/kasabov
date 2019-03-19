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
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Всички празници ...<i class="lni-chevron-down"></i>
                            </a>
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
                    <div class="contents">
                        <h1 class="head-title">Добре дошли в <span class="year">PartyBox</span></h1>
                        <p>Някакъв надпис , който да посреща потребителите ... Някакъв надпис , който да посреща потребителите ... </p>
                        <div class="search-bar">
                            <div class="search-inner">
                                <form class="search-form">
                                    <div class="form-group">
                                        <input type="text" name="customword" class="form-control" placeholder="Въведете търсената дума?">
                                    </div>
                                    <div class="form-group inputwithicon">
                                        <div class="select">
                                            <select>
                                                <option value="0">Избери населено място</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->city }}&nbsp;--&nbsp;{{ $city->oblast }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <i class="lni-target"></i>
                                    </div>
                                    <div class="form-group inputwithicon">
                                        <div class="select">
                                            <select>
                                                <option value="0">Избери категория</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <i class="lni-menu"></i>
                                    </div>
                                    <button class="btn btn-common" type="button"><i class="lni-search"></i> Покажи резултата</button>
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
