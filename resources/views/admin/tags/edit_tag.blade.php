@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-tags') }}">Етикети</a> <a href="{{ route('admin.edit-tag', ['id'=>$tag->id]) }}">Редактирай етикет</a> </div>
      <h1>Редакция на етикет</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Редакция на етикет</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.edit-tag', ['id'=>$tag->id]) }}" name="edit_tag" id="edit_tag" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Етикет</label>
                  <div class="controls">
                    <input type="text" name="tag_name" id="tag_name" value="{{ $tag->name }}">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">URL</label>
                  <div class="controls">
                    <input type="text" name="tag_url" id="tag_url" value="{{ $tag->url }}">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Редактирай етикета" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
