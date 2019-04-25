@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.view-firms') }}">Търговци</a> <a href="{{ route('admin.edit-firm', ['id'=>$firm->id]) }}">Редактирай търговец</a>            </div>
        <h1>Редакция на търговец</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Редакция на търговец</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ route('admin.edit-firm', ['id'=>$firm->id]) }}" name="edit_firm" id="edit_firm"
                            novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Търговец</label>
                                <div class="controls">
                                    <input type="text" name="firm_name" id="firm_name" value="{{ $firm->name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">E-Mail</label>
                                <div class="controls">
                                    <input type="email" name="firm_email" id="firm_email" value="{{ $firm->email }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Телефон</label>
                                <div class="controls">
                                    <input type="text" name="firm_phone" id="firm_phone" value="{{ $firm->phone }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Населено място</label>
                                <div class="controls">
                                    <select name="firm_city" id="firm_city" style="width:310px;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if ($city->id === $firm->city_id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Адрес</label>
                                <div class="controls">
                                    <input type="text" name="firm_address" id="firm_address" value="{{ $firm->address }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Описание</label>
                                <div class="controls">
                                    <textarea name="description" id="description" rows="5">{!! $firm->description !!}</textarea>
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
                                <input type="submit" value="Редактирай търговеца" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
