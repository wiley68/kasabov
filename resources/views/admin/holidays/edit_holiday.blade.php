@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-holidays') }}">Празници</a> <a href="{{ route('admin.edit-holiday', ['id'=>$holiday->id]) }}">Редактирай празник</a> </div>
      <h1>Редакция на празник</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Редакция на празник</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.edit-holiday', ['id'=>$holiday->id]) }}" name="edit_holiday" id="edit_holiday" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Празник</label>
                  <div class="controls">
                    <input type="text" name="holiday_name" id="holiday_name" value="{{ $holiday->name }}">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Родителска категория</label>
                    <div class="controls">
                        <select name="parent_id" id="parent_id" style="width:314px;">
                            <option value="0">Без родителска категория</option>
                            @foreach ($levels as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $holiday->parent_id) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Описание</label>
                  <div class="controls">
                    <textarea name="holiday_description" id="holiday_description">{!! $holiday->description !!}</textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">URL</label>
                  <div class="controls">
                    <input type="text" name="holiday_url" id="holiday_url" value="{{ $holiday->url }}">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Редактирай група празник" class="btn btn-success">
                  <a href="{{ route('admin.view-holidays') }}" class="btn btn-primary">Обратно в група празници</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
