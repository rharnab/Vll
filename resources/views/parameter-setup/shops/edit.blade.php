@extends('layouts.app')
@section('title','Shops Edit Form')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Shops Edit Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Shops Edit Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('parameter_setup.shops.update') }}" method="post" enctype="multipart/form-data">

                            	@csrf


                                <input type="hidden" name="hidden_id" class="form-control" value="{{$get_data->id}}">

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Shops Name <span style="color: red;">*</span></label>
                                        
                                        <input type="text" name="shops_name" class="form-control"  value="{{$get_data->name}}" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Shops No </label>
                                        
                                        <input type="text" name="shops_no" class="form-control" value="{{$get_data->shop_no}}">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name"> Shops Type </label>
                                        
                                       <select name="shop_type" id="" class="form-control select2" required>
                                           <option value="">--Select--</option>

                                           <option value="Super shop" 
                                           <?php
                                            if($get_data->shop_type=='Super shop'){
                                                echo "selected";
                                            }
                                            ?>>Super shop</option>

                                           <option value="Ready-made garments"  
                                           <?php
                                            if($get_data->shop_type=='Ready-made garments'){
                                                echo "selected";
                                            }
                                            ?>>Ready-made garments</option>

                                           <option value="Shoe shop" 

                                           <?php
                                            if($get_data->shop_type=='Shoe shop'){
                                                echo "selected";
                                            }
                                            ?>>Shoe shop</option>

                                           <option value="Gym"
                                           <?php
                                            if($get_data->shop_type=='Gym'){
                                                echo "selected";
                                            }
                                            ?>
                                           >Gym</option>
                                           <option value="Tailors"
                                           <?php
                                            if($get_data->shop_type=='Tailors'){
                                                echo "selected";
                                            }
                                            ?>
                                           >Tailors</option>
                                           
                                           <option value="Library" 
                                           <?php
                                            if($get_data->shop_type=='Library'){
                                                echo "selected";
                                            }
                                            ?>
                                           >Library</option>
                                           
                                           <option value="DressShop" 
                                           <?php
                                            if($get_data->shop_type=='DressShop'){
                                                echo "selected";
                                            }
                                            ?>>DressShop</option>
                                            
                                           <option value="Footwear" 
                                            <?php
                                            if($get_data->shop_type=='Footwear'){
                                                echo "selected";
                                            }
                                            ?>>Footwear</option>
                                           
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name">  Shop place type <span style="color: red;">*</span></label>
                                        
                                       <select name="shoping_place" id="" class="form-control select2">
                                           
                                            <option value="">--Select--</option>
                                                                 
                                           <option value="Market" 
                                           <?php
                                            if($get_data->shoping_place=='Market'){
                                                echo "selected";
                                            }
                                            ?>
                                           >Market</option>

                                           <option value="Main Road" 
                                            <?php
                                            if($get_data->shoping_place=='Main Road'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Main Road</option>

                                           <option value="Sub Road" 
                                            <?php
                                            if($get_data->shoping_place=='Sub Road'){
                                                echo "selected";
                                            }
                                            ?>
                                            >Sub Road</option>

                                           <option value="In-house" 
                                           <?php
                                            if($get_data->shoping_place=='In-house'){
                                                echo "selected";
                                            }
                                            ?>

                                           >In-house</option>

                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>

                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name"> Shop Weekend Day </label>
                                        
                                       <select name="shoping_weekend_day" id="" class="form-control select2">
                                           
                                            <option value="">--Select--</option>
                                                                 
                                           <option value="Saturday" 

                                           <?php
                                            if($get_data->shop_weekend_day=='Saturday'){
                                                echo "selected";
                                            }
                                            ?>
                                            
                                           >Saturday</option>

                                           <option value="Sunday" 
                                           <?php
                                            if($get_data->shop_weekend_day=='Sunday'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Sunday</option>

                                           <option value="Monday" 
                                            <?php
                                            if($get_data->shop_weekend_day=='Monday'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Monday</option>

                                           <option value="Tuesday" 

                                           <?php
                                            if($get_data->shop_weekend_day=='Tuesday'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Tuesday</option>

                                           <option value="Wednesday" 
                                            <?php
                                            if($get_data->shop_weekend_day=='Wednesday'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Wednesday</option>

                                           <option value="Thursday" 

                                            <?php
                                            if($get_data->shop_weekend_day=='Thursday'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Thursday</option>


                                           <option value="Friday" 
                                           
                                           <?php
                                            if($get_data->shop_weekend_day=='Friday'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Friday</option>

                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>

                                
                               


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Shops Address <span style="color: red;">*</span></label>
                                        
                                        <input type="text" name="shops_address" class="form-control" value="{{$get_data->shop_address}}" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Market Name </label>
                                            
                                           <input type="text" name="market_name" value="{{$get_data->market_name}}" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>

                                <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Owner Name <span style="color: red;">*</span></label>
                                            
                                           <input type="text" name="owner_name" value="{{$get_data->owner_name}}" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="owner_contact_no">Owner Contact No <span style="color: red;">*</span></label>
                                        
                                       <input type="text" name="owner_contact_no" value="{{$get_data->owner_contact}}" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        
                                       <label class="form-label" for="owner_email">Owner Email </label>  
                                       <input type="text" name="owner_email" class="form-control" value="{{$get_data->owner_email}}">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                <div class="form-row">
                                   

                                   <div class="col-md-12 mb-3">
                                     <label class="form-label" for="code">Manager Name  </label>
                                         
                                        <input type="text" name="manager_name" class="form-control"  value="{{$get_data->manager_name}}">

                                     <div class="valid-feedback"></div>

                                 </div>
                                 
                             </div>

                             <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Manager Contact No </label>
                                        
                                       <input type="text" name="contact_no" class="form-control" value="{{$get_data->contact_no}}">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>




                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Manager Email</label>
                                            
                                           <input type="text" name="mail_address" class="form-control" value="{{$get_data->mail_address}}">

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                                
                                


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Contact Person </label>
                                        
                                       <select class="form-control select2" name="select_contact_person">

                                           <option value="">--select--</option>
                                           <option value="owner" 
                                           
                                            <?php
                                            if($get_data->select_contact=='owner'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Owner</option>
                                           <option value="manager" 
                                           
                                            <?php
                                            if($get_data->select_contact=='manager'){
                                                echo "selected";
                                            }
                                            ?>

                                           >Manager</option>
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                               



                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Division <span style="color: red;">*</span></label>
                                        
                                       <select class="form-control select2" name="division" required>
                                           <option value="">--select--</option>
                                           <?php 
                                            $get_div = DB::table('divisions')->get();

                                            foreach($get_div as $single_get_div){
                                                ?>


                                                <option value="{{$single_get_div->id}}" 

                                            <?php

                                            if($get_data->division_id==$single_get_div->id){
                                                echo "selected";
                                            }
                                            ?> 
                                            >{{$single_get_div->name}}</option>

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
                                        <label class="form-label" for="name">District <span style="color: red;">*</span></label>
                                        
                                       <select class="form-control select2" name="district" required>
                                           <option value="">--select--</option>
                                           <?php 
                                            $get_dis = DB::select(DB::raw(" SELECT dis.id, dis.name as district_name, divs.name as division_name FROM districts dis left join  divisions divs on dis.division_id = divs.id "));

                                            foreach($get_dis as $single_get_dis){
                                                ?>


                                            <option value="{{$single_get_dis->id}}" 
                                                <?php

                                            if($get_data->district_id==$single_get_dis->id){
                                                echo "selected";
                                            }
                                            ?> 

                                                >{{$single_get_dis->division_name}} -- {{$single_get_dis->district_name}}</option>

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
                                        <label class="form-label" for="name">Upazila</label>
                                        
                                       <select class="form-control select2" name="upazila">
                                           <option value="">--select--</option>
                                           <?php 
                                            $get_up = DB::select(DB::raw(" SELECT up.id , up.name as upazila_name, dis.name as district_name FROM `upazilas` up left join districts dis on up.district_id = dis.id"));

                                            foreach($get_up as $single_get_up){
                                                ?>


                                            <option value="{{$single_get_up->id}}"
                                                  <?php

                                            if($get_data->upazilla_id==$single_get_up->id){
                                                echo "selected";
                                            }
                                            ?> 

                                             >{{$single_get_up->district_name}} -- {{$single_get_up->upazila_name}}</option>

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
                                        <label class="form-label" for="code">Area <span style="color: red;">*</span></label>
                                            
                     
                                            <select class="form-control select2" name="area" required>
                                                <option value="">--select--</option>
                                              
                                                @foreach($area_list as $single_area_list)
                                                    <option value="{{$single_area_list->area}}" @if($get_data->area == $single_area_list->area) {{'selected'}}  @endif>{{$single_area_list->area}}</option>
                                                @endforeach
                                           
                                       </select>
                                       
                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                               

                                 

                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Latitude </label>
                                            
                                           <input type="text" name="latitude" class="form-control" value="{{$get_data->latitude}}">

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                

                                  <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Longitude </label>
                                            
                                           <input type="text" name="longitude" class="form-control" value="{{$get_data->longitude}}">

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                                


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">

                                         @if(!empty($get_data->image))
                                            <img src="{{ asset('uploads/shop_images')}}/{{$get_data->image}}"  width="50" height="50">
                                        @else 
                                            <img src="{{ asset('public/backend/assets/img/avatar.png') }}"  width="50" height="50">
                                        @endif

                                        <br> <br>
                                        <label class="form-label" for="name"> Image </label>
                                        
                                        <input type="file" name="image" class="form-control">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name"> Shop Activation  </label>
                                       <select name="shop_is_active" id="" class="form-control select2">
                                           <option value="">--Select--</option>
                                           <option value="1">Active</option>  
                                           <option value="0">In-Active</option>  
                                       </select>
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
@endpush
