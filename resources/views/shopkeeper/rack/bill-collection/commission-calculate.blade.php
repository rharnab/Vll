<div class="col-4" style="display: none">
    <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ $total_shocks }} Pair</span>
                <small class="m-0 l-h-n">Sales Pair</small>
                <input id="new_total_pair" type="hidden" value="{{ $total_shocks }}">
            </h3>
        </div>
        <i class="fal fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
    </div>
</div>
<div class="col-4" style="display: none">
    <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks" style="font-size: 18px;">{{ number_format($total_amount,2) }} Tk</span>
                <small class="m-0 l-h-n">Total Bill</small>
                <input id="new_total_bill" type="hidden" value="{{ number_format($total_amount,2) }}">
            </h3>
        </div>
        <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
    </div>
</div>
<div class="col-4" style="display: none">
    <div class="p-3 bg-primary-200 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ number_format($shop_amount,2) }} TK</span>
                <small class="m-0 l-h-n">Comission</small>
                <input id="new_total_commission" type="hidden" value="{{ number_format($shop_amount,2) }}">
            </h3>
        </div>
        <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
    </div>
</div>

<div class="col-12">
    <button type="button" class="btn btn-sm btn-success waves-effect waves-themed w-100" onclick="shopKeeperSold()">  
        @lang('landing.sold')
    </button>
</div>

