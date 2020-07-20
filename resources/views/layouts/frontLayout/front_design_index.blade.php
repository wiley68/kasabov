<?php use App\LandingPage; ?>
<?php use App\Http\Controllers\IndexController; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    @php
    $meta_title = "PartyBox - помощници в организацията на вашия празник!";
    $meta_decription = "Помагаме Ви да организирате най-доброто парти за вашия важен повод! Грижим се вашето събитие да бъде незабравимо!";
    $meta_keywords = "парти, организация, повод, празник, рожден ден, имен ден, юбилей, кръщене, сватба";
    
    if(Route::current() != null && Route::current()->getName() == 'post' && isset($post)){
        $meta_title = $post->meta_title;
        $meta_decription = $post->meta_description;
        $meta_keywords = $post->meta_keywords;
    }
    if(Route::current() != null && Route::current()->getName() == 'blog'){
        $meta_title = "PartyBox - Блог";
    }
    if(Route::current() != null && Route::current()->getName() == 'help'){
        $meta_title = "PartyBox - Помощ";
    }
    if(Route::current() != null && Route::current()->getName() == 'obshti-uslovia'){
        $meta_title = "PartyBox - Общи условия";
    }
    if(Route::current() != null && Route::current()->getName() == 'politika'){
        $meta_title = "PartyBox - Политика на поверителност";
    }
    if(Route::current() != null && (Route::current()->getName() == 'sms' || Route::current()->getName() == 'sms1' || Route::current()->getName() == 'sms2')){
        $meta_title = "PartyBox - SMS услуга";
    }

    @endphp
    <title>{{$meta_title}}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="{{ $meta_decription }}">
    <meta name="keywords" content="{{ $meta_keywords }}">
    @php
        $property = LandingPage::where('id', '>', 0)->first();
        $show = false;
        if (!empty($property)){
            if ($property->maintenance_status == 1){
                $maintenance_ip = explode(",", $property->maintenance_ip);
                foreach ($maintenance_ip as $maintenance_ip_address) {
                    if (($maintenance_ip_address == IndexController::getUserIP()) || ('::1' == IndexController::getUserIP())){
                        $show = true;
                    }
                }
            }else{
                $show = true;
            }
        }
    @endphp
    @if(!$show)
        <meta http-equiv="refresh" content="0; url=/maintenance" />
    @endif
    <!-- index controller -->
    <link rel="stylesheet" href="{{ asset('css/frontend_css/bootstrap.min.css') }}" />
    <link href="{{ asset('fonts/frontend_fonts/css/line-icons.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/frontend_css/slicknav.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend_css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend_css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend_css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend_css/colors/yellow.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/frontend_css/responsive.css') }}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- index controller -->
</head>

<body>

    @include('layouts.frontLayout.front_header_index')

    @yield('content')

    @include('layouts.frontLayout.front_footer_index')

    <!-- index controller -->
    <script src="{{ asset('js/frontend_js/jquery-min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/popper.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/wow.js') }}"></script>
    <script src="{{ asset('js/frontend_js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/frontend_js/main.js') }}"></script>
    <script src="{{ asset('js/frontend_js/form-validator.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/contact-form-script.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/summernote.js') }}"></script>
    <!-- index controller -->
    @yield('scripts')
</body>

</html>