@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-tags') }}">Всички етикети</a> <a href="{{ route('admin.add-tag') }}">Добави етикет</a> </div>
      <h1>Етикети</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Добави Етикет</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.add-tag') }}" name="add_tag" id="add_tag" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Етикет</label>
                  <div class="controls">
                    <input type="text" name="tag_name" id="tag_name">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Добави празника" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
