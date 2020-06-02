@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-reklami') }}">Всички реклами</a> <a href="{{ route('admin.edit-reklama', ['id'=>$reklama->id]) }}">Редактирай реклама</a> </div>
      <h1>Редакция на реклама</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Редакция на реклама</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.edit-reklama', ['id'=>$reklama->id]) }}" name="edit_reklama" id="edit_reklama" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Заглавие</label>
                  <div class="controls">
                    <input type="text" name="title" maxlength="128" id="title" value="{{ $reklama->title }}">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Описание</label>
                    <div class="controls">
                      <input type="text" style="width:800px;" name="description" maxlength="512" id="description" value="{{ $reklama->description }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">URL</label>
                    <div class="controls">
                      <input type="text" name="url" maxlength="256" id="url" value="{{ $reklama->url }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Състояние</label>
                    <div class="controls">
                        <select name="status" id="status" style="width:314px;">
                            <option value="1" @if ($reklama->status == 1) selected @endif>Активна</option>
                            <option value="0" @if ($reklama->status == 0) selected @endif>Не активна</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Запиши рекламата" class="btn btn-success">
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
