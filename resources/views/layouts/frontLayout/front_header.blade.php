<?php use App\Holiday; ?>
<?php use App\Category; ?>
<?php use App\User; ?>
<!-- Header Area wrapper Starts -->
<header id="header-wrap">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar" style="background: #333333;">
        <div class="container">
            <div class="theme-header clearfix">
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="navbar-nav mr-auto w-100 justify-content-left">
                        @for ($i = 0; $i < 5; $i++)
                        <li class="nav-item dropdown">
                            @php
                                $holiday_ids = [];
                                $holiday_ids[] = $holidays[$i]->id;
                            @endphp
                            <a class="nav-link dropdown-toggle" href="{{ route('products', ['holiday_id'=>$holiday_ids]) }}" aria-haspopup="true" aria-expanded="false">
                                {{ $holidays[$i]->name }}<i class="lni-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach (Holiday::where(['parent_id'=>$holidays[$i]->id])->get() as $item)
                                @php
                                    $item_ids = [];
                                    $item_ids[] = $item->id;
                                @endphp
                                <li><a class="dropdown-item" href="{{ route('products', ['holiday_id'=>$item_ids]) }}">{{ $item->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endfor
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
                        <a class="btn btn-common" href="{{ route('firms-login-register') }}"><i class="lni-pencil-alt"></i> Вход за търговци</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-menu" data-logo="{{ asset('images/frontend_images/logo-mobile.png') }}"></div>
        <div class="login_mobile">
            @guest
            <div>
                <a href="{{ route('users-login-register') }}"><i class="lni-lock"></i> Вход | Регистрация</a>
            </div>
            @else
            <div>
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
            <div>
                <a href="{{ route('firms-login-register') }}"><i class="lni-pencil-alt"></i> Вход за търговци</a>
            </div>
        </div>
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
                            <a href="{{ route('index') }}" style="color:dimgray;">Начало</a>
                            <i class="fas fa-chevron-right" style="color:dimgray;"></i>
                            @if(Route::current()->getName() == 'products')
                                @if(request('filter') == 'yes')
                                    <a href="{{ route('products') }}" style="color:dimgray;">Всички продукти</a>
                                    <i class="fas fa-chevron-right" style="color:dimgray;"></i>
                                    @if(!empty(request('holiday_id')))
                                        <a href="{{ route('products', ['filter'=>'yes', 'holiday_id'=>request('holiday_id')]) }}">{{ Holiday::where(['id'=>request('holiday_id')])->first()->name }}</a>
                                        @if(!empty(request('category_id')))
                                            <i class="fas fa-chevron-right" style="color:dimgray;"></i>
                                        @endif
                                    @endif
                                    @if(!empty(request('category_id')))
                                        <a href="{{ route('products', ['filter'=>'yes', 'category_id'=>request('category_id')]) }}">{{ Category::where(['id'=>request('category_id')])->first()->name }}</a>
                                    @endif
                                @else
                                    @if(!empty(request('user_id')) && request('user_id') != 0)
                                    <a href="{{ route('products', ['user_id'=>request('user_id')]) }}" style="color:dimgray;">Всички продукти на {{ User::where(['id'=>request('user_id')])->first()->name}}</a>
                                    @else
                                    @php
                                        $current_category_id = empty(request('category_id')) ? 0 : request('category_id');
                                        if (!empty(Category::where(['id'=>$current_category_id])->first())){
                                            $current_parent_category_id[0] = Category::where(['id'=>$current_category_id])->first()->parent_id;
                                        }else{
                                            $current_parent_category_id[0] = 0;
                                        }
                                    @endphp
                                    @if ($current_parent_category_id[0] > 0)
                                    <a href="{{ route('products', ['category_id'=>$current_parent_category_id]) }}" style="color:dimgray;">{{ Category::where(['id'=>$current_parent_category_id[0]])->first()->name }}</a>
                                    <i class="fas fa-chevron-right" style="color:dimgray;"></i>                                        
                                    @endif
                                    @if ($current_category_id > 0)
                                    <a href="{{ route('products', ['category_id'=>$current_category_id]) }}" style="color:dimgray;">{{ Category::where(['id'=>$current_category_id])->first()->name }}</a>
                                    @endif
                                    @endif
                                @endif
                            @elseif(Route::current()->getName() == 'product')
                            <a href="{{ route('products') }}" style="color:dimgray;">Всички продукти</a>
                            <i class="fas fa-chevron-right" style="color:dimgray;"></i>
                            <a href="{{ route('product', ['id'=>$product->product_code]) }}" style="color:dimgray;">{{ $product->product_name }}</a>
                            @elseif(Route::current()->getName() == 'users-login-register')
                            <a href="{{ route('users-login-register') }}" style="color:dimgray;">Регистрация на клиент</a>
                            @elseif(Route::current()->getName() == 'firms-login-register')
                            <a href="{{ route('firms-login-register') }}" style="color:dimgray;">Регистрация на търговец</a>
                            @elseif(
                                Route::current()->getName() == 'home' ||
                                Route::current()->getName() == 'home-settings' ||
                                Route::current()->getName() == 'home-favorites' ||
                                Route::current()->getName() == 'home-adds' ||
                                Route::current()->getName() == 'home-privacy'
                            )
                            <a href="{{ route('home') }}" style="color:dimgray;">Панел управление</a>
                            @elseif(
                                Route::current()->getName() == 'home-firm' ||
                                Route::current()->getName() == 'home-firm-settings' ||
                                Route::current()->getName() == 'home-firm-adds' ||
                                Route::current()->getName() == 'home-firm-orders' ||
                                Route::current()->getName() == 'home-firm-privacy' ||
                                Route::current()->getName() == 'home-firm-product-edit' || 
                                Route::current()->getName() == 'home-firm-payments'
                            )
                            <a href="{{ route('home-firm') }}" style="color:dimgray;">Панел управление</a>
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->
    @if (!empty($errors) && $errors->any())
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
</header>
<!-- Header Area wrapper End -->
