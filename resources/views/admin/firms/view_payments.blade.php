<?php use App\User; ?>

@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deletePayment(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрито плащането. Операцията е невъзвратима!",
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
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-payments') }}" class="current">Всички плащания</a> <a href="{{ route('admin.add-payment') }}">Добави плащане</a></div>
      <h1>Плащания</h1>
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
              <h5>Всички плащания</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Плащане №</th>
                    <th>Търговец</th>
                    <th>Активирано на</th>
                    <th>Състояние</th>
                    <th>Тип плащане</th>
                    <th>Относно</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="gradeX">
                            <td>{{ $payment->id }}</td>
                            <td>{{ User::where(['id'=>$payment->user_id])->first()->name }}</td>
                            <td>{{ date('d.m.Y', strtotime(date($payment->active_at))) }}</td>
                            @php
                                switch ($payment->status) {
                                    case 'active':
                                        $payment_status = "Активно";
                                        break;
                                    case 'pending':
                                        $payment_status = "Изчаква плащане";
                                        break;
                                    case 'expired':
                                        $payment_status = "Изтекло";
                                        break;
                                    default:
                                        $payment_status = "Изчаква плащане";
                                        break;
                                }
                            @endphp
                            <td>{{ $payment_status }}</td>
                            @php
                                switch ($payment->payment) {
                                    case 'bank':
                                        $payment_type = "Банка";
                                        break;
                                    case 'sms':
                                        $payment_type = "SMS";
                                        break;
                                    default:
                                        $payment_type = "Банка";
                                        break;
                                }
                            @endphp
                            <td>{{ $payment_type }}</td>
                            @php
                                switch ($payment->forthe) {
                                    case 'standart':
                                        $payment_forthe = "Стандартно";
                                        break;
                                    case 'reklama1':
                                        $payment_forthe = "Пакет 1 промо продукт";
                                        break;
                                    case 'reklama3':
                                        $payment_forthe = "Пакет 3 промо продукта";
                                        break;
                                    default:
                                        $payment_forthe = "Стандартно";
                                        break;
                                }
                            @endphp
                            <td>{{ $payment_forthe }}</td>
                            <td class="center">
                              <a href="{{ route('admin.edit-payment', ['id' => $payment->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deletePayment('{{ route('admin.delete-payment', ['id' => $payment->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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
