<div class="col-sm-4 col-xl-3">
    <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="maximum_capacity">{{ $capacity }}</span> Pair
                <small class="m-0 l-h-n">Maximum Capacity</small>
            </h3>
        </div>
        <i class="fal fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
    </div>
</div>

<div class="col-sm-4 col-xl-3">
    <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="collect_shocks">{{ $current_socks }}</span> Pair
                <input type="hidden" id="initial_collect_socks" value="{{ $current_socks }}">
                <small class="m-0 l-h-n">Current Socks</small>
            </h3>
        </div>
        <i class="fal fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
    </div>
</div>

<div class="col-sm-4 col-xl-3">
    <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
        <div class="">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                <span id="remainnig_socks">{{ $remainnig }}</span> Pair
                <input type="hidden" id="initial_remainnig_socks" value="{{ $remainnig }}">
                <small class="m-0 l-h-n">Remainnig Socks</small>
            </h3>
        </div>
        <i class="fal fa-socks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
    </div>
</div>