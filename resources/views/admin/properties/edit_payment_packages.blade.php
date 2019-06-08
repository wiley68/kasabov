@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.edit-payment-packages') }}">Редактирай платежни методи</a> </div>
        <h1>Редактирай платежни методи</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <form class="form-horizontal" method="post" action="{{ route('admin.edit-payment-packages') }}" name="edit_payment_packages" id="edit_payment_packages"
                    novalidate="novalidate">
                    @csrf
                    <div class="widget-box">
                        <div class="widget-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#price_tab">Платежни методи</a></li>
                            </ul>
                        </div>
                        <div class="widget-content tab-content">
                            <div id="price_tab" class="tab-pane active">
                                <div class="control-group">
                                    <label class="control-label">Име на фирмата собственик</label>
                                    <div class="controls">
                                        <input type="text" name="firm_name" id="firm_name" value="{{ $property->firm_name }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Имена собственик</label>
                                    <div class="controls">
                                        <input type="text" name="mol" id="mol" value="{{ $property->mol }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Адрес фирма собственик</label>
                                    <div class="controls">
                                        <input type="text" name="address" id="address" value="{{ $property->address }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Телефон фирма собственик</label>
                                    <div class="controls">
                                        <input type="text" name="phone" id="phone" value="{{ $property->phone }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Банка</label>
                                    <div class="controls">
                                        <input type="text" name="bank_name" id="bank_name" value="{{ $property->bank_name }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">IBAN</label>
                                    <div class="controls">
                                        <input type="text" name="iban" id="iban" value="{{ $property->iban }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">BIC</label>
                                    <div class="controls">
                                        <input type="text" name="bic" id="bic" value="{{ $property->bic }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="Запиши промените" class="btn btn-success">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
