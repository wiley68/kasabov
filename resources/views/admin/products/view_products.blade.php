<?php use App\Http\Controllers\CategoryController; ?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteProduct(url){
        if (confirm('Сигурни ли сте, че желаете да изтриете този продукт?')){
            window.location = url;
        }
        return false;
    };
</script>
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-products') }}" class="current">Всички продукти</a> <a href="{{ route('admin.add-product') }}">Добави продукт</a></div>
      <h1>Продукти</h1>
        @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Всички продукти</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Продукт №</th>
                    <th>Код</th>
                    <th>Продукт</th>
                    <th>Категория</th>
                    <th>Цвят</th>
                    <th>Цена</th>
                    <th>Снимка</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="gradeX">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_code }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ CategoryController::getCategoryById($product->category_id)->name }}</td>
                            <td>{{ $product->product_color }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                @if (!empty($product->image))
                                <img src="{{ asset('/images/backend_images/products/small/'.$product->image) }}" style="width:50px;">
                                @endif
                            </td>
                            <td class="center"><a href="{{ route('admin.edit-product', ['id' => $product->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deleteProduct('{{ route('admin.delete-product', ['id' => $product->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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
@endsection
