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
                <div class="login-form login-area">
                    <h3>
                        Вече имам регистрация
                    </h3>
                    <form role="form" class="login-form">
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-envelope"></i>
                                <input type="email" id="login-email" class="form-control" name="email" placeholder="Потребителски e-mail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input type="password" id="login-password" name="login-password" class="form-control" placeholder="Парола">
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
                    <h3>
                        Създай регистрация
                    </h3>
                    <form class="login-form" id="register-form" name="register-form" action="{{ route('users-login-register') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-user"></i>
                                <input type="text" id="register-name" class="form-control" name="register-name" placeholder="Име">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-envelope"></i>
                                <input type="email" id="register-email" class="form-control" name="register-email" placeholder="Потребителски e-mail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input type="password" id="register-password" name="register-password" class="form-control" placeholder="Парола">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input type="password" id="register-password-again" name="register-password-again" class="form-control" placeholder="Повтори паролата">
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
