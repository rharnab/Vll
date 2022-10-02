<div class="row packets_data" id="row_id_{{ $index }}">
    
    
    <div class="form-group col-md-2 select_2_error">
        <label class="form-label" for="rack_id">Category</label>
        <select class=" form-control select2 select_socks_type" style="text-transform: uppercase" id="cat_{{ $index }}" onchange="findCatType(this,{{ $index }})"   name="cat[{{ $index }}]" required>
            <option value="">Socks Type</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ strtoupper($cat->name) }}</option>
            @endforeach                                
        </select>
    </div>

    <div class="form-group col-md-2 select_2_error">
        <label class="form-label" for="rack_id">Socks Type</label>
        <select class=" form-control select2 select_socks_type" style="text-transform: uppercase" id="type_{{ $index }}" onchange="findTypeSocks(this,{{ $index }})"  name="types[{{ $index }}]" required>
            <option value="">Socks Type</option>
                                       
        </select>
    </div>


    <div class="form-group col-md-3 select_2_error">
        <label class="form-label" for="rack_id"> Select Shocks Packet</label>
        <select class=" form-control select2 select_packets" style="text-transform: uppercase" id="socks_packet_{{ $index }}" onchange="findRemainnigShocks(this,{{ $index }})"  name="products[{{ $index }}]" required>
            <option value="">Select Shocks Packet</option>                                
        </select>
    </div>
    <div class="form-group col-md-2">
        <label class="form-label" for="rack_id">Single Pair Price (TK)</label>
        <input type="number" name="single_pair_price[{{ $index }}]" step="0.01" id="single_pair_price_{{ $index }}" class="form-control">        
    </div>
    <div class="form-group col-md-2">
        <label class="form-label" for="rack_id">Remaining Shocks</label>
        <input type="number" name="remaining_shocks[{{ $index }}]" readonly id="remaining_shocks_{{ $index }}" class="form-control">        
    </div>
    <div class="form-group col-md-2">
        <label class="form-label" for="rack_id">Shocks Take</label>
        <input type="number" onkeyup="shockTakeForRack()" required name="shocks_take[{{ $index }}]" class="form-control shocks_take_for_rack">        
    </div>

    <div class="form-group  col-md-1 select_2_error">
        <label>&nbsp;</label>
        <button  type="button" class="btn btn-danger "  onclick="RemoveField({{ $index }});"><i class="fas fa-trash"></i></button>
    </div>

</div>