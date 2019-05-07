<?php use App\Product; ?>
<?php use App\Holiday; ?>
<?php use App\Category; ?>
<?php use App\Tag; ?>
<?php use App\Speditor; ?>
<?php use App\City; ?>
<?php use App\Order; ?>
<?php use App\User; ?>
@extends('layouts.adminLayout.admin_design')
@section('content')
<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="{{ route('admin.dashboard') }}" title="Панел управление" class="tip-bottom"><i class="icon-home"></i> Панел управление</a></div>
    </div>
    <!--End-breadcrumbs-->

    <!--Action boxes-->
    <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
                <li class="bg_lb"><a href="{{ route('admin.dashboard') }}"><i class="icon-dashboard"></i>Панел управление</a></li>
                <li class="bg_lg"><a href="{{ route('admin.view-products') }}"><i class="icon-th"></i><span class="label label-success">{{ Product::count() }}</span> Продукти</a>                    </li>
                <li class="bg_ly"><a href="{{ route('admin.view-holidays') }}"><i class="icon-inbox"></i><span class="label label-success">{{ Holiday::count() }}</span> Празници</a>                    </li>
                <li class="bg_lo"><a href="{{ route('admin.view-categories') }}"><i class="icon-th"></i><span class="label label-success">{{ Category::count() }}</span> Категории</a></li>
                <li class="bg_ls"><a href="{{ route('admin.view-tags') }}"><i class="icon-fullscreen"></i><span class="label label-success">{{ Tag::count() }}</span> Етикети</a></li>
                <li class="bg_lo"><a href="{{ route('admin.view-speditors') }}"><i class="icon-th-list"></i><span class="label label-success">{{ Speditor::count() }}</span> Доставчици</a></li>
                <li class="bg_ls"><a href="{{ route('admin.view-cities') }}"><i class="icon-tint"></i><span class="label label-success">{{ City::count() }}</span> Населени места</a></li>
                <li class="bg_lb"><a href="{{ route('admin.edit-landing-page') }}"><i class="icon-pencil"></i> Настройки</a></li>
            </ul>
        </div>
        <!--End-Action boxes-->

        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="icon-chevron-down"></i></span>
                    <h5>Последни заявки</h5>
                </div>
                <div class="widget-content nopadding collapse in" id="collapseG2">
                    <ul class="recent-posts">
                        @php
                            $orders = Order::all()->take(3);
                        @endphp
                        @foreach ($orders as $order)
                        <li>
                            <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{ asset('images/backend_images/demo/av1.jpg') }}">                                </div>
                            <div class="article-post"> <span class="user-info"> От: {{ User::where(['id'=>$order->user_id])->first()->name }} / Дата: {{ date("d.m.Y H:i:s", strtotime($order->created_at)) }} </span>
                                <p>{!! $order->message !!}</p>
                            </div>
                        </li>
                        @endforeach
                        <li>
                            <a href="{{ route('admin.view-orders') }}" class="btn btn-warning btn-mini">Виж всички</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end-main-container-part-->
@endsection
