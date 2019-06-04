<!DOCTYPE html>
<html lang="en">
<head>
<title>PartyBox</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- index controller -->
<link rel="stylesheet" href="{{ asset('css/frontend_css/bootstrap.min.css') }}" />
<link href="{{ asset('fonts/frontend_fonts/css/line-icons.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/frontend_css/slicknav.css') }}" />
<link rel="stylesheet" href="{{ asset('css/frontend_css/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('css/frontend_css/owl.carousel.css') }}" />
<link rel="stylesheet" href="{{ asset('css/frontend_css/main.css') }}" />
<link rel="stylesheet" href="{{ asset('css/frontend_css/responsive.css') }}" />
<link rel="stylesheet" href="{{ asset('css/frontend_css/front.css') }}" />
<link rel="stylesheet" href="{{ asset('lib/DataTables/datatables.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/backend_css/select2.css') }}"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<!-- index controller -->
</head>
<body>
@if(Route::current()->getName() == 'home-firm-product-edit' || Route::current()->getName() == 'home-firm-product-new')
<script>document.body.className += ' fade-out';</script>
@endif

@include('layouts.frontLayout.front_header')

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
<script src="{{ asset('js/frontend_js/form-validator.min.js') }}"></script>
<script src="{{ asset('js/frontend_js/contact-form-script.min.js') }}"></script>
<script src="{{ asset('js/frontend_js/summernote.js') }}"></script>
<script src="{{ asset('js/frontend_js/front.js') }}"></script>
<script src="{{ asset('js/backend_js/select2.min.js') }}"></script>
<script src="{{ asset('js/frontend_js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/frontend_js/main.js') }}"></script>
<script src="{{ asset('js/frontend_js/register.js') }}"></script>
<script src="{{ asset('js/backend_js/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('select').select2();
        @if(Route::current()->getName() == 'home-firm-product-edit' || Route::current()->getName() == 'home-firm-product-new')
        $('body').removeClass('fade-out');
        @endif
    });
</script>
<!-- index controller -->
@yield('scripts')
</body>
</html>
