@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <script type="text/javascript">
    function deleteUserImage(url){
        swal({
            title: "Сигурни ли сте?",
            text: "Ще бъде изтрита снимката за този клиент. Операцията е невъзвратима!",
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
        <div id="breadcrumb">
            <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>
            <a href="{{ route('admin.view-users') }}">Клиенти</a>
            <a href="{{ route('admin.add-user') }}">Добави клиент</a>
        </div>
        <h1>Добавяне на клиент</h1>
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
                        <h5>Добавяне на клиент</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('admin.add-user') }}" name="add_user" id="add_user"
                            novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Клиент</label>
                                <div class="controls">
                                    <input type="text" name="user_name" id="user_name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Парола</label>
                                <div class="controls">
                                    <input type="password" id="password" name="password">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Повтори Паролата</label>
                                <div class="controls">
                                    <input type="password" id="password_again" name="password_again">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">E-Mail</label>
                                <div class="controls">
                                    <input type="email" name="register_email" id="register_email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Телефон</label>
                                <div class="controls">
                                    <input type="text" name="user_phone" id="user_phone">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Населено място</label>
                                <div class="controls">
                                    <select name="user_city" id="user_city" style="width:310px;">
                                        <option value="0" selected>Избери населено място</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->city }} - {{ $city->oblast }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Адрес</label>
                                <div class="controls">
                                    <input type="text" name="user_address" id="user_address">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Описание</label>
                                <div class="controls">
                                    <textarea name="info" id="info" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Месечни известия</label>
                                <div class="controls">
                                    <select name="monthizvestia" id="monthizvestia" style="width:314px;">
                                        <option value=0 >Не</option>
                                        <option value=1 >Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Известия за поръчки</label>
                                <div class="controls">
                                    <select name="porackiizvestia" id="porackiizvestia" style="width:314px;">
                                        <option value=0 >Не</option>
                                        <option value=1 >Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Нови известия</label>
                                <div class="controls">
                                    <select name="newizvestia" id="newizvestia" style="width:314px;">
                                        <option value=0 >Не</option>
                                        <option value=1 >Да</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Създай клиента" class="btn btn-success">
                                <a href="{{ route('admin.view-users') }}" class="btn btn-primary">Обратно в клиенти</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
