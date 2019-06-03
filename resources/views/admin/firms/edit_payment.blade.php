<?php use App\User; ?>

@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.view-payments') }}">Плащания</a> <a href="{{ route('admin.edit-payment', ['id'=>$payment->id]) }}">Редактирай плащане</a>            </div>
        <h1>Редакция на плащане</h1>
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
                        <h5>Редакция на плащане</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-payment', ['id'=>$payment->id]) }}" name="edit_payment" id="edit_payment"
                            novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">№</label>
                                <div class="controls">
                                    <input type="text" disabled name="payment_id" id="payment_id" value="{{ $payment->id }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Търговец</label>
                                <div class="controls">
                                    <input type="text" disabled name="payment_user" id="payment_user" value="{{ User::where(['id'=>$payment->user_id])->first()->name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Състояние</label>
                                <div class="controls">
                                    <select name="payment_status" id="payment_status" style="width:314px;">
                                        <option value="active" @if ($payment->status === "active") selected @endif>Активно</option>
                                        <option value="pending" @if ($payment->status === "pending") selected @endif>Изчаква плащане</option>
                                        <option value="expired" @if ($payment->status === "expired") selected @endif>Изтекло</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Активиран на</label>
                                <div class="controls">
                                    <input type="text" disabled name="active_at" id="active_at" value="{{ date('d.m.Y', strtotime(date($payment->active_at))) }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Тип плащане</label>
                                <div class="controls">
                                    <select name="payment_type" id="payment_type" style="width:314px;">
                                        <option value="bank" @if ($payment->payment === "bank") selected @endif>Банка</option>
                                        <option value="sms" @if ($payment->payment === "sms") selected @endif>SMS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Относно</label>
                                <div class="controls">
                                    <select name="payment_forthe" id="payment_forthe" style="width:314px;">
                                        <option value="standart" @if ($payment->forthe === "standart") selected @endif>Стандартно</option>
                                        <option value="reklama1" @if ($payment->forthe === "reklama1") selected @endif>Пакет 1 промо продукт</option>
                                        <option value="reklama3" @if ($payment->forthe === "reklama3") selected @endif>Пакет 3 промо продукта</option>
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
