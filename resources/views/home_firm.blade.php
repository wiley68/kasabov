<?php use App\Favorite; ?>
<?php use App\Order; ?>
<?php use App\Product; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
                <aside>
                    <div class="sidebar-box">
                        <div class="user">
                            <figure>
                                <img src="{{ asset('/images/backend_images/users/'.$user->image) }}" alt="">
                            </figure>
                            <div class="usercontent">
                                <h3>Здравейте {{ Auth::user()->name }}!</h3>
                                <h4>Търговец</h4>
                            </div>
                        </div>
                        <nav class="navdashboard">
                            <ul>
                                <li>
                                    <a class="active" href="{{ route('home-firm') }}">
                                        <i class="lni-dashboard"></i><span>Панел управление</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-settings') }}">
                                        <i class="lni-cog"></i><span>Настройки профил</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-adds') }}">
                                        <i class="lni-layers"></i><span>Моите оферти</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-orders') }}">
                                        <i class="lni-heart"></i><span>Поръчки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-payments') }}">
                                        <i class="lni-star"></i><span>Плащания</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-privacy') }}">
                                        <i class="lni-star"></i><span>Лични</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout-front-firm') }}">
                                        <i class="lni-enter"></i><span>Изход</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="widget">
                        <h4 class="widget-title">Advertisement</h4>
                        <div class="add-box">
                            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
                        </div>
                    </div>
                </aside>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="page-content">
                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Панел управление</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <div class="dashboard-sections">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-write"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-firm-adds') }}">Общо оферти</a></h2>
                                                <h3>{{ Product::where(['user_id'=>Auth::user()->id])->count() }} бр.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-add-files"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-firm-payments') }}">Платени оферти</a></h2>
                                                <h3>{{ Product::where(['user_id'=>Auth::user()->id, 'featured'=>1])->count()
                                                    }} бр.</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-support"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-firm-orders') }}">Поръчки</a></h2>
                                                @php $products_ids = []; $products = Product::where(['user_id'=>Auth::user()->id])->get(); foreach ($products as $product)
                                                { $products_ids[] = $product->id; }
                                                @endphp
                                                <h3>{{ Order::whereIn('product_id', $products_ids)->count() }} бр.</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-responsive dashboardtable tablemyads">
                                <thead>
                                    <tr>
                                        <th>Снимка</th>
                                        <th>Оферта</th>
                                        <th>Платен</th>
                                        <th>Състояние</th>
                                        <th>Цена</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        @php
                                        if(!empty($product->image)){
                                            $image = asset('/images/backend_images/products/small/'.$product->image);
                                        }else{
                                            $image = asset('/images/backend_images/products/small/no-image-300.png');
                                        }
                                        @endphp
                                        <tr data-category="active">
                                            <td class="Снимка"><img class="img-fluid" src="{{ $image }}" alt=""></td>
                                            <td data-title="Оферта">
                                                <h3>{{ $product->product_name }}</h3>
                                                <span>КОД: {{ $product->product_code }}</span>
                                            </td>
                                            @php
                                                switch ($product->featured) {
                                                    case 1:
                                                        $featured = 'adstatusactive';
                                                        $featured_txt = 'Да';
                                                        break;
                                                    case 'featured':
                                                        $featured = 'adstatusinactive';
                                                        $featured_txt = 'Не';
                                                        break;
                                                    default:
                                                        $featured = 'adstatusinactive';
                                                        $featured_txt = 'Не';
                                                        break;
                                                }
                                            @endphp
                                            <td data-title="Платен"><span class="adstatus {{ $featured }}">{{ $featured_txt }}</span></td>
                                            @php
                                                switch ($product->status) {
                                                    case 'active':
                                                        $status = 'adstatusactive';
                                                        $status_txt = 'Акт.';
                                                        break;
                                                    case 'notactive':
                                                        $status = 'adstatusinactive';
                                                        $status_txt = 'Неакт.';
                                                        break;
                                                    case 'sold':
                                                        $status = 'adstatussold';
                                                        $status_txt = 'Прод.';
                                                        break;
                                                    case 'expired':
                                                        $status = 'adstatusexpired';
                                                        $status_txt = 'Проср.';
                                                        break;
                                                    default:
                                                        $status = 'adstatusactive';
                                                        $status_txt = 'Акт.';
                                                        break;
                                                }
                                            @endphp
                                            <td data-title="Състояние"><span class="adstatus {{ $status }}">{{ $status_txt }}</span></td>
                                            <td data-title="Цена"><h3>{{ number_format($product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</h3></td>
                                            <td data-title="Action">
                                                <div class="btns-actions">
                                                    <a class="btn-action btn-view" href="{{ route('product', ['id'=>$product->product_code]) }}" title="Покажи офертата"><i class="lni-eye"></i></a>
                                                    <a class="btn-action btn-edit" href="#" title="Редактирай офертата"><i class="lni-pencil"></i></a>
                                                    <a class="btn-action btn-delete" href="#" title="Изтрий офертата"><i class="lni-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
