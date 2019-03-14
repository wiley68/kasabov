<?php use App\Category; ?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-products') }}">Всички продукти</a> <a href="{{ route('admin.edit-product', ['id'=>$product->id]) }}">Редактирай продукт</a> </div>
      <h1>Редакция на продукт</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Редакция на продукт</h5>
            </div>
            <div class="widget-content nopadding">
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-product', ['id'=>$product->id]) }}" name="edit_product" id="edit_product" novalidate="novalidate">
                @csrf
                <div class="control-group">
                    <label class="control-label">Собственик</label>
                    <div class="controls">
                        <select name="user_id" id="user_id" style="width:314px;">
                            <option value="0" disabled>Избери собственик</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if ($user->id == $product->user_id) slected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Категория</label>
                    <div class="controls">
                        <select name="category_id" id="category_id" style="width:314px;">
                            <option value="0" disabled>Избери категория</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if ($category->id == $product->category_id) slected @endif>{{ $category->name }}</option>
                                @foreach (Category::where(['parent_id'=>$category->id])->get() as $item)
                                    <option value="{{ $item->id }}" @if ($category->id == $product->category_id) slected @endif>&nbsp;--&nbsp;{{ $item->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Продукт</label>
                  <div class="controls">
                    <input type="text" name="product_name" id="product_name" value="{{ $product->product_name }}">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Код</label>
                    <div class="controls">
                      <input type="text" name="product_code" id="product_code" value="{{ $product->product_code }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Цвят</label>
                    <div class="controls">
                      <input type="text" name="product_color" id="product_color" value="{{ $product->product_color }}">
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Описание</label>
                  <div class="controls">
                    <textarea name="description" id="description">{!! $product->description !!}</textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Цена</label>
                  <div class="controls">
                    <input type="number" name="price" id="price" value="{{ $product->price }}">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Снимка</label>
                    <div class="controls">
                      <input type="file" name="image" id="image" value="{{ $product->image }}">
                    </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Редактирай категорията" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
