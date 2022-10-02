        

        <footer class="footer navbar-fixed-bottom for_big_sc">
            
                <div class="row">
                    <div class="col-md-6">
                        <p class="mt-2" style="margin-right: 26%;">&copy; @lang('landing.copyright') </p>
                    </div>

                    <div class="col-md-6">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">                 
                            <ul class="navbar-nav mr-auto" style="margin-top: -7px;">

                            <li class="nav-item active">
                                <a class="nav-link" href="{{url('/')}}">@lang('landing.home')   <span class="sr-only">(current)</span> <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li>

                              <!-- <li class="nav-item ">
                                <a class="nav-link" href="#">@lang('landing.Terms')   <span class="sr-only">(current)</span> <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li> -->

                              <li class="nav-item">
                                <a class="nav-link" download="" href="{{ asset('public/saller/দোকান নিবন্ধন ফরম-Final-Edit-1.pdf') }}">@lang('landing.registration_form')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a> 
                              </li>

                              <li class="nav-item">
                                <a class="nav-link" href="#"> @lang('landing.about_us')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li>

                             <li class="nav-item">
                                <a class="nav-link" href="{{url('contact')}}">@lang('landing.contact_us')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li>


                              <!--  <li class="nav-item">
                                <a class="nav-link" href="{{url('/gallary')}}">@lang('landing.gallary')  <span style="border-right: 1.5px solid black;height: 5px; margin-left: 10px;"></span></a>
                              </li> -->


                              <li class="nav-item">
                                <a class="nav-link" href="https://www.facebook.com/Venture-LifeStyle-Limited-110550761466578" target="_blank" ><b><i class="fab fa-facebook-square" style="color: #27a7e2;font-size: 18px;"></i></b></a>
                              </li>
                              
                            </ul>
                           
                         
                        </nav>
                    </div>
                </div>
            
        </footer>


        <div class="row for_mobile" style="margin-top: 10%;display: none;">
            <div class="col-md-12">

               


                <ul class="list-group text-center">
                  <li class="list-group-item"><a class="nav-link" href="{{url('/')}}"> @lang('landing.home') </a></li>
                  <!-- <li class="list-group-item"><a class="nav-link" href="#">@lang('landing.Terms') </a> </li> -->
                  <li class="list-group-item"><a class="nav-link" download="" href="{{ asset('public/saller/দোকান নিবন্ধন ফরম-Final-Edit-1.pdf') }}">@lang('landing.registration_form') </a> </li>
                  <li class="list-group-item"><a class="nav-link" href="#">@lang('landing.about_us') </a></li>
                  <li class="list-group-item"><a class="nav-link" href="{{url('/contact')}}">@lang('landing.contact_us') </a> </li>
                  <!-- <li class="list-group-item"><a class="nav-link" href="{{url('/gallary')}}">@lang('landing.gallary') </a> </li> -->
                  <li class="list-group-item"> @lang('landing.copyright')  </li>
                  
                </ul>

            </div>
        </div>

      <script src="{{ asset('public/backend/assets/js/vendors.bundle.js') }}"></script>
        <script src="{{ asset('public/backend/assets/js/app.bundle.js') }}"></script>
        <script src="{{ asset('public/backend/assets/js/formplugins/validator/validate.min.js') }}"></script>
        <script src="{{ asset('public/backend/assets/js/validator/formplugins/additional-method.min.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>

         <script>
            $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                autoplay:true,
                autoplayTimeout:5000,
                responsive: {
                  0: {
                    items: 1,
                    nav: false,
                  },
                  600: {
                    items: 1,
                    nav: false
                  },
                  1000: {
                    items: 1,
                    nav: false,
                    loop: true,
                    margin: 20
                  }
                }
              })
            })
          </script>

          @stack('js')
          
    </body>
</html>

