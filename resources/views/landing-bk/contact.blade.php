
@extends('layouts.landing_app')

                    
            @section('content')

                    
                    

                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            
                            <div class="row">

                                <div class="col-md-5 col-xs-6 col-sm-6" style="">
                                    <div class="terms" style="background-color: white;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;padding-right: 10px;height:280px;">
                                            
                                            <h5><i class="fa fa-address-card-o" aria-hidden="true"></i> @lang('landing.address'):</h5>
                                            <p>@lang('landing.contact_address')</p>

                                            <h5><i class="fa fa-envelope" aria-hidden="true"></i> @lang('landing.email'):</h5>
                                            <p>info@venturenxt.com</p>


                                            <h4><i class="fa fa-phone" aria-hidden="true"></i> @lang('landing.phone'): </h4>
                                            <p>01712-555117 , 01712126345 , 01927-882070</p>
                                           
                                        </div>
                                </div>

                                <div class="col-md-7 col-xs-6 col-sm-6">
                                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.4245574713177!2d90.41445311429658!3d23.732235095388507!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b945cd0f858b%3A0x286573ca0a68aa48!2sVenture%20Solutions%20Limited!5e0!3m2!1sen!2sbd!4v1640083000739!5m2!1sen!2sbd" width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                                </div>
                            
                        </div>

                            

                        </div>
                    </div>

                   
                </div>
            </div>
        </div>


      
    @endsection

