@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ route('admin.dashboard') }}" title="Административен панел" class="tip-bottom"><i class="icon-home"></i> Панел</a>            <a href="{{ route('admin.edit-landing-page') }}">Редактирай Начална страница</a> </div>
        <h1>Редакция на Начална страница</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <form class="form-horizontal" method="post" action="{{ route('admin.edit-landing-page') }}" name="edit_landing_page" id="edit_landing_page"
                    novalidate="novalidate">
                    @csrf
                    <div class="widget-box">
                        <div class="widget-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#category_tab">Категории</a></li>
                                <li><a data-toggle="tab" href="#producti_tab">Платени продукти</a></li>
                                <li><a data-toggle="tab" href="#reklama_tab">Рекламна част</a></li>
                                <li><a data-toggle="tab" href="#footer_tab">Футър част</a></li>
                            </ul>
                        </div>
                        <div class="widget-content tab-content">
                            <div id="category_tab" class="tab-pane active">
                                <div class="control-group">
                                    <label class="control-label">Категории заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="category_title" id="category_title" maxlength="48" value="{{ $property->category_title }}">
                                    </div>
                                </div>
                            </div>
                            <div id="producti_tab" class="tab-pane">
                                <div class="control-group">
                                    <label class="control-label">Най-харесвани заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="best_title" id="best_title" maxlength="48" value="{{ $property->best_title }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Най-харесвани под-заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="best_subtitle" id="best_subtitle" maxlength="128" style="width:800px;" value="{{ $property->best_subtitle }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Препоръчани заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="featured_title" id="featured_title" maxlength="48" value="{{ $property->featured_title }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Препоръчани под-заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="featured_subtitle" id="featured_subtitle" maxlength="128" style="width:800px;" value="{{ $property->featured_subtitle }}">
                                    </div>
                                </div>
                            </div>
                            <div id="reklama_tab" class="tab-pane">
                                <div class="control-group">
                                    <label class="control-label">Как работим заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="works_title" id="works_title" maxlength="48" value="{{ $property->works_title }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Как работим под-заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="works_subtitle" id="works_subtitle" maxlength="128" style="width:800px;" value="{{ $property->works_subtitle }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Създай профил</label>
                                    <div class="controls">
                                        <input type="text" name="create_account" id="create_account" maxlength="48" value="{{ $property->create_account }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Публикувай обява</label>
                                    <div class="controls">
                                        <input type="text" name="post_add" id="post_add" maxlength="48" value="{{ $property->post_add }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Направи сделка</label>
                                    <div class="controls">
                                        <input type="text" name="deal_done" id="deal_done" maxlength="48" value="{{ $property->deal_done }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползите за Вас</label>
                                    <div class="controls">
                                        <input type="text" name="key_title" id="key_title" maxlength="48" value="{{ $property->key_title }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползите за Вас под-заглавие</label>
                                    <div class="controls">
                                        <input type="text" name="key_subtitle" id="key_subtitle" maxlength="128" style="width:800px;" value="{{ $property->key_subtitle }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи заглавие 1</label>
                                    <div class="controls">
                                        <input type="text" name="key_title1" id="key_title1" maxlength="48" value="{{ $property->key_title1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи под-заглавие 1</label>
                                    <div class="controls">
                                        <input type="text" name="key_description1" id="key_description1" maxlength="128" style="width:800px;" value="{{ $property->key_description1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи икона 1</label>
                                    <div class="controls">
                                        <input type="text" name="key_icon1" id="key_icon1" maxlength="48" value="{{ $property->key_icon1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи заглавие 2</label>
                                    <div class="controls">
                                        <input type="text" name="key_title2" id="key_title2" maxlength="48" value="{{ $property->key_title2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи под-заглавие 2</label>
                                    <div class="controls">
                                        <input type="text" name="key_description2" id="key_description2" maxlength="128" style="width:800px;" value="{{ $property->key_description2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи икона 2</label>
                                    <div class="controls">
                                        <input type="text" name="key_icon2" id="key_icon2" maxlength="48" value="{{ $property->key_icon2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи заглавие 3</label>
                                    <div class="controls">
                                        <input type="text" name="key_title3" id="key_title3" maxlength="48" value="{{ $property->key_title3 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи под-заглавие 3</label>
                                    <div class="controls">
                                        <input type="text" name="key_description3" id="key_description3" maxlength="128" style="width:800px;" value="{{ $property->key_description3 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи икона 3</label>
                                    <div class="controls">
                                        <input type="text" name="key_icon3" id="key_icon3" maxlength="48" value="{{ $property->key_icon3 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи заглавие 4</label>
                                    <div class="controls">
                                        <input type="text" name="key_title4" id="key_title4" maxlength="48" value="{{ $property->key_title4 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи под-заглавие 4</label>
                                    <div class="controls">
                                        <input type="text" name="key_description4" id="key_description4" maxlength="128" style="width:800px;" value="{{ $property->key_description4 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи икона 4</label>
                                    <div class="controls">
                                        <input type="text" name="key_icon4" id="key_icon4" maxlength="48" value="{{ $property->key_icon4 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи заглавие 5</label>
                                    <div class="controls">
                                        <input type="text" name="key_title5" id="key_title5" maxlength="48" value="{{ $property->key_title5 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи под-заглавие 5</label>
                                    <div class="controls">
                                        <input type="text" name="key_description5" id="key_description5" maxlength="128" style="width:800px;" value="{{ $property->key_description5 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи икона 5</label>
                                    <div class="controls">
                                        <input type="text" name="key_icon5" id="key_icon5" maxlength="48" value="{{ $property->key_icon5 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи заглавие 6</label>
                                    <div class="controls">
                                        <input type="text" name="key_title6" id="key_title6" maxlength="48" value="{{ $property->key_title6 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи под-заглавие 6</label>
                                    <div class="controls">
                                        <input type="text" name="key_description6" id="key_description6" maxlength="128" style="width:800px;" value="{{ $property->key_description6 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Ползи икона 6</label>
                                    <div class="controls">
                                        <input type="text" name="key_icon6" id="key_icon6" maxlength="48" value="{{ $property->key_icon6 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив описание 1</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_description1" id="testimonials_description1" maxlength="128" style="width:800px;" value="{{ $property->testimonials_description1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив име 1</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_name1" id="testimonials_name1" maxlength="48" value="{{ $property->testimonials_name1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив титла 1</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_title1" id="testimonials_title1" maxlength="48" value="{{ $property->testimonials_title1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив описание 2</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_description2" id="testimonials_description2" maxlength="128" style="width:800px;" value="{{ $property->testimonials_description2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив име 2</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_name2" id="testimonials_name2" maxlength="48" value="{{ $property->testimonials_name2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив титла 2</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_title2" id="testimonials_title2" maxlength="48" value="{{ $property->testimonials_title2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив описание 3</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_description3" id="testimonials_description3" maxlength="128" style="width:800px;" value="{{ $property->testimonials_description3 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив име 3</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_name3" id="testimonials_name3" maxlength="48" value="{{ $property->testimonials_name3 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Отзив титла 3</label>
                                    <div class="controls">
                                        <input type="text" name="testimonials_title3" id="testimonials_title3" maxlength="48" value="{{ $property->testimonials_title3 }}">
                                    </div>
                                </div>
                            </div>
                            <div id="footer_tab" class="tab-pane">
                                <div class="control-group">
                                    <label class="control-label">Текст във футъра</label>
                                    <div class="controls">
                                        <input type="text" name="footer_text" id="footer_text" maxlength="256" style="width:800px;" value="{{ $property->footer_text }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Футър телефон 1</label>
                                    <div class="controls">
                                        <input type="text" name="footer_phone1" id="footer_phone1" maxlength="48" value="{{ $property->footer_phone1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Футър телефон 2</label>
                                    <div class="controls">
                                        <input type="text" name="footer_phone2" id="footer_phone2" maxlength="48" value="{{ $property->footer_phone2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Футър mail 1</label>
                                    <div class="controls">
                                        <input type="mail" name="footer_mail1" id="footer_mail1" maxlength="48" value="{{ $property->footer_mail1 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Футър mail 2</label>
                                    <div class="controls">
                                        <input type="mail" name="footer_mail2" id="footer_mail2" maxlength="48" value="{{ $property->footer_mail2 }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Футър адрес</label>
                                    <div class="controls">
                                        <input type="text" name="footer_address" id="footer_address" maxlength="128" style="width:800px;" value="{{ $property->footer_address }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Футър права</label>
                                    <div class="controls">
                                        <input type="text" name="footer_rites" id="footer_rites" maxlength="256" style="width:800px;" value="{{ $property->footer_rites }}">
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
