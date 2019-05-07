@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <script type="text/javascript">
    function deleteUserImage(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита снимката за този търговец. Операцията е невъзвратима!",
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
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.view-firms') }}">Търговци</a> <a href="{{ route('admin.edit-firm', ['id'=>$firm->id]) }}">Редактирай търговец</a>            </div>
        <h1>Редакция на търговец</h1>
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
                        <h5>Редакция на търговец</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.edit-firm', ['id'=>$firm->id]) }}" name="edit_firm" id="edit_firm"
                            novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Търговец</label>
                                <div class="controls">
                                    <input type="text" name="firm_name" id="firm_name" value="{{ $firm->name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">E-Mail</label>
                                <div class="controls">
                                    <input type="email" readonly name="register_email" id="register_email" value="{{ $firm->email }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Телефон</label>
                                <div class="controls">
                                    <input type="text" name="firm_phone" id="firm_phone" value="{{ $firm->phone }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Населено място</label>
                                <div class="controls">
                                    <select name="firm_city" id="firm_city" style="width:310px;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if ($city->id === $firm->city_id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Адрес</label>
                                <div class="controls">
                                    <input type="text" name="firm_address" id="firm_address" value="{{ $firm->address }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Описание</label>
                                <div class="controls">
                                    <textarea name="info" id="info" rows="5">{!! $firm->info !!}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Снимка</label>
                                <div class="controls">
                                    <input type="file" name="image" id="image">
                                    <input type="hidden" name="current_image" id="current_image" value="{{ $firm->image }}">
                                    @if (!empty($firm->image))
                                        <a href="#imageModal" data-toggle="modal" title="Покажи снимката в голям размер."><img style="width:50px;" src="{{ asset('/images/backend_images/users/'.$firm->image) }}"></a> | <a onclick="deleteUserImage('{{ route('admin.delete-firm-image', ['id' => $firm->id]) }}');" class="btn btn-danger btn-mini">Изтрий снимката</a>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Месечни известия</label>
                                <div class="controls">
                                    <select name="monthizvestia" id="monthizvestia" style="width:314px;">
                                        <option value=0 @if ($firm->monthizvestia === 0) selected @endif>Не</option>
                                        <option value=1 @if ($firm->monthizvestia === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Известия за поръчки</label>
                                <div class="controls">
                                    <select name="porackiizvestia" id="porackiizvestia" style="width:314px;">
                                        <option value=0 @if ($firm->porackiizvestia === 0) selected @endif>Не</option>
                                        <option value=1 @if ($firm->porackiizvestia === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Нови известия</label>
                                <div class="controls">
                                    <select name="newizvestia" id="newizvestia" style="width:314px;">
                                        <option value=0 @if ($firm->newizvestia === 0) selected @endif>Не</option>
                                        <option value=1 @if ($firm->newizvestia === 1) selected @endif>Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Запиши промените" class="btn btn-success">
                                <a href="{{ route('admin.view-firms') }}" class="btn btn-primary">Обратно в търговци</a>
                            </div>
                        </form>
                        <div id="imageModal" class="modal hide" aria-hidden="true" style="display: none;">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">×</button>
                                <h3>Снимка на търговеца: {{ $firm->name }}</h3>
                            </div>
                            <div class="modal-body">
                                <p><img src="{{ asset('/images/backend_images/users/'.$firm->image) }}"></p>
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
