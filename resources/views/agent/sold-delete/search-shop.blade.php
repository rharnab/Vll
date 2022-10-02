<div class="row">
     
    <div class="col-sm-6 col-xl-3 mt-4" id="show_search">
        <a href="{{ route('agent.sold_delete.rack_sold_information',[Crypt::encrypt($shop_rack[0]->rack_code)]) }}">
         <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white" >
             <div class="">
                <h4 class="display-4 d-block l-h-n m-0 fw-500">
                     <span style="font-size:20px;"> {{ $shop_rack[0]->shop_name }} </span>
                     
                   <small class="m-0 l-h-n">
                   {{ $shop_rack[0]->rack_code }}
                   </small>
                </h4>
             </div>
             <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
          </div>
        </a>
       
    </div>
   
   
 </div>