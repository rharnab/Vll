@extends('layouts.app')
@section('title','User Profile')

@push('css')
<style>
    .profile a:hover {
  text-decoration: none; }

    .profile h1 {
    color: #00B0EF;
    font-weight: 300;
    margin-top: 30px;
    margin-bottom: 0;
    font-size: 30px; }

    .profile h2 {
    font-weight: 400;
    margin: 0;
    font-size: 25px; }

    .profile .info-box h2 {
    font-family: 'serif';
    font-weight: 400;
    margin: 0;
    color: #00B0EF;
    font-size: 20px; 
}

    .profile .info-box p {
    font-family: verdana;
    font-weight: 300;
    font-size: 16px; }

    .pull-right {
        float: right !important;
    }

    th{
        color: #00b0ef;
    }
</style>

@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item active">User Profile</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12  col-sm-12">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>User Profile</h2>
                    <!-- <a href="" class="btn btn-info  btn-sm pull-right"><i class="fas fa-edit"></i></a> -->
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                            data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                            data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                            data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                <div class=" profile">



<div class="panel-body">

    <div class="row text-center">

        <div class="col-md-12 mt-6">
           
        <?php
            if (!empty($get_user_data->image)) {

                ?>
                <img src="{{ asset('uploads/user_image')}}/{{$get_user_data->image}}" class="img-thumbnail" width="150px" height="150px">
           
           <?php
            }else{ ?>
                <img src="{{ asset('public/backend/assets/img/avatar.png') }}" class="img-thumbnail" width="150px" height="150px">
            
            <?php 
            }
            ?>
           

            <h1> {{$get_user_data->name}}</h1>

            <h2>{{$get_user_data->role_name}}</h2>

          

        </div>

        <div class="col-md-6 info-box mt-3">

            <h2> <i class="fas fa-envelope"></i> Email Address</h2>

            {{$get_user_data->email}}

        </div>

        <div class="col-md-6 info-box mt-3">

            <h2><i class="fas fa-phone-volume"></i> Personal Phone</h2>
            {{$get_user_data->mobile_number}}
           

        </div>

       

    
    </div>  <!-- end row text-center -->
   
    <table class="table table-bordered table-striped table-hover" style="margin-top:30px;">
        

        <!-- shopkeeper role -->


        <?php
       
        if(Auth::user()->role_id=='6'){
            ?>

        
        
        <tr>
            <th ><i class="fas fa-store-alt"></i> &nbsp; Shop No</th>
            <td>{{$get_user_data->shop_no}}</td>
        </tr>

        <tr>
            <th><i class="fas fa-location-arrow"></i> &nbsp; Shop Address</th>
            <td>{{$get_user_data->shop_address}}</td>
        </tr>

        <tr>
            <th> <i class="fas fa-building"></i> &nbsp; Market Name</th>
            <td>{{$get_user_data->market_name}}</td>
        </tr>

        <tr>
            <th> <i class="fas fa-location-arrow"></i> &nbsp; Area</th>
            <td>{{$get_user_data->area}}</td>
        </tr>

        <tr>
            <th> <i class="fas fa-city"></i> &nbsp; Division</th>
            <td>{{$get_user_data->division_name}}</td>
        </tr>

        <tr>
            <th><i class="fas fa-city"></i> &nbsp; District</th>
            <td>{{$get_user_data->district_name}}</td>
        </tr>

        <tr>
            <th><i class="fas fa-user-circle"></i> &nbsp; Owner Name</th>
            <td>{{$get_user_data->owner_name}}</td>
        </tr>

        <tr>
            <th> <i class="fas fa-phone-volume"></i> &nbsp; Contact Person</th>
            <td>{{$get_user_data->select_contact}}</td>
        </tr>

        <tr>
            <th><i class="fas fa-user-tie"></i> &nbsp; Manager Name</th>
            <td>{{$get_user_data->manager_name}}</td>
        </tr>

        <tr>
            <th><i class="fas fa-tags"></i> &nbsp; Shop Type</th>
            <td>{{$get_user_data->shop_type}}</td>
        </tr>

        <tr>
            <th> <i class="fas fa-location-arrow"></i> &nbsp; Shoping Place</th>
            <td>{{$get_user_data->shoping_place}}</td>
        </tr>

        <tr>
            <th><i class="fas fa-calendar-times"></i> &nbsp; Shop Weekend Day</th>
            <td>{{$get_user_data->shop_weekend_day}}</td>
        </tr>

       <?php 

        }

        ?>


        <tr>
            <th> <i class="fas fa-id-card"></i> &nbsp; NID No</th>
            <td> {{$get_user_data->nid_number}}</td>
        </tr>

        <tr>
            <th><i class="fas fa-location-arrow"></i> &nbsp; Present Address</th>
            <td>{{$get_user_data->present_address}}</td>
        </tr>

       
        <tr>
            <th> <i class="fas fa-location-arrow"></i> &nbsp; Permanent Address</th>
            <td>{{$get_user_data->permanent_address}}</td>
        </tr>

        
    </table>
</div>

</div>
                </div>

            </div>
        </div>   <!-- end col-xl-12 col-md-12 col-lg-12  col-sm-12 -->
       

    </div>
</main>




@endsection

@push('js')

<script>
$('#password-confirm').on('keyup', function() {
    var password = $('#password').val();
    var password_confirm = $('#password-confirm').val();
    if (password != '') {
        if (password_confirm === password) {

            $('.error_feedback').html('');

        } else {

            $('.error_feedback').html('Sorry Password not match');


        }
    }

});
</script>





@endpush