@extends('layouts.landing_app')
@section('title','Shops Create Form')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        

        <div class="row">
            <div class=" offset-md-2 col-xl-8 col-md-8 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>দোকান নিবন্ধন ফরম </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                           @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @else
                            @endif
                            <form id="shops_create_form" action="{{ route('online.shops.register') }}" method="post" enctype="multipart/form-data">

                            	@csrf



                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> দোকান  নাম  <span style="color: red;">*</span></label>
                                        
                                        <input type="text" name="shops_name" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> দোকান নং  </label>
                                        
                                        <input type="text" name="shops_no" class="form-control" >

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name"> দোকানের ধরন  </label>
                                        
                                       <select name="shop_type" id="" class="form-control select2" required>
                                           <option value="">--Select--</option>
                                           <option value="Super shop">সুপার শপ </option>
                                           <option value="Ready-made garments">গার্মেন্টস </option>
                                           <option value="Shoe shop">জুতার দোকান </option>
                                           <option value="Gym">জিম </option>
                                           <option value="Tailors">টেইলর </option>
                                           <option value="Library">লাইব্রেরী </option>
                                           <option value="DressShop">পোষাকের দোকান </option>
                                           <option value="Footwear">মোজার দোকান </option>
                                           <option value="Cosmetics">কস্মেটিক্স </option>
                                           
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name">  দোকান স্থানের ধরন  <span style="color: red;">*</span></label>
                                        
                                       <select name="shoping_place" id="" class="form-control select2">
                                           
                                            <option value="">--Select--</option>
                                                                 
                                           <option value="Market">মার্কেট </option>
                                           <option value="Main Road">প্রধান সড়ক </option>
                                           <option value="Sub Road">বাইপাস  রোড </option>
                                           <option value="In-house">বাসা - বাড়ি </option>

                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>

                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name"> বন্ধের দিন  </label>
                                        
                                       <select name="shoping_weekend_day" id="" class="form-control select2">
                                           
                                            <option value="">--Select--</option>
                                                                 
                                           <option value="Saturday">শনিবার</option>
                                           <option value="Sunday">রবিবার</option>
                                           <option value="Monday">সোমবার</option>
                                           <option value="Tuesday">মঙ্গলবার</option>
                                           <option value="Wednesday">বুধবার</option>
                                           <option value="Thursday">বৃহস্পতিবার</option>
                                           <option value="Friday">শুক্রবার</option>

                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>

                                
                               


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> দোকানের ঠিকানা  <span style="color: red;">*</span></label>
                                        
                                        <input type="text" name="shops_address" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">মার্কেটের  নাম  </label>
                                            
                                           <input type="text" name="market_name" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>

                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">মালিকের নাম  <span style="color: red;">*</span></label>
                                            
                                           <input type="text" name="owner_name" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="owner_contact_no">মালিকের নাম্বার  <span style="color: red;">*</span></label>
                                        
                                       <input type="text" name="owner_contact_no" id="owner_contact_no" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="owner_email">মালিকের ইমেইল  </label>
                                        
                                       <input type="text" name="owner_email" class="form-control" >

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                <div class="form-row">
                                   

                                   <div class="col-md-12 mb-3">
                                     <label class="form-label" for="code">ম্যানেজারের নাম   </label>
                                         
                                        <input type="text" name="manager_name" class="form-control" >

                                     <div class="valid-feedback"></div>

                                 </div>
                                 
                             </div>

                             <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">ম্যানেজারের নাম্বার  </label>
                                        
                                       <input type="text" name="contact_no" id="contact_no" class="form-control" >

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>




                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">ম্যানেজারের ইমেইল</label>
                                            
                                           <input type="text" name="mail_address" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                                
                                


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">যোগাযোগের মাধ্যম  </label>
                                        
                                       <select class="form-control select2" name="select_contact_person">

                                           <option value="">--select--</option>
                                           <option value="owner">মালিক</option>
                                           <option value="manager">ম্যানেজার </option>
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                               



                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">বিভাগ  <span style="color: red;">*</span></label>
                                        
                                       <select class="form-control select2" name="division" required>
                                           <option value="">--select--</option>
                                           <?php 
                                            $get_div = DB::table('divisions')->get();

                                            foreach($get_div as $single_get_div){
                                                ?>


                                                <option value="{{$single_get_div->id}}">{{$single_get_div->name}}</option>

                                            <?php
                                            }

                                           ?>
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">জেলা  <span style="color: red;">*</span></label>
                                        
                                       <select class="form-control select2" name="district" required>
                                           <option value="">--select--</option>
                                           <?php 
                                            $get_dis = DB::select(DB::raw(" SELECT dis.id, dis.name as district_name, divs.name as division_name FROM districts dis left join  divisions divs on dis.division_id = divs.id "));

                                            foreach($get_dis as $single_get_dis){
                                                ?>


                                            <option value="{{$single_get_dis->id}}">{{$single_get_dis->division_name}} -- {{$single_get_dis->district_name}}</option>

                                            <?php
                                            }

                                           ?>
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>



                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">উপজিলা </label>
                                        
                                       <select class="form-control select2" name="upazila">
                                           <option value="">--select--</option>
                                           <?php 
                                            $get_up = DB::select(DB::raw(" SELECT up.id , up.name as upazila_name, dis.name as district_name FROM `upazilas` up left join districts dis on up.district_id = dis.id"));

                                            foreach($get_up as $single_get_up){
                                                ?>


                                            <option value="{{$single_get_up->id}}">{{$single_get_up->district_name}} -- {{$single_get_up->upazila_name}}</option>

                                            <?php
                                            }

                                           ?>
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                               

                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">এরিয়া  <span style="color: red;">*</span></label>
                                            
                                          
                                            <select class="form-control select2" name="area" required>
                                            <option value="">--select--</option>
                                          
                                            @foreach($area_list as $single_area_list)
                                                <option value="{{$single_area_list->area}}">{{$single_area_list->area}}</option>
                                            @endforeach
                                           
                                       </select>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                               

                                 

                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">অক্ষাংশ </label>
                                            
                                           <input type="text" name="latitude" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                

                                  <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">দ্রাঘিমাংশ </label>
                                            
                                           <input type="text" name="longitude" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                                


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> ছবি  </label>
                                        
                                        <input type="file" name="image" class="form-control">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>
                               
                                
                                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                    <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn" type="submit">Submit form</button>
                                </div>

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
 
@endsection

@push('js')
    <script>

    	




        $(function() {

             var $form = $(this);

            $.validator.setDefaults({
                errorClass: 'help-block',
                highlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .removeClass('has-error');
                }
            });

            /* $.validator.addMethod('code_number', function(value) {
                
                return /\b(88)?01[3-9][\d]{8}\b/.test(value);
            }, 'Please enter valid code number');*/

           


        });





        //tostr message 
         @if(Session::has('message'))
          toastr.success("{{ session('message') }}");
          @endif
    </script>


     <script>
       $.validator.addMethod('owner_contact_no', function(value) {
            return /\b(88)?01[3-9][\d]{8}\b/.test(value);
        }, 'Please enter valid phone number');


        $("#shops_create_form").validate({
            rules: {
                owner_contact_no: {
                    required: true,
                    mobile: true
                }
            },
            messages: {
                owner_contact_no: {
                    required: 'please enter your mobile number',
                }
            },
        });

    </script>

@endpush
