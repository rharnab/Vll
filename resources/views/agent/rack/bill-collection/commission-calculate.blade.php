<div class="col-6 ">
    <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ $total_shocks }} Pair</span>
                <small class="m-0 l-h-n">Sales Socks Pair</small>
            </h3>
        </div>
        <i class="fal fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
    </div>
</div>
<div class="col-6 ">
    <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks" style="font-size: 18px;">{{ number_format($total_amount,2) }} Tk</span>
                <small class="m-0 l-h-n">Total Bill</small>
            </h3>
        </div>
        <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
    </div>
</div>
<div class="col-6 ">
    <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ number_format($shop_amount,2) }} TK</span>
                <small class="m-0 l-h-n">Shop Comission</small>
            </h3>
        </div>
        <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
    </div>
</div>

<div class="col-6 ">
    <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ number_format($agent_amount,2) }} TK</span>
                <small class="m-0 l-h-n">Agent Comission</small>
            </h3>
        </div>
        <i class="fal fa-usd-circle position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
    </div>
</div>

<div class="col-12">
    <button type="button" class="btn btn-sm btn-success waves-effect waves-themed w-100" id="bill_collection_btn" onclick="shocksBillCollection()">  
        BILL COLLECTION
    </button>
</div>

