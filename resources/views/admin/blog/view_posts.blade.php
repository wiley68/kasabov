@extends('layouts.adminLayout.admin_design')

@section('content')
<script type="text/javascript">
    function deletePost(url) {
        swal({
                title: "Сигурни ли сте?",
                text: "Ще бъде изтрита публикацията. Операцията е невъзвратима!",
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
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a> <a href="{{ route('admin.view-posts') }}" class="current">Всички публикации</a> <a href="{{ route('admin.add-blog-post') }}">Добави публикация</a></div>
        <h1>Публикации</h1>
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
                        <h5>Всички публикации</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Публикация №</th>
                                    <th>Заглавие</th>
                                    <th>Управление</th>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                <tr class="gradeX">
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td class="center"><a href="{{ route('admin.edit-post', ['id' => $post->id]) }}" class="btn btn-primary btn-mini">Редактирай</a> <a onclick="deletePost('{{ route('admin.delete-post', ['id' => $post->id]) }}');" class="btn btn-danger btn-mini">Изтрий</a></td>
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