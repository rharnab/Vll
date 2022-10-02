<div class="form-row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="rack_change_id">Rack Change </label>
            <select class="form-control select2" name="rack_change_id" required>
            <option value="">--select type--</option>
        @foreach($rack_trafer_list as $data)
        <option value="{{ $data->id }}">{{ $data->name }}</option>
        @endforeach
        </select>
        <div class="valid-feedback"></div>
    </div>
</div>



           