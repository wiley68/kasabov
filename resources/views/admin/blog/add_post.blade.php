@extends('layouts.adminLayout.admin_design')

@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-posts') }}">Всички публикации</a> <a href="{{ route('admin.add-blog-post') }}">Добави публикация</a> </div>
        <h1>Публикации</h1>
        @if (Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
        @endif
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Добави Публикация</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ route('admin.add-blog-post') }}" name="add_blog_post" id="add_blog_post" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Заглавие</label>
                                <div class="controls">
                                    <input type="text" maxlength="128" name="title" id="title">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Текст</label>
                                <div class="controls">
                                    <textarea name="description" id="description" class="span12" rows="20"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Мета Заглавие</label>
                                <div class="controls">
                                    <input type="text" maxlength="60" name="meta_title" id="meta_title">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Мета Описание</label>
                                <div class="controls">
                                    <input type="text" maxlength="160" name="meta_description" id="meta_description">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ключови думи</label>
                                <div class="controls">
                                    <input type="text" maxlength="256" name="meta_keywords" id="meta_keywords">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Добави публикация" class="btn btn-success">
                                <a href="{{ route('admin.view-posts') }}" type="button" class="btn btn-default">Всички публикации</a>
                            </div>
                        </form>
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