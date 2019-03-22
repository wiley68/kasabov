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
                    <li><a class="facebook" href="#"><i class="lni-facebook-filled"></i></a></li>
                    <li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
                    <li><a class="linkedin" href="#"><i class="lni-linkedin-fill"></i></a></li>
                    <li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
                <div class="widget">
                  <h3 class="block-title">Quick Link</h3>
                  <ul class="menu">
                    <li><a href="#">- About Us</a></li>
                    <li><a href="#">- Blog</a></li>
                    <li><a href="#">- Events</a></li>
                    <li><a href="#">- Shop</a></li>
                    <li><a href="#">- FAQ's</a></li>
                    <li><a href="#">- About Us</a></li>
                    <li><a href="#">- Blog</a></li>
                    <li><a href="#">- Events</a></li>
                    <li><a href="#">- Shop</a></li>
                    <li><a href="#">- FAQ's</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
                <div class="widget">
                  <h3 class="block-title">За контакт</h3>
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

      <!-- Preloader -->
      <!--<div id="preloader">
        <div class="loader" id="loader-1"></div>
      </div>-->
      <!-- End Preloader -->
