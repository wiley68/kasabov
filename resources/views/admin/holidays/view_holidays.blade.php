<?php use App\Http\Controllers\HolidayController;?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteHoliday(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрит празникът. Операцията е невъзвратима!",
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
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-holidays') }}" class="current">Всички групи празници</a> <a href="{{ route('admin.add-holiday') }}">Добави група празник</a></div>
      <h1>Групи Празници</h1>
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
              <h5>Всички групи празници</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Група Празник №</th>
                    <th>Наименование</th>
                    <th>Родителска група</th>
                    <th>URL</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($holidays as $holiday)
                        <tr class="gradeX">
                            <td>{{ $holiday->id }}</td>
                            <td><strong>{{ $holiday->name }}</strong></td>
                            <td><strong>Главна група</strong></td>
                            <td>{{ $holiday->url }}</td>
                            <td class="center"><a href="{{ route('admin.edit-holiday', ['id' => $holiday->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deleteHoliday('{{ route('admin.delete-holiday', ['id' => $holiday->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
                        </tr>
                        @foreach (HolidayController::getSubholidayById($holiday->id) as $item)
                            <tr class="gradeX">
                                <td>{{ $item->id }}</td>
                                <td>... {{ $item->name }}</td>
                                <td>{{ HolidayController::getHolidayById($item->parent_id)->name }}</td>
                                <td>{{ $item->url }}</td>
                                <td class="center"><a href="{{ route('admin.edit-holiday', ['id' => $item->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deleteHoliday('{{ route('admin.delete-holiday', ['id' => $item->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
                            </tr>
                        @endforeach
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
