<?php use App\Category; ?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-products') }}">Всички продукти</a> <a href="{{ route('admin.add-product') }}">Добави продукт</a> </div>
        <h1>Продукти</h1>
        @if (Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
          <     strong>{!! session('flash_message_error') !!}</>
            </div>
        @endif
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Добави продукт</h5>
            </div>
            <div class="widget-content nopadding">
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.add-product') }}" name="add_product" id="add_product" novalidate="novalidate">
                @csrf
                <div class="control-group">
                    <label class="control-label">Собственик</label>
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
                    <label class="control-label">Категория</label>
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
                  <label class="control-label">Продукт</label>
                  <div class="controls">
                    <input type="text" name="product_name" id="product_name">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Код</label>
                    <div class="controls">
                      <input type="text" name="product_code" id="product_code">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Цвят</label>
                    <div class="controls">
                      <input type="text" name="product_color" id="product_color">
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Описание</label>
                  <div class="controls">
                    <textarea name="description" id="description"></textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Цена</label>
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
                  <div class="form-actions">
                  <input type="submit" value="Добави продукт" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
