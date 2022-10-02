@extends('layouts.landing_app')

@push('css')




@endpush

                    
            @section('content')
             <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-1 py-lg-1 my-lg-5 px-4 px-sm-0">
                
                    

                      <div class="row responsive_text" >

                        <div  class="col-md-5 col-lg-5 col-sm-12">

                        <div class="card p-4 rounded-plus bg-faded shop-slide" style="height: 280px; margin: 0 0 26px;">
                               
                               <!-- <img class="img-fluid" src="{{ asset('public/slider/banner1.jpg') }}" > -->

                                 <div class="owl-carousel owl-theme">
                                    <div class="item">
                                      <img  style="height: 220px"  src="{{ asset('public/slider/banner1.jpg') }}"  class="img-fluid" alt="Responsive image">
                                    </div>
                                    <div class="item">
                                      <img style="height: 220px"   src="{{ asset('public/slider/banner2.jpg') }}" class="img-fluid" alt="Responsive image">
                                    </div>
                                
                                  </div>
                                
                        </div>    
                                
                           
                       
                            <div class="card p-4 rounded-plus bg-faded shop-login" style="height: auto;">
                                @if(Session::get('errors') || count( $errors ) > 0)
                                    @foreach ($errors->all() as $error)
                                        <span style="color: red; font-weight:bold; font-size:12px;"><strong>{{ $error }}</strong></span>
                                        <hr>
                                    @endforeach
                                @endif
                                <h4 style="font-size:20px; line-height: 24px; color:#3b76bb; text-align: center;">@lang('landing.shopkeeper_login')</h4>
                                <form id="login_form" name="login-form" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="email"> @lang('landing.mobile')</label>
                                        <input type="text"  autocomplete="off" id="email" name="email" class="form-control form-control-sm" placeholder="017*******1" required>                                              
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password"> @lang('landing.password') </label> 
                                        <input type="password" autocomplete="off" id="password" name="password" class="form-control form-control-sm" placeholder="@lang('landing.password')"  required>                                               
                                    </div>
                                   
                                    <div class="row" style="margin: 0 0 15px 0;">
                                        <div class="col-lg-6  reset_btn">
                                            <button type="reset" class="btn btn-info btn-block btn-sm ">@lang('landing.reset')&nbsp;<i class="fas fa-sync-alt"></i></button>
                                        </div>

                                        <div class="col-lg-6">
                                            <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-sm">@lang('landing.login')&nbsp;<i class="far fa-sign-in-alt" ></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>


                        <div class="col-md-7 col-lg-7 col-sm-12">
                            <div class="card" style="border-radius: 10px; height: auto">
                              <div class="card-body">
                                
                                <div class="terms" style="background-color: white; padding: 3px; text-align: justify;">

                                
                                <h2 class="text-danger responsive_h2" style="text-align:center; color: #ff0000; font-weight: bold; font-size: 1.3rem; "> এই শীতে বিক্রেতা ভাইদের জন্য বিশেষ অফার ! ! ! </h2>
                               

                                <h2 style="text-align: center;color: #3972b8;" class="responsive_h2"> <span style="font-weight: bold; font-size: 1.2rem;">পেগাসাস মোজা</span> </h2>

                                <h3 style="text-align: center; font-weight: 600; font-size: 1.1rem;">বিক্রয় করে আয় বাড়ানোর এক</h3>
                                <h2 style="text-align: center;color: #3972b8; " class="responsive_h2"><b style="font-size: 1.1rem;"> বিশেষ সুযোগ </b></h2>

                                <h3 style="text-align: center; font-weight: 600; font-size: 1.1rem; ">নিয়ে এলো Venture Lifestyle Ltd. (১ টি ফ্রী আলনাসহ)  </h3>

                               <br>
                                <p class="responsive_p_center" style="text-align: left;"><span style="color:#fd3995"> **  </span> <span style="font-size: 0.9rem;">নিম্নোক্ত ছক অনুযায়ী সম্মানিত বিক্রেতাগন তাদের লভ্যাংশ বুঝিয়া পাইবেনঃ</span></p>
                                

                                <table class="table table-bordered text-center" style="font-size: 0.9rem; background-color: #27a7e236;">
                                    <tr >
                                        <td  rowspan="2" width="200px"> <span class="mt-4" style="display: block;">বিক্রেতাগনের প্রতি ১০০ জোড়া বিক্রিতে লাভের পরিমান</span> </td>
                                        <td width="100">১-১১৯ জোড়া </td>
                                        <td width="100">১২০ থেকে ১৯৯ জোড়া </td>
                                        <td width="100">২০০ জোড়া এবং তার অধিক </td>
                                    </tr>


                                    <tr>
                                        
                                        <td class="text-center"><b>২০% </b></td>
                                        <td class="text-center"><b>২২% </b></td>
                                        <td class="text-center"><b>২৫% </b></td>
                                    </tr>
                                </table>


                                <br>
                                <h3 style="text-align: center;color: #2196f3; font-size: 1.1rem;">বিক্রেতাগনের দোকান নিবন্ধনের বিশেষ শর্তাবলী : </h3>

                                <p  style="font-size: 0.9rem;">১. প্রতি আলনায় একশত বিশ জোড়া মোজা থাকিবে।</p>





                                
                               <p style="font-size: 0.9rem;">২. প্রতি মাসের মোজা বিক্রয়ের মূল্য আমাদের প্রতিনিধি পরবর্তী মাসের <span class="highlight">৫ </span> তারিখের মধ্যেই সংগ্রহ করিবে এবং কমিশনের অংশ দোকানদারকে নগদ বুঝিয়ে দিবে।</p>

                                  <p style="font-size: 0.9rem;">৩. প্রতি <span class="highlight">পনের দিন </span> অন্তর আমাদের প্রতিনিধি বিগত <span class="highlight">পনের দিনে </span> যে পরিমান মোজা বিক্রয় হইবে তাহার <span class="highlight"> সমপরিমান </span> মোজা আলনায় সরবরাহ করিবে। এছাড়াও আলনার মোজা অধিকাংশ বিক্রয় হয়ে গেলে বিক্রেতাদের যোগাযোগের (ফোন) ভিত্তিতে নতুন মোজা সরবরাহ করা হইবে।.... <a style="font-weight: bold; color: #25AAE2" href="{{url('condition')}}"><span>বিস্তারিত  </span></a></p>



                        
                                


                        
                            </div>



                              </div>
                            </div>
                        </div>

                            
                    </div>
                    
                </div>
            </div>

            <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    

                </div>
            </div>

               
            </div>
        </div>
    </div>

    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>
    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "110550761466578");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>
    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>


    @endsection

    @push('js')

    <script>
       $.validator.addMethod('phone', function(value) {
            return /\b(88)?01[3-9][\d]{8}\b/.test(value);
        }, 'Please enter valid phone number');


        $("#login_form").validate({
            rules: {
                email: {
                    required: true,
                    phone: true
                }
            },
            messages: {
                email: {
                    required: 'please enter your mobile number',
                }
            },
        });

    </script>

    
<script>
    document.getElementById("password").addEventListener("keypress", function(evt) {
        if (evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });
</script>

    @endpush



