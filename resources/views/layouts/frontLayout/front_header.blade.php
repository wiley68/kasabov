<?php use App\Holiday; ?>
<?php use App\Category; ?>
<!-- Header Area wrapper Starts -->
<header id="header-wrap">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
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
                                @if(request('filter') == 'yes')
                                    <a href="{{ route('products') }}">Всички продукти</a>
                                    <i class="fas fa-chevron-right"></i>
                                    @if(!empty(request('holiday_id')))
                                        <a href="{{ route('products', ['filter'=>'yes', 'holiday_id'=>request('holiday_id')]) }}">{{ Holiday::where(['id'=>request('holiday_id')])->first()->name }}</a>
                                        @if(!empty(request('category_id')))
                                            <i class="fas fa-chevron-right"></i>
                                        @endif
                                    @endif
                                    @if(!empty(request('category_id')))
                                        <a href="{{ route('products', ['filter'=>'yes', 'category_id'=>request('category_id')]) }}">{{ Category::where(['id'=>request('category_id')])->first()->name }}</a>
                                    @endif
                                @else
                                    <a href="{{ route('products') }}">Всички продукти</a>
                                @endif
                            @elseif(Route::current()->getName() == 'product')
                            <a href="{{ route('products') }}">Всички продукти</a>
                            <i class="fas fa-chevron-right"></i>
                            <a href="{{ route('product', ['id'=>$product->id]) }}">{{ $product->product_name }}</a>
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
