@extends('layouts.app')
@section('title','Shops Create Form')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Shops Create Form</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-6 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Shops Create Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('parameter_setup.shops.store') }}" method="post" enctype="multipart/form-data">

                            	@csrf



                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Shops Name <span style="color: red;">*</span></label>
                                        
                                        <input type="text" name="shops_name" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>

                                
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Shops No </label>
                                        
                                        <input type="text" name="shops_no" class="form-control">

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name"> Shops Type <span style="color: red;">*</span></label>
                                        
                                       <select name="shop_type" id="" class="form-control select2">
                                           <option value="">--Select--</option>
                                           <option value="Super shop">Super shop</option>
                                           <option value="Ready-made garments">Ready-made garments</option>
                                           <option value="Shoe shop">Shoe shop</option>
                                           <option value="Gym">Gym</option>
                                           <option value="Tailors">Tailors</option>
                                           <option value="Library">Library</option>
                                           
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label " for="name"> Shop place type <span style="color: red;">*</span></label>
                                        
                                       <select name="shoping_place" id="" class="form-control select2">
                                           
                                            <option value="">--Select--</option>
                                                                 
                                           <option value="Market">Market</option>
                                           <option value="Main Road">Main Road</option>
                                           <option value="Sub Road">Sub Road</option>
                                           <option value="In-house">In-house</option>

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
                                                                 
                                           <option value="Saturday">Saturday</option>
                                           <option value="Sunday">Sunday</option>
                                           <option value="Monday">Monday</option>
                                           <option value="Tuesday">Tuesday</option>
                                           <option value="Wednesday">Wednesday</option>
                                           <option value="Thursday">Thursday</option>
                                           <option value="Friday">Friday</option>

                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>

                                
                               


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Shops Address <span style="color: red;">*</span></label>
                                        
                                        <input type="text" name="shops_address" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Market Name </label>
                                            
                                           <input type="text" name="market_name" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Mail Address </label>
                                            
                                           <input type="text" name="mail_address" class="form-control" >

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                                
                                 <div class="form-row" style="display: none">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Address <span style="color: red;">*</span></label>
                                        
                                       <textarea cols="18" name="address" class="form-control" required></textarea>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Contact Person <span style="color: red;">*</span></label>
                                        
                                       <select class="form-control select2" name="select_contact_person">

                                           <option value="">--select--</option>
                                           <option value="owner">Owner</option>
                                           <option value="manager">Manager</option>
                                       </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                         
                                </div>


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Contact No <span style="color: red;">*</span></label>
                                        
                                       <input type="text" name="contact_no" class="form-control" required>

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
                                        <label class="form-label" for="name">District <span style="color: red;">*</span></label>
                                        
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
                                        <label class="form-label" for="name">Upazila</label>
                                        
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
                                        <label class="form-label" for="code">Area <span style="color: red;">*</span></label>
                                            
                                           <input type="text" name="area" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>
                               

                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Owner Name <span style="color: red;">*</span></label>
                                            
                                           <input type="text" name="owner_name" class="form-control" required>

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                 <div class="form-row">
                                   

                                      <div class="col-md-12 mb-3">
                                        <label class="form-label" for="code">Manager Name</label>
                                            
                                           <input type="text" name="manager_name" class="form-control">

                                        <div class="valid-feedback"></div>

                                    </div>
                                    
                                </div>


                                


                                


                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Image </label>
                                        
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
@endpush
