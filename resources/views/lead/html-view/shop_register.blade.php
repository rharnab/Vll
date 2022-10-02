<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="name"> Shops Name <span style="color: red;">*</span></label>

        <input type="text" name="shops_name" class="form-control" required>

        <div class="valid-feedback">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="code">Area <span style="color: red;">*</span></label>
        <select class="form-control select2" name="area" required>
            <option value="">--select--</option>
            @foreach($area_list as $single_area_list)
            <option value="{{$single_area_list->area}}">{{$single_area_list->area}}</option>
            @endforeach
        </select>
        <div class="valid-feedback"></div>
    </div>
</div>




<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="shops_address"> Shops Address <span style="color: red;">*</span></label>
        <input type="text" name="shops_address" class="form-control" required>
        <div class="valid-feedback">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="owner_name">Owner Name <span style="color: red;">*</span></label>
        <input type="text" name="owner_name" class="form-control" required>
        <div class="valid-feedback"></div>

    </div>

</div>

<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="owner_contact_no">Owner Contact No <span style="color: red;">*</span></label>
        <input type="text" name="owner_contact_no" id="owner_contact_no" class="form-control" required>

        <div class="valid-feedback">
        </div>
    </div>

</div>

<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="rack_type">Rack Type <span style="color: red;">*</span></label>
        <select class="form-control select2" name="rack_type" required>
            <option value="">--select Rack--</option>
            <option value="Large">Large</option>
            <option value="Medium">Medium</option>
            <option value="Small">Small</option>
        </select>
        <div class="valid-feedback"></div>
    </div>
</div>