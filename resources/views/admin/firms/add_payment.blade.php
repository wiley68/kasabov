<?php use App\User; ?>

@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.view-payments') }}">Плащания</a> </div>
        <h1>Създаване на плащане</h1>
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
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Създаване на плащане</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.add-payment') }}" name="add_payment" id="add_payment"
                            novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Търговец</label>
                                <div class="controls">
                                    <select name="payment_user" id="payment_user" style="width:310px;">
                                        <option value="0" selected>Избери търговец</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Състояние</label>
                                <div class="controls">
                                    <select name="payment_status" id="payment_status" style="width:314px;">
                                        <option value="active" selected>Активно</option>
                                        <option value="pending">Изчаква плащане</option>
                                        <option value="expired">Изтекло</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Тип плащане</label>
                                <div class="controls">
                                    <select name="payment_type" id="payment_type" style="width:314px;">
                                        <option value="bank" selected>Банка</option>
                                        <option value="sms">SMS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Относно</label>
                                <div class="controls">
                                    <select name="payment_forthe" id="payment_forthe" style="width:314px;">
                                        <option value="standart" selected>Стандартно</option>
                                        <option value="reklama1">Пакет 1 промо продукт</option>
                                        <option value="reklama3">Пакет 3 промо продукта</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Запиши промените" class="btn btn-success">
                                <a href="{{ route('admin.view-payments') }}" class="btn btn-primary">Обратно в плащания</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
