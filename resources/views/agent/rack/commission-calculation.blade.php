<div class="col-6 ">
    <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ $total_shocks }} Pair</span>
                <small class="m-0 l-h-n">Sales Socks Pair</small>
            </h3>
        </div>
        <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
    </div>
</div>
<div class="col-6 ">
    <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks" style="font-size: 18px;">{{ number_format($total_amount,2) }} Tk</span>
                <small class="m-0 l-h-n">Total Bill</small>
                <input type="hidden" value="{{ number_format($total_amount,2) }}" id="total_bill">
            </h3>
        </div>
        <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
    </div>
</div>
<div class="col-6 ">
    <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ number_format($shop_amount,2) }} TK</span>
                <small class="m-0 l-h-n">Shop Comission</small>
                <input type="hidden" value="{{ number_format($shop_amount,2) }}" id="shop_committion">
            </h3>
        </div>
        <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
    </div>
</div>

<div class="col-6 ">
    <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="selected_shocks"  style="font-size: 18px;">{{ number_format($agent_amount,2) }} TK</span>
                <small class="m-0 l-h-n">Venture Collection</small>
                <input type="hidden" value="{{  number_format($agent_amount,2)  }}" id="agent_committion">
            </h3>
        </div>
        <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
    </div>
</div>


 @if(date('d') <= $bill_collection_last_day->bill_collection_last_day )

<input type="hidden" name="bill_last_date" id="bill_col_last_day" value="{{ ($bill_collection_last_day->bill_collection_last_day)? $bill_collection_last_day->bill_collection_last_day : ''  }}">
<div class="col-12">
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label class="form-label" for="name"> Socks Sale Date </label>

            <input type="date" name="agent_sale_date" class="form-control" id="agent_sale_date" required>

            <div class="valid-feedback">
            </div>
        </div>

    </div>
</div>
@endif


<div class="col-12">
    <button type="button" class="btn btn-sm btn-success waves-effect waves-themed w-100" onclick="voucherGenerateAndSoldOutConfirm()">  
        SOCKS SOLD
    </button>
</div>

