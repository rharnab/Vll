
<input type="hidden" name="shop_id" id="shop_id">

<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="name">Select Shop </label>
        <select class="form-control select2" name="rack_code" id="rack_code" onchange="findAllDue()" required>
            <option value="">Select Shop</option>
            @foreach($all_due_shop as $single_shop)
            <option value="{{ $single_shop->rack_code }}">{{ $single_shop->shop_name }}</option>

            @endforeach
        </select>

        <div class="valid-feedback">
        </div>
    </div>


</div>


<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="code">Due Amount </label>
        <input readonly type="text" name="due_amount" class="form-control" id="due_amount" value="0.00" required>
        <div class="valid-feedback"></div>

    </div>
</div>


<div class="form-row" id="full_amount_area">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="code">Full Amount </label>
        <input readonly type="text" name="full_amount" class="form-control" id="full_amount">
        <div class="valid-feedback"></div>

    </div>
</div>


<div class="form-row" id="partial_amount_area" style="display: none">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="code">Partial Amount </label>
        <input readonly type="text" name="partial_amount" class="form-control" id="partial_amount">
        <div class="valid-feedback"></div>

    </div>
</div>

<div class="form-row">
    <div class="col-md-12 mb-3">
        <div class="frame-wrap">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input onclick="paymentAmount()" type="radio" name="is_full" id="full" class="custom-control-input"
                    id="full" value="2" checked>
                <label class="custom-control-label" for="full">Full</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input onclick="paymentAmount()" type="radio" name="is_full" id="partial" class="custom-control-input"
                    id="partial" value="1">
                <label class="custom-control-label" for="partial">Partial</label>
            </div>
        </div>
    </div>
</div>


<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label " for="area"> Payment Mode </label>
        <select name="payemnt_mode" id="payemnt_mode" class="form-control select2" required>
            <option value="">--Select Mode--</option>
            <option value="cash">Cash</option>
            <option value="wallet">Wallet</option>
            <option value="cheque">Cheque</option>
        </select>

        <div class="valid-feedback">
        </div>
    </div>
</div>
