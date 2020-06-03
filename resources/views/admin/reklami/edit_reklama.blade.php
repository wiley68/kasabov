@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
  <script type="text/javascript">
    function deleteImage(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита снимката за тази реклама. Операцията е невъзвратима!",
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
    <div id="content-header">
      <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-reklami') }}">Всички реклами</a> <a href="{{ route('admin.edit-reklama', ['id'=>$reklama->id]) }}">Редактирай реклама</a> </div>
      <h1>Редакция на реклама</h1>
      @if (Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_success') !!}</strong>
          </div>
      @endif
    </div>
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Редакция на реклама</h5>
            </div>
            <div class="widget-content nopadding">
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-reklama', ['id'=>$reklama->id]) }}" name="edit_reklama" id="edit_reklama">
                @csrf
                <div class="control-group">
                  <label class="control-label">Заглавие</label>
                  <div class="controls">
                    <input type="text" name="title" maxlength="128" id="title" value="{{ $reklama->title }}">
                  </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Описание</label>
                    <div class="controls">
                      <input type="text" style="width:800px;" name="description" maxlength="512" id="description" value="{{ $reklama->description }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">URL</label>
                    <div class="controls">
                      <input type="text" name="url" maxlength="256" id="url" value="{{ $reklama->url }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Състояние</label>
                    <div class="controls">
                        <select name="status" id="status" style="width:314px;">
                            <option value="1" @if ($reklama->status == 1) selected @endif>Активна</option>
                            <option value="0" @if ($reklama->status == 0) selected @endif>Не активна</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Снимка реклама малка (200x200 px.)</label>
                  <div class="controls">
                      <input type="file" name="image_small" id="image_small">
                      <input type="hidden" name="current_image_small" id="current_image_small" value="{{ $reklama->image_small }}">
                      @if (!empty($reklama->image_small))
                          <a href="#imageSmallModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/reklama_small/'.$reklama->image_small) }}"></a> | <a onclick="deleteImage('{{ route('admin.delete-reklama-image-small', ['id' => $reklama->id]) }}');" class="btn btn-danger btn-mini">Изтрий снимката</a>
                      @endif
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Снимка реклама голяма (1200x400 px.)</label>
                  <div class="controls">
                      <input type="file" name="image_large" id="image_large">
                      <input type="hidden" name="current_image_large" id="current_image_large" value="{{ $reklama->image_large }}">
                      @if (!empty($reklama->image_large))
                          <a href="#imageLargeModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/reklama_large/'.$reklama->image_large) }}"></a> | <a onclick="deleteImage('{{ route('admin.delete-reklama-image-large', ['id' => $reklama->id]) }}');" class="btn btn-danger btn-mini">Изтрий снимката</a>
                      @endif
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Запиши рекламата" class="btn btn-success">
                  <a href="{{ route('admin.view-reklami') }}" type="button" class="btn btn-default">Всички реклами</a>
                </div>
              </form>
              <div id="imageSmallModal" class="modal hide" aria-hidden="true" style="display: none;">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h3>Рекламна снимка малка: {{ $reklama->title }}</h3>
                </div>
                <div class="modal-body">
                    <p><img src="{{ asset('/images/backend_images/reklama_small/'.$reklama->image_small) }}"></p>
                </div>
                <div class="modal-footer">
                    <a data-dismiss="modal" class="btn btn-inverse" href="#">Затвори</a>
                </div>
              </div>
              <div id="imageLargeModal" class="modal hide" aria-hidden="true" style="display: none;">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h3>Рекламна снимка голяма: {{ $reklama->title }}</h3>
                </div>
                <div class="modal-body">
                    <p><img src="{{ asset('/images/backend_images/reklama_large/'.$reklama->image_large) }}"></p>
                </div>
                <div class="modal-footer">
                    <a data-dismiss="modal" class="btn btn-inverse" href="#">Затвори</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
