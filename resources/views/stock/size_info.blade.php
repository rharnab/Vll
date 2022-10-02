<select class="select2 custom-select size_check_{{ $index_id }}" name="addmore[{{ $index_id }}][size]" required="" onchange="Product_Check({{ $index_id }})">
    <option value="">State Size</option>
    @foreach($size_info as $single_size_info)
        <option value=" {{ $single_size_info->id }} ">{{ trim($single_size_info->size_name) }}</option>
    @endforeach
</select>