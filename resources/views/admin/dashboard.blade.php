<?php use App\Product; ?>
<?php use App\Holiday; ?>
<?php use App\Category; ?>
<?php use App\Tag; ?>
<?php use App\Speditor; ?>
<?php use App\City; ?>
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
                    <h5>Последни поръчки</h5>
                </div>
                <div class="widget-content nopadding collapse in" id="collapseG2">
                    <ul class="recent-posts">
                        <li>
                            <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{ asset('images/backend_images/demo/av1.jpg') }}">                                </div>
                            <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                                <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a>                                    </p>
                            </div>
                        </li>
                        <li>
                            <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{ asset('images/backend_images/demo/av2.jpg') }}">                                </div>
                            <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                                <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a>                                    </p>
                            </div>
                        </li>
                        <li>
                            <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{ asset('images/backend_images/demo/av4.jpg') }}">                                </div>
                            <div class="article-post"> <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                                <p><a href="#">This is a much longer one that will go on for a few lines.Itaffle to pad out the comment.</a>                                    </p>
                            </div>
                            <li>
                                <button class="btn btn-warning btn-mini">View All</button>
                            </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end-main-container-part-->
@endsection
