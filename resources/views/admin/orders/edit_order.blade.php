<?php use App\User; ?>
<?php use App\Product; ?>
@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.view-orders') }}">Заявки</a> <a href="{{ route('admin.edit-order', ['id'=>$order->id]) }}">Редактирай заявка</a>            </div>
        <h1>Редакция на заявка</h1>
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
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Редакция на заявка</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-order', ['id'=>$order->id]) }}" name="edit_order" id="edit_order"
                            novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Заявка №</label>
                                <div class="controls">
                                    <input type="text" readonly name="id" id="id" value="{{ $order->id }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Заявка от</label>
                                <div class="controls">
                                    <input type="text" readonly name="created_at" id="created_at" value="{{ date("d.m.Y H:i:s", strtotime($order->created_at)) }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Клиент</label>
                                <div class="controls">
                                    <input type="text" readonly name="user_id" id="user_id" value="{{ User::where(['id'=>$order->user_id])->first()->name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Продукт</label>
                                <div class="controls">
                                    <input type="text" readonly name="product_id" id="product_id" value="{{ Product::where(['id'=>$order->product_id])->first()->product_name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Съобщение</label>
                                <div class="controls">
                                    <textarea name="message" id="message" rows="5">{!! $order->message !!}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">E-mail</label>
                                <div class="controls">
                                    <input type="text" name="email" id="email" value="{{ $order->email }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Телефон</label>
                                <div class="controls">
                                    <input type="text" name="phone" id="phone" value="{{ $order->phone }}">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Запиши промените" class="btn btn-success">
                                <a href="{{ route('admin.view-orders') }}" class="btn btn-primary">Обратно в заявки</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
