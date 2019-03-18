@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-cities') }}">Населени места</a> <a href="{{ route('admin.edit-city', ['id'=>$city->id]) }}">Редактирай населеното място</a> </div>
      <h1>Редакция на населено място</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Редакция на населено място</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.edit-city', ['id'=>$city->id]) }}" name="edit_city" id="edit_city" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Населено място</label>
                  <div class="controls">
                    <input type="text" name="city_city" id="city_city" value="{{ $city->city }}">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Област</label>
                    <div class="controls">
                      <input type="text" name="city_oblast" id="city_oblast" value="{{ $city->oblast }}">
                    </div>
                </div>
                    <div class="form-actions">
                    <input type="submit" value="Редактирай населеното място" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
