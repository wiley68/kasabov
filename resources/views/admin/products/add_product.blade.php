<?php use App\Category; ?>
@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.view-products') }}">Всички продукти</a> <a href="{{ route('admin.add-product') }}">Добави продукт</a>            </div>
        <h1>Продукти</h1>
        @if (Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
        @endif
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.add-product') }}" name="add_product"
                id="add_product" novalidate="novalidate">
                @csrf
                <div class="span5">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Информация за продукта</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Собственик *</label>
                                <div class="controls">
                                    <select name="user_id" id="user_id" style="width:314px;">
                                        <option value="0" selected>Избери собственик</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Категория *</label>
                                <div class="controls">
                                    <select name="category_id" id="category_id" style="width:314px;">
                                        <option value="0" selected>Избери категория</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @foreach (Category::where(['parent_id'=>$category->id])->get() as $item)
                                                <option value="{{ $item->id }}">&nbsp;--&nbsp;{{ $item->name }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Продукт *</label>
                                <div class="controls">
                                    <input type="text" name="product_name" id="product_name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Код *</label>
                                <div class="controls">
                                    <input type="text" name="product_code" id="product_code">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Количество</label>
                                <div class="controls">
                                    <input type="number" name="quantity" id="quantity">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="color:red;">Цена *</label>
                                <div class="controls">
                                    <input type="number" name="price" id="price">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Снимка</label>
                                <div class="controls">
                                    <input type="file" name="image" id="image">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Основен цвят</label>
                                <div class="controls">
                                    <input type="color" id="first_color" name="first_color" value="#ffffff">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Втори цвят</label>
                                <div class="controls">
                                    <input type="color" id="second_color" name="second_color" value="#ffffff">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Възрастова група</label>
                                <div class="controls">
                                    <select name="age" id="age" style="width:314px;">
                            <option value="any" selected>Без значение</option>
                            <option value="child">За деца</option>
                            <option value="adult">За възрастни</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Пол</label>
                                <div class="controls">
                                    <select name="pol" id="pol" style="width:314px;">
                            <option value="any" selected>Без значение</option>
                            <option value="man">За мъже</option>
                            <option value="woman">За жени</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Състояние</label>
                                <div class="controls">
                                    <select name="condition" id="condition" style="width:314px;">
                            <option value="new" selected>Нов</option>
                            <option value="old">Употребяван</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Изпраща се с</label>
                                <div class="controls">
                                    <select name="send_id" id="send_id" style="width:314px;">
                                        <option value="0" selected>Избери доставчик</option>
                                        @foreach ($speditors as $speditor)
                                            <option value="{{ $speditor->id }}">{{ $speditor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Изпраща се от:</label>
                                <div class="controls">
                                    <select name="send_from_id" id="send_from_id" style="width:314px;">
                            <option value="0" selected>Няма посочен</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Цена за изпращане</label>
                                <div class="controls">
                                    <input type="number" name="price_send" id="price_send">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Безплатна доставка</label>
                                <div class="controls">
                                    <select name="send_free" id="send_free" style="width:314px;">
                            <option value="0" selected>Не</option>
                            <option value="1">Да</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Важи за:</label>
                                <div class="controls">
                                    <select name="send_free_id" id="send_free_id" style="width:314px;">
                            <option value="0" selected>Няма посочен</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Доставя за:</label>
                                <div class="controls">
                                    <select name="available_for" id="available_for" style="width:314px;">
                            <option value="country" selected>Цялата страна</option>
                            <option value="city">Населено място</option>
                            <option value="cities">Населени места</option>
                            <option value="area">Област</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Може да се вземе от обект</label>
                                <div class="controls">
                                    <select name="object" id="object" style="width:314px;">
                            <option value="0" selected>Не</option>
                            <option value="1">Да</option>
                        </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Адрес на обекта</label>
                                <div class="controls">
                                    <input type="text" name="object_name" id="object_name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Възможност за персонализиране</label>
                                <div class="controls">
                                    <select name="personalize" id="personalize" style="width:314px;">
                            <option value="0" selected>Не</option>
                            <option value="1">Да</option>
                        </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Добави продукт" class="btn btn-success">
                                <a href="{{ route('admin.view-products') }}" class="btn btn-primary">Обратно в продукти</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Описание на продукта</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div style="padding:10px;">
                                <textarea name="description" id="description" class="textarea_editor span12" rows="30"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>Етикети</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div style="padding:10px;">
                                <input type="text" name="tag_add" id="tag_add"> <button id="btn_add_tag" class="btn btn-primary">Добави етикета</button>
                                <div style="padding-top: 10px;" id="div_tags">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
	    $('.textarea_editor').wysihtml5();
        // Add tags
        function isNullOrWhitespace( input ) {
            if (typeof input === 'undefined' || input == null) return true;
            return input.replace(/\s/g, '').length < 1;
        }
        $('#btn_add_tag').click(function(e){
            e.preventDefault();
            const divTags = document.getElementById('div_tags');
            const tagAdd = document.getElementById('tag_add');
            if (!isNullOrWhitespace(tagAdd.value)){
                divTags.innerHTML += '<p><span class="label label-success">'+tagAdd.value+'</span><input type="hidden" name="tags[]" value="'+tagAdd.value+'"> <span onclick="removeTag(this);" style="color:red;cursor:pointer;">Изтрий</span></p>';
                tagAdd.value = '';
            }
        });
        function removeTag(item){
            // Remove tag from products_tags table by ajax
            item.parentElement.remove();
        };
    </script>
@stop
