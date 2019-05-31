<?php use App\Product; ?>
<?php use App\User; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<!-- Start Content -->
<script type="text/javascript">
    function deleteAdd(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита поръчката. Операцията е невъзвратима!",
            icon: "warning",
            buttons: ["Отказ!", "Съгласен съм!"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            window.location = url;
        } else {
            return false;
        }
        });
        return false;
    };

</script>
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
                                    <a class="active" href="{{ route('home-adds') }}">
                                        <i class="lni-layers"></i><span>Моите поръчки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-favorites') }}">
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
                            <h2 class="dashbord-title">Моите потъчки</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <div class="dashboardboxtitle">
                                <h2>Поръчки</h2>
                            </div>
                            <table class="table table-responsive dashboardtable tablemyads">
                                <thead>
                                    <tr>
                                        <th>Снимка</th>
                                        <th>Продукт</th>
                                        <th>Собственик</th>
                                        <th>Цена</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        @php
                                        $product = Product::where(['id'=>$order->product_id])->first();
                                        if(!empty($product->image)){
                                            $image = asset('/images/backend_images/products/small/'.$product->image);
                                        }else{
                                            $image = asset('/images/backend_images/products/small/no-image-300.png');
                                        }
                                        @endphp
                                        <tr>
                                            <td class="photo"><a href="#imageModal{{ $product->id }}" data-toggle="modal" title="Покажи снимката в голям размер."><img class="img-fluid" src="{{ $image }}" alt=""></a></td>
                                            <td data-title="Продукт">
                                                <h3>{{ $product->product_name }}</h3>
                                                <span>КОД: {{ $product->product_code }}</span>
                                            </td>
                                            <td data-title="Собственик"><span class="adcategories">{{ User::where(['id'=>$product->user_id])->first()->name }}</span></td>
                                            <td data-title="Цена">
                                                <h3>{{ number_format($product->price, 2, '.', '') }}{{ Config::get('settings.currency') }}</h3>
                                            </td>
                                            <td>
                                                <div class="btns-actions">
                                                    <a target="_blank" class="btn-action btn-view" href="{{ route('product', ['id'=>$product->product_code]) }}" title="Покажи продукта"><i class="lni-eye"></i></a>
                                                    <a style="cursor:pointer;" class="btn-action btn-delete" onclick="deleteAdd('{{ route('delete-order', ['id'=>$order->id]) }}');" title="Изтрий тази поръчка"><i class="lni-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <p><strong>Дата на създаване</strong>: {{ date("d.m.Y H:i:s", strtotime($order->created_at)) }}</p>
                                                <p><strong>Съобщение</strong>: {{ $order->message }}</p>
                                                <p><strong>Email</strong>: {{ $order->email }}</p>
                                                <p><strong>Телефон</strong>: {{ $order->phone }}</p>
                                            </td>
                                        </tr>
                                        <div id="imageModal{{ $product->id }}" class="modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $product->product_name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><img src="{{ asset('/images/backend_images/products/medium/'.$product->image) }}"></p>
                                                    </div>
                                                    <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Затвори</button></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr />
                <!-- Start Pagination -->
                {{ $orders->links() }}
                <!-- End Pagination -->
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
