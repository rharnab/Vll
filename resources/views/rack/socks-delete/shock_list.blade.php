<table id="dt-basic-example" class="table table-bordered table-hover table-striped table-sm w-100">
    <thead class="bg-primary-600 text-uppercase">
        <tr>

            <th>#SL </th>
            <th>Shop Socks Code</th>
            <th>Printed Socks Code</th>
            <th>Packet Code</th>
            <th>Brand Name</th>
            <th>Type Name</th>
            <th>Socks Code</th>
    
        </tr>
        


    </thead>
    <tbody>
        
        @php $sl=1 @endphp
        @foreach($socks_no as $single_socks)
        <tr>
            <td>{{ $sl++ }} <br> <input  onclick="single_checkbox()" type="checkbox"  value="{{ $single_socks->printed_socks_code }}" name="socks_code[]"> </td>
            <td><label for="{{ $single_socks->printed_socks_code }}">{{ $single_socks->shop_socks_code }}</label></td>
            <td>{{ $single_socks->printed_socks_code }}</td>
            <td> {{ $single_socks->print_packet_code == '' ? $single_socks->style_code : $single_socks->print_packet_code }}</td>
            <td>{{ $single_socks->brand_name }}</td>
            <td>{{ $single_socks->types_name }}</td>
            <td>{{ $single_socks->shocks_code }}</td>
        </tr>
        @endforeach

    </tbody>
</table>
<!-- datatable end -->

