@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.edit-price-page') }}">Редактирай Цени пакети</a> </div>
        <h1>Редакция на Цени пакети</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <form class="form-horizontal" method="post" action="{{ route('admin.edit-price-page') }}" name="edit_price_page" id="edit_price_page"
                    novalidate="novalidate">
                    @csrf
                    <div class="widget-box">
                        <div class="widget-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#price_tab">Цени пакети</a></li>
                            </ul>
                        </div>
                        <div class="widget-content tab-content">
                            <div id="price_tab" class="tab-pane active">
                                <div class="control-group">
                                    <label class="control-label">Цена за стандартен пакет (лв.)</label>
                                    <div class="controls">
                                        <input type="number" step="0.01" name="paket_standart" id="paket_standart" value="{{ $property->paket_standart }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Време стандартен пакет (дни)</label>
                                    <div class="controls">
                                        <input type="number" step="1" name="paket_standart_time" id="paket_standart_time" value="{{ $property->paket_standart_time }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Цена за рекламен пакет 1 (лв.)</label>
                                    <div class="controls">
                                        <input type="number" step="0.01" name="paket_reklama_1" id="paket_reklama_1" value="{{ $property->paket_reklama_1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Време рекламен пакет 1 (дни)</label>
                                    <div class="controls">
                                        <input type="number" step="1" name="paket_reklama_1_time" id="paket_reklama_1_time" value="{{ $property->paket_reklama_1_time }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Цена за рекламен пакет 2 (лв.)</label>
                                    <div class="controls">
                                        <input type="number" step="0.01" name="paket_reklama_2" id="paket_reklama_2" value="{{ $property->paket_reklama_2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Време рекламен пакет 2 (дни)</label>
                                    <div class="controls">
                                        <input type="number" step="1" name="paket_reklama_2_time" id="paket_reklama_2_time" value="{{ $property->paket_reklama_2_time }}">
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
