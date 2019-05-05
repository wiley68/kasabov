@extends('layouts.frontLayout.front_design')
@section('content')
<!-- Start Content -->
<div id="content" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
                <aside>
                    <div class="sidebar-box">
                        <div class="user">
                            <figure>
                                <img src="{{ asset('/images/backend_images/users/'.$user->image) }}" alt="">
                            </figure>
                            <div class="usercontent">
                                <h3>Здравейте {{ Auth::user()->name }}!</h3>
                                <h4>Търговец</h4>
                            </div>
                        </div>
                        <nav class="navdashboard">
                            <ul>
                                <li>
                                    <a href="{{ route('home-firm') }}">
                                                <i class="lni-dashboard"></i><span>Панел управление</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-settings') }}">
                                                <i class="lni-cog"></i><span>Настройки профил</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-adds') }}">
                                                <i class="lni-layers"></i><span>Моите оферти</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-orders') }}">
                                                <i class="lni-envelope"></i><span>Поръчки</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-payments') }}">
                                                <i class="lni-wallet"></i><span>Плащания</span>
                                            </a>
                                </li>
                                <li>
                                    <a class="active" href="{{ route('home-firm-privacy') }}">
                                                <i class="lni-star"></i><span>Лични</span>
                                            </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout-front-firm') }}">
                                                <i class="lni-enter"></i><span>Изход</span>
                                            </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="widget">
                        <h4 class="widget-title">Advertisement</h4>
                        <div class="add-box">
                            <img class="img-fluid" src="assets/img/img1.jpg" alt="">
                        </div>
                    </div>
                </aside>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="page-content">
                    <div class="inner-box">
                        @if (Session::has('flash_message_success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_success') !!}</strong>
                        </div>
                        @endif
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Лични настройки</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <form class="row form-dashboard" enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-firm-privacy') }}"
                                name="home_privacy" id="home_privacy" novalidate="novalidate">
                                @csrf
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="privacy-box privacysetting">
                                        <div class="dashboardboxtitle">
                                            <h2>Настройки</h2>
                                        </div>
                                        <div class="dashboardholder">
                                            <ul>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="monthizvestia" name="monthizvestia" value=1 @if($user->monthizvestia
                                                        > 0) checked @endif>
                                                        <label class="custom-control-label" for="monthizvestia">Желая да получавам месечни известия</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="porackiizvestia" name="porackiizvestia" value=1 @if($user->porackiizvestia
                                                        > 0) checked @endif>
                                                        <label class="custom-control-label" for="porackiizvestia">Желая да получавам известия за поръчани стоки и запитвания</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="newizvestia" name="newizvestia" value=1 @if($user->newizvestia
                                                        > 0) checked @endif>
                                                        <label class="custom-control-label" for="newizvestia">Желая да получавам известия за нови продукти</label>
                                                    </div>
                                                </li>
                                            </ul>
                                            <button class="btn btn-common" type="submit">Запиши промените</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('delete-firm-user') }}" name="home_privacy_delete"
                                id="home_privacy_delete" novalidate="novalidate">
                                @csrf
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="privacy-box deleteaccount">
                                        <div class="dashboardboxtitle">
                                            <h2>Изтрий профила</h2>
                                        </div>
                                        <div class="dashboardholder">
                                            <div class="form-group mb-3 tg-inputwithicon">
                                                <div class="tg-select form-control">
                                                    <select name="pricina">
                                                        <option value="0">Избери причина</option>
                                                        <option value="none">Не желая да ползвам вече сайта.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button class="btn btn-common" type="submit">Изтрий профила ми</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
