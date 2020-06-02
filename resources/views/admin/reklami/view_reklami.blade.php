@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteReklama(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита рекламата. Операцията е невъзвратима!",
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
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-reklami') }}" class="current">Всички реклами</a> <a href="{{ route('admin.add-reklama') }}">Добави реклама</a></div>
      <h1>Реклами</h1>
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
              <h5>Всички реклами</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Реклама №</th>
                    <th>Заглавие</th>
                    <th>URL</th>
                    <th>Състояние</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($reklami as $reklama)
                        @php
                            switch ($reklama->status) {
                                case 0:
                                    $status_txt = "Не активна";
                                    break;
                                case 1:
                                    $status_txt = "Активна";
                                    break;
                                default:
                                    $status_txt = "Активна";
                                    break;
                            }
                        @endphp
                        <tr class="gradeX">
                            <td>{{ $reklama->id }}</td>
                            <td>{{ $reklama->title }}</td>
                            <td>{{ $reklama->url }}</td>
                            <td>{{ $status_txt }}</td>
                            <td class="center"><a href="{{ route('admin.edit-reklama', ['id' => $reklama->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <a onclick="deleteReklama('{{ route('admin.delete-reklama', ['id' => $reklama->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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
