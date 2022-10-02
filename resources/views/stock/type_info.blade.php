<select class="select2 custom-select type_check_{{ $index_id }}" name="addmore[{{ $index_id }}][type]" required="" >
    <option value="">State Type</option>
    @foreach($type_info as $single_type)
    <option value="{{ $single_type->id }}">{{ $single_type->types_name }} </option>
    @endforeach
   
</select>