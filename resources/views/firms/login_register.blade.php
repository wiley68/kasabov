@extends('layouts.frontLayout.front_design')
@section('content')
<!-- Content section Start -->
<section class="login section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <p>Ако вече имате регистрация в магазина ни, можете да използвате формата в ляво за директно влизане във вашия профил. Ако все още нямате регистрация можете да си направите такава, използвайки формата в дясно. Възползвайте се от всички възможности, които Ви предлага регистрацията при нас.</p>
        </div>
    </div>
    <hr />
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-12 col-xs-12">
                @if (Session::has('flash_message_error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
                @endif
                <div class="login-form login-area">
                    <h3>Вече имам регистрация</h3>
                    <form class="login-form" id="login_form" name="login_form" action="{{ route('firm-login') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-envelope"></i>
                                <input type="email" id="login_email" class="form-control" name="login_email" placeholder="Потребителски e-mail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input type="password" id="login_password" name="login_password" class="form-control" placeholder="Парола">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control"></div>
                            <a class="forgetpassword" href="#">Забравена парола?</a>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-common log-btn">Вход</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 col-xs-12"></div>
            <div class="col-lg-5 col-md-12 col-xs-12">
                <div class="register-form login-area">
                    <h3>Създай регистрация</h3>
                    <form class="login-form" id="register_form" name="register_form" action="{{ route('firm-register') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-user"></i>
                                <input type="text" id="register_name" class="form-control" name="register_name" placeholder="Име">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-envelope"></i>
                                <input type="email" id="register_email" class="form-control" name="register_email" placeholder="Потребителски e-mail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input type="password" id="register_password" name="register_password" class="form-control" placeholder="Парола">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input type="password" id="register_password_again" name="register_password_again" class="form-control" placeholder="Повтори паролата">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkedall">
                                <label class="custom-control-label" for="checkedall">Регистрирайки се Вие приемате нашите Правила за работа</label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-common log-btn">Регистрация</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Content section End -->
@endsection
