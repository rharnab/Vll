@extends('layouts.app')
@section('title','Types')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
            <li class="breadcrumb-item">Parameter</li>
            <li class="breadcrumb-item active">Product Create</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>

        <div class="row">
            <div class="col-xl-6 col-md-12 ">
                <div id="panel-3" class="panel">
                    <div class="panel-hdr">
                        <h2>Product Create Form</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <form id="" action="{{ route('parameter_setup.products.store') }}" method="post" enctype="multipart/form-data">

                            	@csrf


                                <div class="row">
                                    <div class="col-md-6">
                                        
                                        
                                        <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label" for="name">Company Name</label>
                                                    
                                                    <select class="form-control select2" name="com_id" required>
                                                        <option value="">--select--</option>

                                                       
                                                    @foreach($company as $single_company_info)

                                                         
                                                        <option value="{{$single_company_info->id}}">{{$single_company_info->name}}</option>

                                                    @endforeach    
                                                    </select>

                                                    <div class="valid-feedback">
                                                    </div>
                                                </div>
                                            
                                     
                                            </div>


                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label" for="name"> Category Name </label>
                                                    
                                                    <select class="form-control select2" name="cat_id" required>
                                                        <option value="">--select--</option>

                                                       
                                                    @foreach($category as $single_cat_info)

                                                         
                                                        <option value="{{$single_cat_info->id}}">{{$single_cat_info->name}}</option>

                                                    @endforeach    
                                                    </select>

                                                    <div class="valid-feedback">
                                                    </div>
                                                </div>
                                            
                                     
                                            </div>

                                        
                                          <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label" for="name">Company Name</label>
                                                    
                                                    <select class="form-control select2" name="com_id" required>
                                                        <option value="">--select--</option>

                                                       
                                                    @foreach($company as $single_company_info)

                                                         
                                                        <option value="{{$single_company_info->id}}">{{$single_company_info->name}}</option>

                                                    @endforeach    
                                                    </select>

                                                    <div class="valid-feedback">
                                                    </div>
                                                </div>
                                            
                                     
                                            </div>


                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label" for="name"> Category Name </label>
                                                    
                                                    <select class="form-control select2" name="cat_id" required>
                                                        <option value="">--select--</option>

                                                       
                                                    @foreach($category as $single_cat_info)

                                                         
                                                        <option value="{{$single_cat_info->id}}">{{$single_cat_info->name}}</option>

                                                    @endforeach    
                                                    </select>

                                                    <div class="valid-feedback">
                                                    </div>
                                                </div>
                                            
                                     
                                            </div>


                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label" for="name"> Brand</label>
                                                    
                                                    <select class="form-control select2" name="brand" required>
                                                        <option value="">--select--</option>

                                                       
                                                    @foreach($brands as $single_brand_info)

                                                         
                                                        <option value="{{$single_brand_info->id}}">{{$single_brand_info->name}}</option>

                                                    @endforeach    
                                                    </select>

                                                    <div class="valid-feedback">
                                                    </div>
                                                </div>
                                            
                                     
                                            </div>


                                         <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="name"> Brand Size</label>
                                                
                                                <select class="form-control select2" name="brand_sizes" required>
                                                    <option value="">--select--</option>

                                                   
                                                @foreach($brand_sizes as $single_brand_size_info)

                                                     
                                                    <option value="{{$single_brand_size_info->id}}">{{$single_brand_size_info->name}}</option>

                                                @endforeach    
                                                </select>

                                                <div class="valid-feedback">
                                                </div>
                                            </div>
                                        
                                 
                                        </div>


                                          <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="name"> Type</label>
                                                
                                                <select class="form-control select2" name="type" required>
                                                    <option value="">--select--</option>

                                                   
                                                @foreach($types as $single_type_info)

                                                     
                                                    <option value="{{$single_type_info->id}}">{{$single_type_info->types_name}}</option>

                                                @endforeach    
                                                </select>

                                                <div class="valid-feedback">
                                                </div>
                                            </div>
                                
                         
                                        </div>

                               
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="name"> Packet Socks Pair Quantity</label>
                                                
                                                <select class="form-control select2" name="packet_socks_pair_quantity" required>
                                                    <option value="">--select--</option>
                                                    <option value="1">1</option>
                                                    <option value="6">6</option>
                                                    <option value="12">12</option>

                                                </select>

                                                <div class="valid-feedback">
                                                </div>
                                            </div>
                                        
                                        </div>

                                    </div>


                                    <div class="col-md-6">
                                         <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Packet Buying Price</label>
                                        
                                        <input type="text" name="packet_buying_price" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name"> Packet Selling Price</label>
                                        
                                        <input type="text" name="packet_selling_price" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Individual Buying Price</label>
                                        
                                        <input type="text" name="ind_buying_price" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Individual Selling Price</label>
                                        
                                        <input type="text" name="ind_selling_price" class="form-control" required>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
                                </div>


                                 <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="name">Select Type</label>
                                        
                                        <select class="form-control select2" name="select_type" required>
                                            <option value="">--select--</option>
                                            <option value="1">Single</option>
                                            <option value="2">Rak</option>
                                        </select>

                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                
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
