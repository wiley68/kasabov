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
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-payment', ['id'=>$payment->id]) }}" name="edit_firm" id="edit_payment"
                            novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Състояние</label>
                                <div class="controls">
                                    <input type="text" name="payment_status" id="payment_status" value="{{ $payment->status }}">
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
