      <!-- Footer Section Start -->
      <footer>
        <!-- Footer Area Start -->
        <section class="footer-Content">
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
                <div class="widget">
                  <div class="footer-logo"><img src="{{ asset('images/frontend_images/logo.png') }}" alt=""></div>
                  <div class="textwidget">
                    <p>{{ $property->footer_text }}</p>
                  </div>
                  <ul class="mt-3 footer-social">
                    <li><a class="facebook" href="https://www.facebook.com/partybox.bg" target="_blank"><i class="lni-facebook-filled"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
                <div class="widget">
                  <h3 class="block-title">МЕНЮ</h3>
                  <ul class="menu">
                    <li><a href="#">ОБЩИ УСЛОВИЯ</a></li>
                    <li><a href="#">ПОМОЩ</a></li>
                    <li><a href="#">ПОЛИТИКА ЗА ЛИЧНИ ДАННИ</a></li>
                    <li><a href="#">ПОЛИТИКА ЗА БИСКВИТКИ</a></li>
                    <li><a href="#">PARTYBOX.BG БЛОГ</a></li>
                    <li><a href="#">ВСИЧКИ ОФЕРТИ</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
                <div class="widget">
                  <h3 class="block-title">СВЪРЖИ СЕ С НАС</h3>
                  <ul class="contact-footer">
                    <li>
                      <strong><i class="lni-phone"></i></strong><span>{{ $property->footer_phone1 }} <br> {{ $property->footer_phone2 }}</span>
                    </li>
                    <li>
                      <strong><i class="lni-envelope"></i></strong><span>{{ $property->footer_mail1 }} <br> {{ $property->footer_mail2 }}</span>
                    </li>
                    <li>
                      <strong><i class="lni-map-marker"></i></strong><span><a href="#">{{ $property->footer_address }}</a></span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Footer area End -->

        <!-- Copyright Start  -->
        <div id="copyright">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="site-info text-center">
                  <p>{!! $property->footer_rites !!}</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Copyright End -->
      </footer>
      <!-- Footer Section End -->

      <!-- Go to Top Link -->
      <a href="#" class="back-to-top">
        <i class="lni-chevron-up"></i>
      </a>

      @section('scripts')
      <script>
            // Submit search form on click
            $('#btn_search_form').on('click', function() {
                if (($("#category_id_search option:selected").val() != '0') || ($("#city_id_search option:selected").val() != '0') || ($("#custom_search").val() != '')){
                    if ($("#category_id_search option:selected").val() != '0'){
                        $('#filter_products').append('<input type="hidden" id="category_id" name="category_id[]" />');
                        $('#category_id').val([$("#category_id_search option:selected").val()]);
                    }
                    if ($("#city_id_search option:selected").val() != '0'){
                        $('#filter_products').append('<input type="hidden" id="city_id" name="city_id[]" />');
                        $('#city_id').val([$("#city_id_search option:selected").val()]);
                    }
                    document.forms['filter_products'].submit();
                }else{
                    document.location = "{{ route('products') }}";
                }
            });
      </script>
      @endsection
      <!-- Preloader -->
      <!--<div id="preloader">
        <div class="loader" id="loader-1"></div>
      </div>-->
      <!-- End Preloader -->
