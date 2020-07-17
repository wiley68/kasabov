<?php

use App\Category; ?>
<?php

use App\Holiday; ?>
<?php

use App\City; ?>
<?php

use App\ProductsCity; ?>
<?php

use App\Tag; ?>
<?php use App\Order; ?>
<?php use App\Product; ?>
@extends('layouts.frontLayout.front_design')
@section('content')
<script type="text/javascript">
    function deleteProductImage(url) {
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
                            @if ($user->image != null)
                            <figure>
                                <img src="{{ asset('/images/backend_images/users/'.$user->image) }}" alt="">
                            </figure>
                            @endif
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
                                        @php
                                        $products_ids = [];
                                        $products_loc = Product::where(['user_id'=>Auth::user()->id])->get();
                                        foreach ($products_loc as $prod){
                                        $products_ids[] = $prod->id;
                                        }

                                        $order_count = Order::whereIn('product_id', $products_ids)->where(['status'=>'unread'])->count();
                                        @endphp
                                        @if($order_count == 0)
                                        <span style="float:right;padding-right:10px;">
                                            <p>{{ $order_count }} бр.</p>
                                        </span>
                                        @else
                                        <span style="float:right;padding-right:10px;">
                                            <p class="order_blink">{{ $order_count }} бр.</p>
                                        </span>
                                        @endif
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
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-firm-product-new', ['id'=>$product->id]) }}" name="home_firm_product_edit" id="home_firm_product_edit" novalidate="novalidate">
                            @csrf
                            <input type="hidden" id="product_id" value="{{ $product->id }}">
                            <div class="dashboard-wrapper">
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Избери главна категория, в която да бъде публикувана тази оферта"></i></span>&nbsp;
                                    <label style="color:red;width:200px;">Главна категория *</label>
                                    <select name="category_root_id" id="category_root_id" style="width:100%;">
                                        <option value="0">Избери категория</option>
                                        @foreach ($categories as $category)
                                            @php
                                                if($product->category_id){
                                                    $parent_category_id = Category::where(['id'=>$product->category_id])->first()->parent_id;
                                            @endphp
                                            <option value="{{ $category->id }}" @if ($category->id == $parent_category_id) selected @endif>{{ $category->name }}</option>
                                            @php
                                                }else{ 
                                            @endphp
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @php
                                                }
                                            @endphp
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Избери категория, в която да бъде публикувана тази оферта"></i></span>&nbsp;
                                    <label style="color:red;width:200px;">Категория *</label>
                                    <select name="category_id" id="category_id" style="width:100%;">
                                        <option value="0">Избери категория</option>
                                        @php
                                            if($product->category_id){
                                            $parent_category_id = Category::where(['id'=>$product->category_id])->first()->parent_id;
                                            $sub_category = Category::where(['parent_id'=>$parent_category_id])->get();
                                        @endphp
                                        @foreach ($sub_category as $category)
                                            <option value="{{ $category->id }}" @if ($category->id == $product->category_id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                        @php
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle"></i></span>&nbsp;
                                    <label style="width:200px;">Празник</label>
                                    <select name="holiday_id" id="holiday_id" style="width:100%;">
                                        <option value="0" @if (0===$product->holiday_id) selected @endif selected>Избери празник</option>
                                        @foreach ($holidays as $holiday)
                                        <option value="{{ $holiday->id }}" @if ($holiday->id === $product->holiday_id) selected @endif>{{ $holiday->name }}</option>
                                        @foreach (Holiday::where(['parent_id'=>$holiday->id])->get() as $item)
                                        <option value="{{ $item->id }}" @if ($item->id === $product->holiday_id) selected @endif>&nbsp;--&nbsp;{{ $item->name }}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Създай точно и ясно заглавие на офертата"></i></span>&nbsp;
                                    <label style="color:red;width:200px;">Продукт *</label>
                                    <input name="product_name" type="text" style="width:100%;" value="{{ $product->product_name }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Всяка оферта трябва да бъде публикувана с уникален цифрен код"></i></span>&nbsp;
                                    <label style="color:red;width:200px;">Код *</label>
                                    <input name="product_code" style="width:100%;" type="text">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Предложи най-добрата цена за тази оферта"></i></span>&nbsp;
                                    <label style="color:red;width:200px;">Цена *</label>
                                    <input name="price" style="width:100%;" type="number" value="{{ $product->price }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Точно и пълно описание на офертата ще улесни купувачите и ще им помогне да стигнат по-бързо до коръчка"></i></span>&nbsp;
                                    <label style="width:200px;">Описание на продукта</label>
                                    <textarea name="description" id="description" style="width:100%;" class="span12" rows="5">{!! $product->description !!}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Избери най-добрата снимка за твоята оферта. Тя ще се показва в резултатите при търсене и е първото нещо, което ще привлече вниманието на купувачите и ще ги накара да отворят офертата ти"></i></span>&nbsp;
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
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Отбележи за каква възрастова група е подходящ продукта или услугата от тази оферта"></i></span>&nbsp;
                                    <label style="width:200px;">Възрастова група</label>
                                    <select name="age" id="age" style="width:100%;">
                                        <option value="any" @if ($product->age === 'age') selected @endif>Без значение</option>
                                        <option value="child" @if ($product->age === 'child') selected @endif>За деца</option>
                                        <option value="adult" @if ($product->age === 'adult') selected @endif>За възрастни</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Ако предлагаш физически продукт, посочи коя куриерска фирма използваш за доставка"></i></span>&nbsp;
                                    <label style="width:200px;">Изпраща се с</label>
                                    <select name="send_id" id="send_id" style="width:100%;">
                                        <option value="0" selected>Избери доставчик</option>
                                        @foreach ($speditors as $speditor)
                                        <option value="{{ $speditor->id }}" @if ($speditor->id === $product->send_id) selected @endif>{{ $speditor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Ако предлагаш физически продукт, посочи населеното място от което изпращащ"></i></span>&nbsp;
                                    <label style="width:200px;">Изпраща се от</label>
                                    <select name="send_from_id" id="send_from_id" style="width:100%;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" @if ($city->id === $product->send_from_id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Посочи точна или ориентировъчна цена на доставка с куриер"></i></span>&nbsp;
                                    <label style="width:200px;">Цена на доставка</label>
                                    <input name="price_send" style="width:100%;" type="number" value="{{ $product->price_send }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle"></i></span>&nbsp;
                                    <label style="width:200px;">Безплатна доставка</label>
                                    <select name="send_free" id="send_free" style="width:100%;">
                                        <option value=1 @if ($product->send_free === 1) selected @endif>Да</option>
                                        <option value=0 @if ($product->send_free === 0) selected @endif>Не</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Можеш да избереш дали офертата ти да бъде актуална за цялата страна или за конкретна област, едно или няколко населени места"></i></span>&nbsp;
                                    <label style="width:200px;">Офертата важи за</label>
                                    <select name="send_free_available_for" id="send_free_available_for" style="width:100%;">
                                        @php
                                            if($product->category_id){
                                        @endphp
                                        <option value="country" @if ($product->send_free_available_for === 'country') selected @endif>Цялата страна</option>
                                        <option value="city" @if ($product->send_free_available_for === 'city') selected @endif>Населено място</option>
                                        <option value="cities" @if ($product->send_free_available_for === 'cities') selected @endif>Населени места</option>
                                        <option value="area" @if ($product->send_free_available_for === 'area') selected @endif>Област</option>
                                        @php
                                            }else{
                                        @endphp
                                        <option value="country">Цялата страна</option>
                                        <option value="city">Населено място</option>
                                        <option value="cities">Населени места</option>
                                        <option value="area">Област</option>
                                        @php
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div id="send_free_available_for_send_free_id_div" class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle"></i></span>&nbsp;
                                    <label style="width:200px;">Избери</label>
                                    <select name="send_free_id" id="send_free_id" style="width:100%;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                            @if($product->send_free_id)
                                                <option value="{{ $city->id }}" @if ($city->id === $product->send_free_id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                            @else
                                                <option value="{{ $city->id }}">{{ $city->city }} - {{ $city->oblast }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div id="send_free_available_for_oblast_div" class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle"></i></span>&nbsp;
                                    <label style="width:200px;">Избери</label>
                                    <select name="send_free_oblast" id="send_free_oblast" style="width:100%;">
                                        <option value="0" selected>Избери област</option>
                                        @foreach ($cities as $city)
                                        @if($city->city === $city->oblast)
                                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div id="send_free_available_for_cities_div" class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle"></i></span>&nbsp;
                                    <label style="width:200px;">Избери</label>
                                    <select multiple name="send_free_available_for_cities[ ]" id="send_free_available_for_cities" style="width:100%;">>
                                        @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->city }}&nbsp;--&nbsp;{{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Избери тази опция, ако продукта, който предлагаш, може да бъде закупен от физически магазин."></i></span>&nbsp;
                                    <label style="width:200px;">Може да се вземе от обект</label>
                                    <select name="object" id="object" style="width:100%;">
                                        <option value=0 @if ($product->object === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->object === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Адрес на физическия магазин."></i></span>&nbsp;
                                    <label style="width:200px;">Адрес на обекта</label>
                                    <input name="object_name" type="text" style="width:100%;" value="{{ $product->object_name }}">
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="Отбележи дали продуктът или услугата могат да бъдат персонализирани спрямо конкретни изисквания на клиента"></i></span>&nbsp;
                                    <label style="width:200px;">Възможност за персонализиране</label>
                                    <select name="personalize" id="personalize" style="width:100%;">
                                        <option value=0 @if ($product->personalize === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->personalize === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="По всяко време можеш да променяш статуса на своята оферта и да следиш периода за нейната активност"></i></span>&nbsp;
                                    <label style="width:200px;">Статус</label>
                                    <select name="status" id="status" style="width:100%;">
                                        <option value='active' @if ($product->status === 'active') selected @endif>Активен</option>
                                        <option value='notactive' @if ($product->status === 'notactive') selected @endif>Неактивен</option>
                                        <option value='sold' @if ($product->status === 'sold') selected @endif>Продаден</option>
                                        <option value='expired' @if ($product->status === 'expired') selected @endif>Изтекъл</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <span><i class="lni lni-question-circle"></i></span>&nbsp;
                                    <label style="width:200px;">Промоционален</label>
                                    <select name="featured" id="featured" style="width:100%;">
                                        <option value=0 @if ($product->featured === 0) selected @endif>Не</option>
                                        <option value=1 @if ($product->featured === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                                <hr />
                                <div class="form-group mb-3">
                                    <span><i class="lni lni-question-circle" data-toggle="tooltip" data-placement="top" title="За да бъде повече видима и по-лесно откриваема при търсене в търсачката на сайта, твоята оферта е необходимо да притежава етикети (тагове). Използвай кратки думи или словосъчетания, които най-точно описват това, което предлагащ"></i>&nbsp;<p style="display: inline-block">Етикети</p></span>
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

    $( document ).ready(function() {
        switch ($('#send_free_available_for').val()) {
            case 'country':
                hideAllsend_free();
                break;
            case 'city':
                hideAllsend_free();
                $('#send_free_available_for_send_free_id_div').show();
                break;
            case 'cities':
                hideAllsend_free();
                $('#send_free_available_for_cities_div').show();
                break;
            case 'area':
                hideAllsend_free();
                $('#send_free_available_for_oblast_div').show();
                break;
            default:
                hideAllsend_free();
                break;
        }
    });
    // Hide send_free_div
    // Hide all city chooses
    function hideAllsend_free() {
        $('#send_free_available_for_send_free_id_div').hide();
        $('#send_free_available_for_oblast_div').hide();
        $('#send_free_available_for_cities_div').hide();
    }
    hideAllsend_free();
    $('#send_free_available_for').change(function() {
        switch ($(this).val()) {
            case 'country':
                hideAllsend_free();
                break;
            case 'city':
                hideAllsend_free();
                $('#send_free_available_for_send_free_id_div').show();
                break;
            case 'cities':
                hideAllsend_free();
                $('#send_free_available_for_cities_div').show();
                break;
            case 'area':
                hideAllsend_free();
                $('#send_free_available_for_oblast_div').show();
                break;
            default:
                hideAllsend_free();
                break;
        }
    });
    // Add tags
    function isNullOrWhitespace(input) {
        if (typeof input === 'undefined' || input == null) return true;
        return input.replace(/\s/g, '').length < 1;
    }

    function removeTag(item) {
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
            success: function(result) {
                if (result === 'Yes') {
                    item.parentElement.remove();
                }
            }
        });
    };
    $('#btn_add_tag').click(function(e) {
        e.preventDefault();
        const divTags = document.getElementById('div_tags');
        const tagAdd = document.getElementById('tag_add');
        if (!isNullOrWhitespace(tagAdd.value)) {
            divTags.innerHTML += '<div><div class="badge badge-success" style="padding:5px;font-size:14px;">' + tagAdd.value + '</div><input type="hidden" name="tags[]" value="' + tagAdd.value + '"> <span onclick="removeTag(this);" style="color:red;cursor:pointer;">Изтрий</span></div>';
            tagAdd.value = '';
        }
    });
    $('#category_root_id').change(function(e){
        // populate subcategories
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.populate-categories') }}",
            method: 'post',
            data: {
                category_id: $('#category_root_id').val()
            },
            success: function(result){
                var category_select = $('#category_id');
                category_select.empty();
                if (result === 'No'){
                    category_select.append('<option value=0 selected>Избери категория</option>');
                }else{
                    category_select.append('<option value=0 selected>Избери категория</option>');
                    $.each(result, function(i, object) {
                        var id = "";
                        var name = "";
		                $.each(object, function(key, value) {
			                if (key == 'id'){
					            id = value;
				            }
				            if (key == 'name'){
					            name = value;
				            }
				        });
                        category_select.append('<option value='+id+'>'+name+'</option>');
			        });
                }
            }
        });
    });
</script>
@stop