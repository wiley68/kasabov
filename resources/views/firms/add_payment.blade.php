<?php

use App\Order; ?>
<?php

use App\Product; ?>
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
                            @if ($user->image != null)
                            <figure>
                                <img src="{{ asset('/images/backend_images/users/'.$user->image) }}" alt="">
                            </figure>
                            @endif
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
                                        @php
                                        $products_ids = [];
                                        $products_loc = Product::where(['user_id'=>Auth::user()->id])->get();
                                        foreach ($products_loc as $prod){
                                        $products_ids[] = $prod->id;
                                        }

                                        $order_count = Order::whereIn('product_id', $products_ids)->count();
                                        @endphp
                                        @if($order_count == 0)
                                        <span style="float:right;padding-right:10px;">
                                            <p>{{ $order_count }} бр.</p>
                                        </span>
                                        @else
                                        <span style="float:right;padding-right:10px;">
                                            <p class="order_blink">{{ $order_count }} бр.</p>
                                        </span>
                                        @endif
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
                                <div style="display:none;padding:10px;" id="sms_payment">
                                    <h5>Услуга: <span id="smscodeusluga" style="color:red;"></span></h5>
                                    <p>За да извършите плащането моля изпратете SMS със съдържание <span id="smscode" style="color:red;"></span> на номер <span id="smsnumber" style="color:red;"></span>.</p> 
                                    <p>Ще получите отговор със следното съдържание: "Vashiat kod za dostap e <span id="smscode" style="color:red;">CODE</span>".</p>
                                    <p>Моля въведете получения код <span id="smscode" style="color:red;">CODE</span> в полето по-долу.</p> 
                                    <hr />
                                    <input name="inputcode" id="inputcode" type="text">
                                    <hr />
                                    <p>След въвеждане на получения код <span id="smscode" style="color:red;">CODE</span> натиснете бутона "Направи плащането". При успешно валидиране на попълнения от Вас код <span id="smscode" style="color:red;">CODE</span> ще получите съобщение за успешно плащане. Веднага ще бъдат активирани съответните услуги които сте закупили. Ще можете да направите своите обяви според закупения от Вас пакет.</p>
                                    <br />
                                    <p><span id="smscode" style="color:red;">Важно: </span>Ако по някаква причина, примерно грешно въведен код, не бъде одобрено Вашето плащане, можете да въведете правилния код <span id="smscode" style="color:red;">CODE</span> повторно. Това повторно въвеждане можете да правите в продължение на <span id="smscode" style="color:red;">24</span> часа от изпращането на този SMS и съответно получаването на кода <span id="smscode" style="color:red;">CODE</span>.</p>
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

@section('scripts')
<script type="text/javascript">
    function changeSms(){
        if ($("#payment_type").val() == "sms"){
            if ($("#payment_forthe").val() == "standart"){
                $("#smscode").html("partyboxs");
                $("#smscodeusluga").html("partyboxs");
                $("#smsnumber").html("1092");
            }
            if ($("#payment_forthe").val() == "reklama1"){
                $("#smscode").html("partyboxedin");
                $("#smscodeusluga").html("partyboxedin");
                $("#smsnumber").html("1092");
            }
            if ($("#payment_forthe").val() == "reklama3"){
                $("#smscode").html("partyboxtri");
                $("#smscodeusluga").html("partyboxtri");
                $("#smsnumber").html("1096");
            }
            $("#sms_payment").show();
        }else{
            $("#sms_payment").hide();
        }
    }
    $( document ).ready(function() {
        changeSms();
    });
    $("#payment_type").change(function(){
        changeSms();
    });
    $("#payment_forthe").change(function(){
        changeSms();
    });
</script>    
@endsection
