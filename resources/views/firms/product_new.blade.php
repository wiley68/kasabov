<?php use App\Category; ?>
<?php use App\Holiday; ?>
<?php use App\City; ?>
<?php use App\ProductsCity; ?>
<?php use App\Tag; ?>
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
                                    <a href="{{ route('home-firm') }}">
                                        <i class="lni-dashboard"></i><span>Панел управление</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-settings') }}">
                                        <i class="lni-cog"></i><span>Настройки профил</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="active" href="{{ route('home-firm-adds', ['payed' => 'No']) }}">
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
                        @if (Session::has('flash_message_error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_error') !!}</strong>
                        </div>
                        @endif
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Създаване на нова Оферта</h2>
                        </div>
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-firm-product-new', ['id'=>$product->id]) }}"
                            name="home_firm_product_edit" id="home_firm_product_edit" novalidate="novalidate">
                            @csrf
                            <input type="hidden" id="product_id" value="{{ $product->id }}">
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
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Описание на продукта</label>
                                    <textarea name="description" id="description" style="width:100%;" class="span12" rows="5">{!! $product->description !!}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="control-label">Заглавна снимка</label>
                                    <input type="file" name="image" id="image">
                                    <input type="hidden" name="current_image" id="current_image" value="{{ $product->image }}">
                                    @if (!empty($product->image))
                                    <a href="#imageModal" data-toggle="modal" title="Покажи снимката в голям размер.">
                                        <img style="width:50px;" src="{{ asset('/images/backend_images/products/small/'.$product->image) }}">
                                    </a> |
                                    <button onclick="deleteProductImage('{{ route('home-delete-product-image', ['id' => $product->id]) }}'); return false;" class="btn btn-danger">Изтрий снимката</button>
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
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Изпраща се от</label>
                                    <select name="send_from_id" id="send_from_id" style="width:100%;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if ($city->id === $product->send_from_id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Цена на изпращане</label>
                                    <input name="price_send" style="width:100%;" type="number" value="{{ $product->price_send }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Безплатна доставка</label>
                                    <select name="send_free" id="send_free" style="width:100%;">
                                        <option value=1 @if ($product->send_free === 1) selected @endif>Да</option>
                                        <option value=0 @if ($product->send_free === 0) selected @endif>Не</option>
                                    </select>
                                </div>
                                <div id="send_free_div" class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Важи за</label>
                                    <select name="send_free_id" id="send_free_id" style="width:100%;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if ($city->id === $product->send_free_id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Доставя за</label>
                                    <select name="available_for" id="available_for" style="width:100%;">
                                        <option value="country" @if ($product->available_for === 'country') selected @endif>Цялата страна</option>
                                        <option value="city" @if ($product->available_for === 'city') selected @endif>Населено място</option>
                                        <option value="cities" @if ($product->available_for === 'cities') selected @endif>Населени места</option>
                                        <option value="area" @if ($product->available_for === 'area') selected @endif>Област</option>
                                    </select>
                                </div>
                                <div id="available_for_city_div" class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Избери</label>
                                    <select name="available_for_city" id="available_for_city" style="width:100%;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if ($city->id === $product->available_for_city) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="available_for_oblast_div" class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Избери</label>
                                    <select name="available_for_oblast" id="available_for_oblast" style="width:100%;">
                                        <option value="0" selected>Избери Област</option>
                                        @foreach ($oblasti as $oblast)
                                            <option value="{{ $oblast->id }}" @if ($oblast->id === $product->available_for_city) selected @endif>{{ $oblast->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="available_for_cities_div" class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Избери</label>
                                    <select multiple name="available_for_cities[ ]" id="available_for_cities" style="width:100%;">
                                        @foreach ($cities as $city)
                                            @php
                                                $city_arr = [];
                                                foreach (ProductsCity::where(['product_id'=>$product->id])->get() as $product_city) {
                                                    $city_arr[] = $product_city->city_id;
                                                }
                                            @endphp
                                            <option value="{{ $city->id }}" @if (in_array($city->id, $city_arr)) selected @endif>{{ $city->city }}&nbsp;--&nbsp;{{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Може да се вземе от обект</label>
                                    <select name="object" id="object" style="width:100%;">
                                        <option value=0 @if ($product->object === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->object === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Адрес на обекта</label>
                                    <input name="object_name" type="text" style="width:100%;" value="{{ $product->object_name }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Възможност за персонализиране</label>
                                    <select name="personalize" id="personalize" style="width:100%;">
                                        <option value=0 @if ($product->personalize === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->personalize === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Статус</label>
                                    <select name="status" id="status" style="width:100%;">
                                        <option value='active' @if ($product->status === 'active') selected @endif>Активен</option>
                                        <option value='notactive' @if ($product->status === 'notactive') selected @endif>Неактивен</option>
                                        <option value='sold' @if ($product->status === 'sold') selected @endif>Продаден</option>
                                        <option value='expired' @if ($product->status === 'expired') selected @endif>Изтекъл</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Промоционален</label>
                                    <select name="featured" id="featured" style="width:100%;">
                                        <option value=0 @if ($product->featured === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->featured === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                                <hr />
                                <div class="form-group mb-3">
                                    <p>Етикети</p>
                                    <div style="width:100%;">
                                        <input type="text" name="tag_add" id="tag_add">
                                        <button id="btn_add_tag" class="btn btn-primary">Добави етикета</button>
                                        <div style="padding-top: 10px;" id="div_tags"></div>
                                    </div>
                                </div>
                                <hr />
                                <button class="btn btn-common" type="submit">Запиши промените</button>
                            </div>
                        </form>
                        <div id="imageModal" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $product->product_name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p><img src="{{ asset('/images/backend_images/products/medium/'.$product->image) }}"></p>
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

@section('scripts')
    <script>
        // Hide send_free_div
        function hideSendFree(){
            switch (parseInt($('#send_free').val())) {
                case 1:
                    $('#send_free_div').show();
                    break;
                case 0:
                    $('#send_free_div').hide();
                    break;
                default:
                    $('#send_free_div').hide();
                    break;
            }
        }
        // Hide all chooses
        function hideAll(){
            switch ($('#available_for').val()) {
                case 'country':
                    $('#available_for_city_div').hide();
                    $('#available_for_oblast_div').hide();
                    $('#available_for_cities_div').hide();
                    break;
                case 'city':
                    $('#available_for_oblast_div').hide();
                    $('#available_for_cities_div').hide();
                    $('#available_for_city_div').show();
                    break;
                case 'cities':
                    $('#available_for_city_div').hide();
                    $('#available_for_oblast_div').hide();
                    $('#available_for_cities_div').show();
                    break;
                case 'area':
                    $('#available_for_city_div').hide();
                    $('#available_for_cities_div').hide();
                    $('#available_for_oblast_div').show();
                    break;
                default:
                    $('#available_for_city_div').hide();
                    $('#available_for_oblast_div').hide();
                    $('#available_for_cities_div').hide();
                    break;
            }
        }
        hideAll();
        hideSendFree();
        $('#available_for').change(function(){
            switch ($(this).val()) {
                case 'country':
                    hideAll();
                    break;
                case 'city':
                    hideAll();
                    $('#available_for_city_div').show();
                    break;
                case 'cities':
                    hideAll();
                    $('#available_for_cities_div').show();
                    break;
                case 'area':
                    hideAll();
                    $('#available_for_oblast_div').show();
                    break;
                default:
                    hideAll();
                    break;
            }
        });
        $('#send_free').change(function(){
            hideSendFree();
        });

        // Add tags
        function isNullOrWhitespace( input ) {
            if (typeof input === 'undefined' || input == null) return true;
            return input.replace(/\s/g, '').length < 1;
        }
        function removeTag(item){
            // Remove tag from products_tags table by ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.delete-products-tags') }}",
                method: 'post',
                data: {
                    name: $('div:first', item.parentElement).text(),
                    product_id: '{{ $product->id }}'
                },
                success: function(result){
                    if (result === 'Yes'){
                        item.parentElement.remove();
                    }
                }
            });
        };
        $('#btn_add_tag').click(function(e){
            e.preventDefault();
            const divTags = document.getElementById('div_tags');
            const tagAdd = document.getElementById('tag_add');
            if (!isNullOrWhitespace(tagAdd.value)){
                divTags.innerHTML += '<div><div class="badge badge-success" style="padding:5px;font-size:14px;">'+tagAdd.value+'</div><input type="hidden" name="tags[]" value="'+tagAdd.value+'"> <span onclick="removeTag(this);" style="color:red;cursor:pointer;">Изтрий</span></div>';
                tagAdd.value = '';
            }
        });
    </script>
@stop
