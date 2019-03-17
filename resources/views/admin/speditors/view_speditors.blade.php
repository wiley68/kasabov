<?php use App\Http\Controllers\SpeditorController;?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteSpeditor(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрит доставчикът. Операцията е невъзвратима!",
            icon: "warning",
            buttons: ["Отказ!", "Съгласен съм!"],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            window.location = url;
        } else {
            return false;
        }
        });
        return false;
    };
</script>
<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-speditors') }}" class="current">Всички доставчици</a> <a href="{{ route('admin.add-speditor') }}">Добави доставчик</a></div>
      <h1>Доставчици</h1>
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
              <h5>Всички доставчици</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Доставчик №</th>
                    <th>Доставчик</th>
                    <th>Описание</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($speditors as $speditor)
                        <tr class="gradeX">
                            <td>{{ $speditor->id }}</td>
                            <td>{{ $speditor->name }}</td>
                            <td>{!! $speditor->description !!}</td>
                            <td class="center"><a href="{{ route('admin.edit-speditor', ['id' => $speditor->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deleteSpeditor('{{ route('admin.delete-speditor', ['id' => $speditor->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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
