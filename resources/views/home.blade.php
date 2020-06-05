<?php use App\Favorite; ?>
<?php use App\Order; ?>
<?php use App\Reklama; ?>
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
                                <h4>Потребител</h4>
                            </div>
                        </div>
                        <nav class="navdashboard">
                            <ul>
                                <li>
                                    <a class="active" href="{{ route('home') }}">
                                        <i class="lni-dashboard"></i><span>Панел управление</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-settings') }}">
                                        <i class="lni-cog"></i><span>Настройки профил</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home-adds') }}">
                                        <i class="lni-layers"></i><span>Моите поръчки</span>
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
                        <h4 class="widget-title">Реклама</h4>
                        @php
                            $random_count = Reklama::where(['status'=>1])->count();
                            if ($random_count > 3){
                                $random_count = 3;
                            }
                            $reklami = Reklama::where(['status'=>1])->get()->random($random_count);
                        @endphp
                        @foreach ($reklami as $reklama)
                        <div class="add-box">
                            <h5>{{ $reklama->title }}</h5>
                            <p>{{ $reklama->description }}</p>
                            @php
                                if(!empty($reklama->image_small)){
                                    $image_small = asset('/images/backend_images/reklama_small/'.$reklama->image_small);
                                }else{
                                    $image_small = "";
                                }
                            @endphp
                            @if ($image_small != "")
                                @if ($reklama->url != "") <a target="_blank" href="{{ $reklama->url }}"> @endif <img class="img-fluid" src="{{ $image_small }}" alt="{{ $reklama->title }}"> @if ($reklama->url != "") </a> @endif
                            @endif
                        </div>            
                        @endforeach
                    </div>
                </aside>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9">
                <div class="page-content">
                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Панел управление</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <div class="dashboard-sections">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-cog"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-settings') }}">Настройки</a></h2>
                                                <h3>профил</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-heart"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-favorites') }}">Любими</a></h2>
                                                <h3>{{ Favorite::where(['user_id'=>Auth::user()->id])->count() }} налични</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                        <div class="dashboardbox">
                                            <div class="icon"><i class="lni-layers"></i></div>
                                            <div class="contentbox">
                                                <h2><a href="{{ route('home-adds') }}">Моите поръчки</a></h2>
                                                <h3>{{ Order::where(['user_id'=>Auth::user()->id])->count() }} налични</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
