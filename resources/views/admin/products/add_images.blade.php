@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-products') }}">Всички продукти</a> <a href="{{ route('admin.add-images', ['id'=>$product->id]) }}">Добави снимки</a> </div>
        <h1>Снимки</h1>
        @if (Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_error') !!}</strong>
            </div>
        @endif
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
              <h5>Добави снимки към продукта: <strong>{{ $product->product_name }}</strong></h5>
            </div>
            <div class="widget-content nopadding">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.add-images', ['id'=>$product->id]) }}" name="add_images" id="add_images" novalidate="novalidate">
                    @csrf
                    <div class="control-group">
                        <label class="control-label">Продукт:</label>
                        <label class="control-label"><strong>{{ $product->product_name }}</strong></label>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Код:</label>
                        <label class="control-label"><strong>{{ $product->product_code }}</strong></label>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="field_wrapper">
                            <div>
                                <input type="text" name="image[]" id="image" placeholder="Image" style="width:120px;"/>
                                <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                            </div>
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
    <div class="container-fluid">
        <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Всички снимки</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Снимка №</th>
                    <th>Снимка</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($product->images as $image)
                        <tr class="gradeX">
                            <td>{{ $image->id }}</td>
                            <td>{{ $image->image }}</td>
                            <td class="center">
                                <a onclick="" class="btn btn-danger btn-mini">Изтрий</a>
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
@endsection
