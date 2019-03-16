<?php use App\Category; ?>
@extends('layouts.adminLayout.admin_design')

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
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-products') }}">Всички продукти</a> <a href="{{ route('admin.edit-product', ['id'=>$product->id]) }}">Редактирай продукт</a> </div>
        <h1>Редакция на продукт</h1>
        @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif
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
                                <option value="{{ $user->id }}" @if ($user->id == $product->user_id) selected @endif>{{ $user->name }}</option>
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
                                <option value="{{ $category->id }}" @if ($category->id == $product->category_id) selected @endif>{{ $category->name }}</option>
                                @foreach (Category::where(['parent_id'=>$category->id])->get() as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $product->category_id) selected @endif>&nbsp;--&nbsp;{{ $item->name }}</option>
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
                        <input type="file" name="image" id="image">
                        <input type="hidden" name="current_image" id="current_image" value="{{ $product->image }}">
                        @if (!empty($product->image))
                            <a href="#imageModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/products/small/'.$product->image) }}"></a> | <a onclick="deleteProductImage('{{ route('admin.delete-product-image', ['id' => $product->id]) }}');" class="btn btn-danger btn-mini">Изтрий снимката</a>
                        @endif
                    </div>
                </div>
                <div class="form-actions">
                    <input type="submit" value="Редактирай продукта" class="btn btn-success">
                    <a href="{{ route('admin.view-products') }}" class="btn btn-primary">Обратно в продукти</a>
                </div>
              </form>
              <div id="imageModal" class="modal hide" aria-hidden="true" style="display: none;">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h3>Снимка на продукта: {{ $product->product_name }}</h3>
                </div>
                <div class="modal-body">
                    <p><img src="{{ asset('/images/backend_images/products/large/'.$product->image) }}"></p>
                </div>
                <div class="modal-footer"><a data-dismiss="modal" class="btn btn-inverse" href="#">Затвори</a> </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
