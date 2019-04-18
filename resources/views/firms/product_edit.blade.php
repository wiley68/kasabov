<?php use App\Category; ?>
<?php use App\Holiday; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<script type="text/javascript">
    function deleteProductImage(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита снимката за този продукт. Операцията е невъзвратима!",
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
                                        <i class="lni-envelope"></i><span>Поръчки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-payments') }}">
                                        <i class="lni-wallet"></i><span>Плащания</span>
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
                        @if (Session::has('flash_message_success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_success') !!}</strong>
                        </div>
                        @endif
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Оферта: {{ $product->product_name }}</h2>
                        </div>
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-firm-product-edit', ['id'=>$product->id]) }}" name="home_firm_product_edit"
                            id="home_firm_product_edit" novalidate="novalidate">
                            @csrf
                            <div class="dashboard-wrapper">
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="color:red;width:200px;">Категория *</label>
                                    <select name="category_id" id="category_id" style="width:100%;">
                                        <option value="0" @if($product->category_id == 0) selected @endif>Избери категория</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id === $product->category_id) selected @endif>{{ $category->name }}</option>
                                            @foreach (Category::where(['parent_id'=>$category->id])->get() as $item)
                                            <option value="{{ $item->id }}" @if ($item->id === $product->category_id) selected @endif>&nbsp;--&nbsp;{{ $item->name }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Празник</label>
                                    <select name="holiday_id" id="holiday_id" style="width:100%;">
                                        <option value="0" @if (0 === $product->holiday_id) selected @endif selected>Избери празник</option>
                                        @foreach ($holidays as $holiday)
                                        <option value="{{ $holiday->id }}" @if ($holiday->id === $product->holiday_id) selected @endif>{{ $holiday->name }}</option>
                                            @foreach (Holiday::where(['parent_id'=>$holiday->id])->get() as $item)
                                            <option value="{{ $item->id }}" @if ($item->id === $product->holiday_id) selected @endif>&nbsp;--&nbsp;{{ $item->name }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="color:red;width:200px;">Продукт *</label>
                                    <input name="product_name" type="text" style="width:100%;" value="{{ $product->product_name }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="color:red;width:200px;">Код *</label>
                                    <input name="product_code" style="width:100%;" type="text" value="{{ $product->product_code }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Количество</label>
                                    <input name="quantity" style="width:100%;" type="number" value="{{ $product->quantity }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="color:red;width:200px;">Цена *</label>
                                    <input name="price" style="width:100%;" type="number" value="{{ $product->price }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="control-label">Снимка</label>
                                    <input type="file" name="image" id="image">
                                    <input type="hidden" name="current_image" id="current_image" value="{{ $product->image }}">
                                    @if (!empty($product->image))
                                        <a href="#imageModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/products/small/'.$product->image) }}"></a> | <button onclick="deleteProductImage('{{ route('home-delete-product-image', ['id' => $product->id]) }}');" class="btn btn-danger">Изтрий снимката</button>
                                    @endif
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Основен цвят</label>
                                    <select name="first_color" id="first_color" style="width:100%;">
                                        <option value="white" @if($product->first_color == 'white') selected @endif>Бял</option>
                                        <option value="gray" @if($product->first_color == 'gray') selected @endif>Сив</option>
                                        <option value="black" @if($product->first_color == 'black') selected @endif>Черен</option>
                                        <option value="red" @if($product->first_color == 'red') selected @endif>Червен</option>
                                        <option value="yellow" @if($product->first_color == 'yellow') selected @endif>Жълт</option>
                                        <option value="green" @if($product->first_color == 'green') selected @endif>Зелен</option>
                                        <option value="blue" @if($product->first_color == 'blue') selected @endif>Син</option>
                                        <option value="brown" @if($product->first_color == 'brown') selected @endif>Кафяв</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Втори цвят</label>
                                    <select name="second_color" id="second_color" style="width:100%;">
                                        <option value="white" @if($product->second_color == 'white') selected @endif>Бял</option>
                                        <option value="gray" @if($product->second_color == 'gray') selected @endif>Сив</option>
                                        <option value="black" @if($product->second_color == 'black') selected @endif>Черен</option>
                                        <option value="red" @if($product->second_color == 'red') selected @endif>Червен</option>
                                        <option value="yellow" @if($product->second_color == 'yellow') selected @endif>Жълт</option>
                                        <option value="green" @if($product->second_color == 'green') selected @endif>Зелен</option>
                                        <option value="blue" @if($product->second_color == 'blue') selected @endif>Син</option>
                                        <option value="brown" @if($product->second_color == 'brown') selected @endif>Кафяв</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Възрастова група</label>
                                    <select name="age" id="age" style="width:100%;">
                                        <option value="any" @if ($product->age === 'age') selected @endif>Без значение</option>
                                        <option value="child" @if ($product->age === 'child') selected @endif>За деца</option>
                                        <option value="adult" @if ($product->age === 'adult') selected @endif>За възрастни</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Пол</label>
                                    <select name="pol" id="pol" style="width:100%;">
                                        <option value="any" @if ($product->pol === 'any') selected @endif>Без значение</option>
                                        <option value="man" @if ($product->pol === 'man') selected @endif>За мъже</option>
                                        <option value="woman" @if ($product->pol === 'woman') selected @endif>За жени</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Състояние</label>
                                    <select name="condition" id="condition" style="width:100%;">
                                        <option value="new" @if ($product->condition === 'new') selected @endif>Нов</option>
                                        <option value="old" @if ($product->condition === 'old') selected @endif>Употребяван</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Изпраща се с</label>
                                    <select name="send_id" id="send_id" style="width:100%;">
                                        <option value="0" selected>Избери доставчик</option>
                                        @foreach ($speditors as $speditor)
                                            <option value="{{ $speditor->id }}" @if ($speditor->id === $product->send_id) selected @endif>{{ $speditor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr />
                                <button class="btn btn-common" type="submit">Запиши промените</button>
                            </div>
                        </form>
                        <div id="imageModal" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $product->product_name }}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p><img src="{{ asset('/images/backend_images/products/large/'.$product->image) }}"></p>
                                    </div>
                                    <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
