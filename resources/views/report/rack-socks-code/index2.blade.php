@extends('layouts.app')
@section('title','Rack-Code')

@push('css')


@endpush
@section('content')
<!-- BEGIN Page Content -->
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item active">Socks Code Generate</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>

    <div class="row">
        <div class="col-xl-6 col-md-6 ">
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>Socks Code Generate</h2>
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
                    <div class="panel-content">

                        <form id="" action="{{ route('report.socks_code.generate_pdf2') }}" method="post"
                            enctype="multipart/form-data">

                            @csrf


                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="name">Select Rack Code</label>
                                    <select class="form-control select2" name="rack_code" id="rack_code" required>
                                        <option value="">--select--</option>
                                        @foreach($get_rack_info as $single_rack_info)

                                        <option value="{{$single_rack_info->rack_code}}">
                                            {{$single_rack_info->rack_code}}</option>

                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                    </div>
                                </div>


                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="name">Select Socks Code </label>
                                    <select class="form-control select2 socks_code_area" name="socks_code[]" id="socks_code" multiple required>
                                        <option value="">Select Socks Code</option>

                                       
                                    </select>

                                    <div class="valid-feedback">
                                    </div>
                                </div>


                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="name">Select Price Tag</label>
                                    <select class="form-control select2" name="price_tag" required>
                                        <option value="">--select price tag--</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>

                                    <div class="valid-feedback">
                                    </div>
                                </div>


                            </div>




                         <div class="form-row">


                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="code">Starting Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required>

                                    <div class="valid-feedback"></div>

                                </div>

                            </div>


                            <div class="form-row">


                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="code">Ending Date</label>
                                    <input type="date" name="ending_date" id="ending_date" class="form-control"
                                        required>

                                    <div class="valid-feedback"></div>

                                </div>

                            </div>

                            


                            <div
                                class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                                <button class="btn btn-primary ml-auto waves-effect waves-themed submit_btn"
                                    type="submit">Generate PDF</button>
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

   




});
</script>

<script>

$(document).ready(function(){


    $('#rack_code').change(function(){
        var rack_code = $('#rack_code').val();
        if(rack_code !='')
        {
            $.ajax({
                'type': "post",
                'url' : "{{ route('report.socks_code.find_socks_code') }}",
                'data': {
                    "rack_code": rack_code,
                    "_token": "{{ csrf_token() }}"
                },
                beforeSend: function()
                {
                    loaderStart();
                },
                success: function(data)
                {
                   $('.socks_code_area').html(data);

                 console.log(data);
                   
                 
                },
                complete: function(){
                    loaderEnd();
                }
            })
        }
            
    });
});
</script>
@endpush