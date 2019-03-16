<?php use App\Http\Controllers\TagController;?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deleteTag(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрит етикетът. Операцията е невъзвратима!",
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
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-tags') }}" class="current">Всички етикети</a> <a href="{{ route('admin.add-tag') }}">Добави етикет</a></div>
      <h1>Етикети</h1>
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
              <h5>Всички етикети</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Етикет №</th>
                    <th>Етикет</th>
                    <th>Управление</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr class="gradeX">
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td class="center"><a href="{{ route('admin.edit-tag', ['id' => $tag->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <button onclick="deleteTag('{{ route('admin.delete-tag', ['id' => $tag->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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
