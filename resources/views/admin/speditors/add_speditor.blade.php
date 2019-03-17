@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-speditors') }}">Всички доставчици</a> <a href="{{ route('admin.add-speditor') }}">Добави доставчик</a> </div>
      <h1>Доставчици</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Добави Доставчик</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.add-speditor') }}" name="add_speditor" id="add_speditor" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Доставчик</label>
                  <div class="controls">
                    <input type="text" name="speditor_name" id="speditor_name">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Описание</label>
                    <div class="controls">
                      <textarea name="speditor_description" id="speditor_description"></textarea>
                    </div>
                  </div>
                  <div class="form-actions">
                  <input type="submit" value="Добави доставчика" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
