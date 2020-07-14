@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-posts') }}">Публикации</a> <a href="{{ route('admin.edit-post', ['id'=>$post->id]) }}">Редактирай публикация</a> </div>
        <h1>Редакция на публикация</h1>
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
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Редакция на публикация</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-post', ['id'=>$post->id]) }}" name="edit_post" id="edit_post" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Заглавие</label>
                                <div class="controls">
                                    <input type="text" name="title" id="title" value="{{ $post->title }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Текст</label>
                                <div class="controls">
                                    <textarea name="description" id="description" class="span12" rows="20">{{ $post->description }}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Снимка</label>
                                <div class="controls">
                                    <input type="file" name="image" id="image">
                                    <input type="hidden" name="current_image" id="current_image" value="{{ $post->image }}">
                                    @if (!empty($post->image))
                                        <a href="#imageModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/blog/'.$post->image) }}"></a> | <a onclick="deleteUserImage('{{ route('admin.delete-post-image', ['id' => $post->id]) }}');" class="btn btn-danger btn-mini">Изтрий снимката</a>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Мета Заглавие</label>
                                <div class="controls">
                                    <input type="text" maxlength="60" name="meta_title" id="meta_title" value="{{ $post->meta_title }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Мета Описание</label>
                                <div class="controls">
                                    <input type="text" maxlength="160" name="meta_description" id="meta_description" value="{{ $post->meta_description }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ключови думи</label>
                                <div class="controls">
                                    <input type="text" maxlength="256" name="meta_keywords" id="meta_keywords" value="{{ $post->meta_keywords }}">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Редактирай публикация" class="btn btn-success">
                            </div>
                        </form>
                        <div id="imageModal" class="modal hide" aria-hidden="true" style="display: none;">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">×</button>
                                <h3>Снимка на публикацията: {{ $post->title }}</h3>
                            </div>
                            <div class="modal-body">
                                <p><img src="{{ asset('/images/backend_images/blog/'.$post->image) }}"></p>
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
@section('scripts')
<script>
    $('textarea').wysihtml5();
</script>
@stop