@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-reklami') }}">Всички реклами</a> <a href="{{ route('admin.add-reklama') }}">Добави реклама</a> </div>
      <h1>Реклами</h1>
      @if (Session::has('flash_message_error'))
      <div class="alert alert-error alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{!! session('flash_message_error') !!}</strong>
      </div>
      @endif
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Добави Реклама</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.add-reklama') }}" name="add_reklama" id="add_reklama" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Заглавие</label>
                  <div class="controls">
                    <input type="text" maxlength="128" name="title" id="title">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Описание</label>
                    <div class="controls">
                      <input type="text" style="width:800px;" maxlength="512" name="description" id="description">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">URL</label>
                    <div class="controls">
                      <input type="text" maxlength="256" name="url" id="url">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Състояние</label>
                    <div class="controls">
                        <select name="status" id="status" style="width:314px;">
                            <option value="1" selected>Активна</option>
                            <option value="0">Не активна</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <input type="submit" value="Добави реклама" class="btn btn-success">
                    <a href="{{ route('admin.view-reklami') }}" type="button" class="btn btn-default">Всички реклами</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
