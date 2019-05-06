<?php use App\City; ?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteFirm(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрит търговецът. Операцията е невъзвратима!",
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
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-firms') }}" class="current">Всички търговци</a> <a href="{{ route('admin.add-firm') }}">Добави търговец</a></div>
      <h1>Търговци</h1>
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
              <h5>Всички търговци</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Търговец №</th>
                    <th>Търговец</th>
                    <th>E-Mail</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($firms as $firm)
                        <tr class="gradeX">
                            <td>{{ $firm->id }}</td>
                            <td>{{ $firm->name }}</td>
                            <td>{{ $firm->email }}</td>
                            <td>{{ $firm->phone }}</td>
                            @php
                                if(!empty(City::where(['id'=>$firm->city_id])->first())){
                                  $city_name = City::where(['id'=>$firm->city_id])->first()->city;
                                }else{
                                  $city_name = '';
                                }
                            @endphp
                            <td>{{ $city_name }}, {{ $firm->address }}</td>
                            <td class="center">
                              <a href="{{ route('admin.edit-firm', ['id' => $firm->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deleteFirm('{{ route('admin.delete-firm', ['id' => $firm->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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
