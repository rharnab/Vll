@extends('layouts.app')
@section('title','Agent-Dashboard')

@push('css')

 


@endpush
@section('content')
<!-- BEGIN Page Content -->
    <main id="js-page-content" role="main" class="page-content">
        
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-transform: uppercase; font-weight:bold; text-align:center">
                    <i class="fa fa-user"></i> &nbsp; {{Auth::user()->name }} ( {{ Auth::user()->role->name }} )
                </h4>

                <h4 style="text-transform: uppercase; font-weight:bold; text-align:center">
                    <input type="text" class="form-control" id="search_shop" placeholder="Search shop name or Rack code" >
                </h4>

                

            </div>
        </div>

        <br>
        <div class="row">

            @foreach($shop_racks as $shop_rack)
               
                    

                    <div class="col-sm-6 col-xl-3 show_result" >
                        
                        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white">
                            <div class="">
                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                     {{ $shop_rack->shop_name }}
                                    <small class="m-0 l-h-n"> {{ $shop_rack->rack_code }} </small>
                                </h3>
                            </div>
                            <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                        </div>

                        <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white mb-g">
                           
                        <div class="row"> 

                            <div classs="col-xl-6 col-md-6 col-xl-12">
                                <a href="{{ route('agent.shopkeeper.update', [Crypt::encrypt($shop_rack->rack_code)]) }}" class="text-dark"> <span style="font-size: 16px; margin-left: 10px; " > <i class="fas fa-star"></i> Update By Shopkeeper</span> </a> 
                            </div>

                            <div classs="col-xl-6 col-md-6 col-xl-12 ">
                                <a href="{{ route('agent.rack.details', [Crypt::encrypt($shop_rack->rack_code)]) }}" class="text-dark"> <span style="font-size: 16px; margin-left: 10px;" > <i class="fas fa-star"></i> Update By {{ Auth::user()->name }}</span> </a> 
                            </div>

                        </div>
                    
                    </div>
                       
                    </div>
                    
            @endforeach

        </div>
        <div class="row" id="show_search">
            
        </div>
        




    </main>
@endsection

@push('js')


<script>
    $('#search_shop').keyup(function(){
        var search_shop = $('#search_shop').val();

        if(search_shop !='')
        {
        $.ajax({

            type : "post",
            url : "{{ route('all_agent.search_shop') }}",
            data : {
                'search_shop'  : search_shop,
                '_token'  : '{{ @csrf_token() }}',

            },

            success:function(data)
            {
                
                if(data !='')
                {
                    $('.show_result').hide();
                    $('#show_search').html(data);
                }else{
                    $('.show_result').show();
                    $('#show_search').hide();
                }
               
               console.log(data)
            }
        });
    }else{
        $('.show_result').show();
    }
        
    })
</script>



@endpush
