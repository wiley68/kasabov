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
                                <a href="#"><img src="{{ asset('images/frontend_images/author/img1.jpg') }}" alt=""></a>
                            </figure>
                            <div class="usercontent">
                                <h3>Здравейте {{ Auth::user()->name }}!</h3>
                                <h4>Потребител</h4>
                            </div>
                        </div>
                        <nav class="navdashboard">
                            <ul>
                                <li>
                                    <a href="{{ route('home') }}">
                                        <i class="lni-dashboard"></i><span>Панел управление</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="active" href="{{ route('home-settings') }}">
                                        <i class="lni-cog"></i><span>Настройки профил</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-adds') }}">
                                        <i class="lni-layers"></i><span>Моите потъчки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-favorites') }}">
                                        <i class="lni-heart"></i><span>Любими</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-privacy') }}">
                                        <i class="lni-star"></i><span>Лични настройки</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout-front-user') }}">
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
                <div class="row page-content">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="inner-box">
                            @if (Session::has('flash_message_success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_success') !!}</strong>
                            </div>
                            @endif
                            <div class="tg-contactdetail">
                                <div class="dashboard-box">
                                    <h2 class="dashbord-title">Настройки за контакт</h2>
                                </div>
                                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-settings') }}" name="home_settings"
                                    id="home_settings" novalidate="novalidate">
                                    @csrf
                                    <div class="dashboard-wrapper">
                                        <div class="form-group mb-3">
                                            <label class="control-label">Име*</label>
                                            <input class="form-control input-md" name="user_name" type="text" value="{{ $user->name }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label">Телефон*</label>
                                            <input class="form-control input-md" name="user_phone" type="text" value="{{ $user->phone }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label">Адрес</label>
                                            <input class="form-control input-md" name="user_address" type="text" value="{{ $user->address }}">
                                        </div>
                                        <div class="form-group mb-3 tg-inputwithicon">
                                            <label class="control-label">Населено място</label>
                                            <div class="tg-select form-control">
                                                <select name="city_id">
                                                <option value="0" @if($user->city_id == 0) selected @endif>Избери населено място</option>
                                                @foreach ($cities as $city)
                                                    @if($city->city === $city->oblast)
                                                    <option value="{{ $city->id }}" @if($user->city_id == $city->id) selected @endif>{{ $city->city }}</option>
                                                    @endif
                                                    @if($city->city !== $city->oblast)
                                                    <option value="{{ $city->id }}" @if($user->city_id == $city->id) selected @endif>{{ $city->city }} - {{ $city->oblast }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="tg-checkbox">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="tg-agreetermsandrules" name="user_agrrement">
                                                <label class="custom-control-label" for="tg-agreetermsandrules">Съгласен съм с <a href="javascript:void(0);">Общите условия</a></label>
                                            </div>
                                        </div>
                                        <button class="btn btn-common" type="submit">Запиши промените</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection