<?php use App\City; ?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteUser(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрит клиентът. Операцията е невъзвратима!",
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
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-users') }}" class="current">Всички клиенти</a> <a href="{{ route('admin.add-user') }}">Добави клиент</a></div>
      <h1>Клиенти</h1>
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
              <h5>Всички клиенти</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Клиент №</th>
                    <th>Клиент</th>
                    <th>E-Mail</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="gradeX">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            @php
                                if(!empty(City::where(['id'=>$user->city_id])->first())){
                                  $city_name = City::where(['id'=>$user->city_id])->first()->city;
                                }else{
                                  $city_name = '';
                                }
                            @endphp
                            <td>{{ $city_name }}, {{ $user->address }}</td>
                            <td class="center">
                              <a href="{{ route('admin.edit-user', ['id' => $user->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deleteUser('{{ route('admin.delete-user', ['id' => $user->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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
