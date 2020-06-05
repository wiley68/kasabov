@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.edit-landing-page') }}">Редактирай Начална страница</a> </div>
        <h1>Редакция на Политика за бисквитки</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <form class="form-horizontal" method="post" action="{{ route('admin.edit-politika-biskvitki') }}" name="edit_politika_biskvitki" id="edit_politika_biskvitki"
                    novalidate="novalidate">
                    @csrf
                    <div class="widget-box">
                        <div class="widget-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#footer_tab">Политика за бисквитки</a></li>
                            </ul>
                        </div>
                        <div class="widget-content tab-content">
                            <div id="footer_tab" class="tab-pane active">
                                <div class="widget-box">
                                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                                        <h5>Текст</h5>
                                    </div>
                                    <div class="widget-content nopadding">
                                        <div style="padding:10px;">
                                            <textarea name="value_pb" id="value_pb" class="span12" rows="20">{!! $page->value_pb !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="Запиши промените" class="btn btn-success">
                        </div>
                    </div>
                </form>

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