<div class="content-div">
    <div class="form-row">
        <div class="col-md-11 mb-3">
           <hr>
        </div>
        <div class="col-md-1 mb-3"> <button type="button" class="btn btn-danger remove-div">Remove</button> </div>
     </div>
     </span>  
    <div class="single-product">
        <div class="form-row">
            <div class="col-md-4 mb-3">
               <label class="form-label" for="validationCustom01">Product Name <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="product_name[{{ $index_no }}]" placeholder="Product Name" required>
                <div class="invalid-feedback">
                    Please provide a valid brand.
                </div>
            </div>

            <div class="col-md-4 mb-3">
               <label class="form-label" for="validationCustom">Description / Type <span class="text-danger" >*</span></label>
              
               <select name="type_name[{{ $index_no }}]" id="" class="form-control select2" required>
                    <option value="">Select Type</option>
                    @foreach($types as $single_type)
                    <option value="{{ $single_type->id }}">{{ $single_type->types_name }}</option>
                    @endforeach
               </select>
                <div class="invalid-feedback">
                    Please provide a valid type.
                </div>
            </div>

           


            <div class="col-md-4 mb-3">
                <label class="form-label" for="validationCustom">Color / Design Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control color_qty_{{ $index_no }}" onkeyup="TotalQuantity({{ $index_no }})"  name="color_qty[{{ $index_no }}]" placeholder="Color Quantity" required>
                 <div class="invalid-feedback">
                     Please provide a valid type.
                 </div>
             </div>

            

             <div class="col-md-4 mb-3">
                <label class="form-label" for="validationCustom">Lot Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control lot_qty_{{ $index_no }}" onkeyup="TotalQuantity({{ $index_no }})" name="lot_qty[{{ $index_no }}]" placeholder="Lot Quantity" required>
                 <div class="invalid-feedback">
                     Please provide a valid type.
                 </div>
             </div>


           

            <div class="col-md-4 mb-3">
               <label class="form-label" for="validationCustom03"> Total quantity <span class="text-danger">*</span></label>
                 <input type="number" readonly class="form-control total_qty_{{ $index_no }}"   name="total_qty[{{ $index_no }}]" id="validationCustom02" placeholder="Total Quenty"  required>
                <div class="invalid-feedback">
                    Please provide a valid Per Packet quantity.
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="validationCustom03">Single Price <span class="text-danger">*</span></label>
                 <input type="number"  class="form-control single_price_{{ $index_no }}" onkeyup="Totalprice({{ $index_no }})" name="single_price[{{ $index_no }}]" placeholder="Single Price">
             </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="validationCustom03"> Total Price <span class="text-danger">*</span></label>
                  <input type="number" readonly class="form-control total_price_{{ $index_no }}" onkeyup="Totalprice({{ $index_no }})"  name="total_price[{{ $index_no }}]" id="validationCustom02" placeholder="Total Price"  required>
                 <div class="invalid-feedback">
                     Please provide a valid Per Packet quantity.
                 </div>
             </div>
            

    </div> 
    </div>{{-- end-single-product --}}
</div>