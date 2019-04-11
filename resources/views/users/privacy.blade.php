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
                                    <a href="{{ route('home-settings') }}">
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
                                    <a class="active" href="{{ route('home-privacy') }}">
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
                <div class="page-content">
                    <div class="inner-box">
                        <div class="dashboard-box">
                            <h2 class="dashbord-title">Лични настройки</h2>
                        </div>
                        <div class="dashboard-wrapper">
                            <form class="row form-dashboard">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="privacy-box privacysetting">
                                        <div class="dashboardboxtitle">
                                            <h2>Настройки</h2>
                                        </div>
                                        <div class="dashboardholder">
                                            <ul>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="privacysettingstwo">
                                                        <label class="custom-control-label" for="privacysettingstwo">Желая да получавам месечни известия</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="privacysettingsthree">
                                                        <label class="custom-control-label" for="privacysettingsthree">Желая да получавам известия за поръчани стоки и запитвания</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="privacysettingsfour">
                                                        <label class="custom-control-label" for="privacysettingsfour">Желая да получавам известия за нови продукти</label>
                                                    </div>
                                                </li>
                                            </ul>
                                            <button class="btn btn-common" type="submit">Запиши промените</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="privacy-box deleteaccount">
                                        <div class="dashboardboxtitle">
                                            <h2>Изтрий профила</h2>
                                        </div>
                                        <div class="dashboardholder">
                                            <div class="form-group mb-3 tg-inputwithicon">
                                                <div class="tg-select form-control">
                                                    <select>
                                      <option value="none">Избери причина</option>
                                      <option value="none">Причина 1</option>
                                      <option value="none">Причина 2</option>
                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" placeholder="Описание"></textarea>
                                            </div>
                                            <button class="btn btn-common" type="button">Изтрий профила ми</button>
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