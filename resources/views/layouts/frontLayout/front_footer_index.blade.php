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
                    <li>
                      <p style="text-align:center;width:100%;">Абонамент за бюлетин</p>
                      <form enctype="multipart/form-data" action="{{ route('abonament') }}" method="post" name="abonament" id="abonament">
                        @csrf
                        <input style="width:100%;margin-bottom:5px;" type="text" name="abonament_email" placeholder="Въведете e-mail адрес">
                        @if(env('GOOGLE_RECAPTCHA_KEY'))
                        <div class="g-recaptcha"
                            data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                        </div>
                        @endif
                        <button class="btn btn-common fullwidth mt-4" type="submit">Абонирай се</button>
                      </form>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
                <div class="widget">
                  <h3 class="block-title">МЕНЮ</h3>
                  <ul class="menu">
                    <li><a href="{{ route('obshti-uslovia') }}">ОБЩИ УСЛОВИЯ</a></li>
                    <li><a href="{{ route('help') }}">ПОМОЩ</a></li>
                    <li><a href="{{ route('politika') }}">ПОЛИТИКА ЗА ЛИЧНИ ДАННИ</a></li>
                    <li><a href="{{ route('politika-biskvitki') }}">ПОЛИТИКА ЗА БИСКВИТКИ</a></li>
                    <li><a href="#">PARTYBOX.BG БЛОГ</a></li>
                    <li><a href="{{ route('products') }}">ВСИЧКИ ОФЕРТИ</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
                <div class="widget">
                  <h3 class="block-title">СВЪРЖИ СЕ С НАС</h3>
                  <ul class="contact-footer">
                    <li>
                      <form enctype="multipart/form-data" action="{{ route('contact') }}" method="post" name="contact" id="contact">
                        @csrf
                        <input style="width:100%;margin-bottom:10px;" type="text" name="contact_name" placeholder="Име">
                        <input style="width:100%;margin-bottom:10px;" type="text" name="contact_email" placeholder="E-Mail">
                        <textarea style="width:100%;height:120px;" name="contact_message" placeholder="Съобщение"></textarea>
                        @if(env('GOOGLE_RECAPTCHA_KEY'))
                          <div class="g-recaptcha"
                              data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                          </div>
                        @endif
                        <button class="btn btn-common fullwidth mt-4" type="submit">Изпрати</button>
                      </form>
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
                  <p>{!! $property->footer_rites !!}</p>
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
 
