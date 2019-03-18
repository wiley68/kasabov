@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-cities') }}">Всички населени места</a> <a href="{{ route('admin.add-city') }}">Добави населено място</a> </div>
      <h1>Населени места</h1>
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Добави Населено място</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{ route('admin.add-city') }}" name="add_city" id="add_city" novalidate="novalidate">
                @csrf
                <div class="control-group">
                  <label class="control-label">Населено място</label>
                  <div class="controls">
                    <input type="text" name="city_city" id="citi_city">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Област</label>
                    <div class="controls">
                      <input type="text" name="city_oblast" id="citi_oblast">
                    </div>
                </div>
                    <div class="form-actions">
                    <input type="submit" value="Добави населеното място" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
