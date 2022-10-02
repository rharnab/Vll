
<div class="col-sm-6 col-xl-3">
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

