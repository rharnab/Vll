<div class="row packets_data">
    <div class="form-group col-md-6 select_2_error">
        <label class="form-label" for="rack_id"> Select Shocks Packet</label>
        <select class=" form-control select2 select_packets" style="text-transform: uppercase" onchange="findRemainnigShocks(this,{{ $index }})"  name="products[{{ $index }}]" required>
            <option value="">Select Shocks Packet</option>
            @foreach($products as $product)
                <option value='{{ $product->style_code  }}'> ( {{ $product->style_code }} ) {{ $product->brand_name }} - {{ $product->types_name }}  - {{ $product->size_name }}</option>
            @endforeach                         
        </select>
    </div>
    <div class="form-group col-md-2">
        <label class="form-label" for="rack_id">Remaining Shocks</label>
        <input type="number" name="remaining_shocks[{{ $index }}]" readonly id="remaining_shocks_{{ $index }}" class="form-control">        
    </div>
    <div class="form-group col-md-2 select_2_error">
        <label class="form-label" for="rack_id">Sale Type</label>
        <select class=" form-control select2" style="text-transform: uppercase" name="sale_types[{{ $index }}]" required>
            <option value="">Sale Types</option>
            <option value="packet">Full-Packet</option>
            <option value="single">Single Socks</option>                                  
        </select>        
    </div>
    <div class="form-group col-md-2">
        <label class="form-label" for="rack_id">Shocks Take</label>
        <input type="number" onkeyup="shockTakeForRack()" required name="shocks_take[{{ $index }}]" class="form-control shocks_take_for_rack">        
    </div>
</div>