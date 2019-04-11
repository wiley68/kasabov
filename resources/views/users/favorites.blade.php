<?php use App\Category; ?>
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
                                <a href="#"><img src="{{ asset('images/frontend_images/author/img1.jpg') }}" alt=""></a>
                            </figure>
                            <div class="usercontent">
                                <h3>Здравейте {{ Auth::user()->name }}!</h3>
                                <h4>Потребител</h4>
                            </div>
                        </div>
                        <nav class="navdashboard">
                            <ul>
                                <li>
                                    <a href="{{ route('home') }}">
                                        <i class="lni-dashboard"></i><span>Панел управление</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-settings') }}">
                                        <i class="lni-cog"></i><span>Настройки профил</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-adds') }}">
                                        <i class="lni-layers"></i><span>Моите потъчки</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="active" href="{{ route('home-favorites') }}">
                                        <i class="lni-heart"></i><span>Любими</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-privacy') }}">
                                        <i class="lni-star"></i><span>Лични настройки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout-front-user') }}">
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
                            <h2 class="dashbord-title">Моите любими</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <nav class="nav-table">
                                <ul>
                                    <li class="active"><a href="{{ route('home-favorites') }}">Любими ({{ $products->count() }})</a></li>
                                </ul>
                            </nav>
                            <table class="table table-responsive dashboardtable tablemyads">
                                <thead>
                                    <tr>
                                        <th>Снимка</th>
                                        <th>Продукт</th>
                                        <th>Категория</th>
                                        <th>Състояние</th>
                                        <th>Цена</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr data-category="active">
                                            <td class="photo"><img class="img-fluid" src="{{ asset('/images/backend_images/products/small/'.$product->image) }}" alt=""></td>
                                            <td data-title="Продукт">
                                                <h3>{{ $product->product_name }}</h3>
                                                <span>КОД: {{ $product->product_code }}</span>
                                            </td>
                                            @php
                                                $category_ids = [];
                                                $category_ids[] = $product->category_id;
                                            @endphp
                                            <td data-title="Категория"><span class="adcategories">{{ Category::where(['id'=>$product->category_id])->first()->name }}</span></td>
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
                                                    <a class="btn-action btn-view" href="{{ route('product', ['id'=>$product->product_code]) }}" title="Покажи продукта"><i class="lni-eye"></i></a>
                                                    <a class="btn-action btn-delete" href="{{ route('favorite-delete', ['product_id'=>$product->id, 'user_id'=>Auth::user()->id]) }}" title="Изтрий този продукт от Любими"><i class="lni-trash"></i></a>
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
