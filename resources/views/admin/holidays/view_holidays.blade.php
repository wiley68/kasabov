@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-holidays') }}" class="current">Всички празници</a> </div>
      <h1>Празници</h1>
        @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Всички празници</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Празник №</th>
                    <th>Празник</th>
                    <th>URL</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($holidays as $holiday)
                        <tr class="gradeX">
                            <td>{{ $holiday->id }}</td>
                            <td>{{ $holiday->name }}</td>
                            <td>{{ $holiday->url }}</td>
                            <td class="center"><a href="{{ route('admin.edit-holiday', ['id' => $holiday->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <a id="btn_delete_holiday" href="{{ route('admin.delete-holiday', ['id' => $holiday->id]) }}" class="btn btn-danger btn-mini">Изтрий</a></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
