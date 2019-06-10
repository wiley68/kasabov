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
                                    <a href="{{ route('home-firm-adds', ['payed' => 'No']) }}">
                                        <i class="lni-layers"></i><span>Моите оферти</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-orders') }}">
                                        <i class="lni-envelope"></i><span>Поръчки</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="active" href="{{ route('home-firm-payments') }}">
                                        <i class="lni-wallet"></i><span>Плащания</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-firm-privacy') }}">
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
                        @if (Session::has('flash_message_error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{!! session('flash_message_error') !!}</strong>
                        </div>
                        @endif
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Създаване на плащане</h2>
                        </div>
                        <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('home-firm-payment-new') }}"
                            name="home_firm_payment_new" id="home_firm_payment_new" novalidate="novalidate">
                            @csrf
                            <input type="hidden" name="payment_user" id="payment_user" value="{{ $user->id }}">
                            <div class="dashboard-wrapper">
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Тип плащане</label>
                                    <select name="payment_type" id="payment_type" style="width:100%;">
                                        <option value="bank" selected>Банка</option>
                                        <option value="sms">SMS</option>
                                        <option value="kurier">Наложен платеж</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:flex">
                                    <label style="width:200px;">Относно</label>
                                    <select name="payment_forthe" id="payment_forthe" style="width:100%;">
                                        <option value="standart" selected>Стандартно (цена: {{ $property->paket_standart }} лв. 20 продукта , действа {{ $property->paket_standart_time }} дни)</option>
                                        <option value="reklama1">Пакет 1 промо продукт (цена: {{ $property->paket_reklama_1 }} лв. действа {{ $property->paket_reklama_1_time }} дни)</option>
                                        <option value="reklama3">Пакет 3 промо продукта (цена: {{ $property->paket_reklama_2 }} лв. действа {{ $property->paket_reklama_2_time }} дни)</option>
                                    </select>
                                </div>
                                <button class="btn btn-common" type="submit">Направи плащането</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
