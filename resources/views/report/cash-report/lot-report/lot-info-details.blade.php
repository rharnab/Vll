     <table  class="table table-bordered  table-hover table-striped table-sm w-100 text-center dataTable table-responsive">
        <thead class="bg-primary-600">
            <tr>
               <th>No</th>
               <th>Brand Name</th>
               <th>Types name</th>
               <th>Size </th>
               <th>Total Packet </th>
               <th>Per  Packet Socks</th>
               <th>total Socks</th>
               <th>Total remaining </th>
               <th>Individual Bye Price </th>
               <th>Individual Sale Price </th>
               <th>Packet DP Price</th>
               <th>Packet TP Price</th>
               <th>Total DP Price</th>
               <th>Total TP Price</th>
            <th>Action</th
                
            </tr>
        </thead>
        <tbody>
            @php
        $sl=1;
        @endphp
        @foreach($lot_details as $single_data)

        <tr>
            
                <td> {{ $sl++ }} </td>
                <td> {{ $single_data->brand_name }}</td>
                <td> {{ $single_data->types_name }}</td>
                <td> {{ $single_data->size_name }}</td>

                <td> {{ $single_data->total_packet }}</td>
                <td> {{ $single_data->per_packet_shocks_quantity }}</td>
                <td> {{ $single_data->total_shocks }}</td>
                <td> {{ $single_data->total_remaining_socks }}</td>
                <td> {{ $single_data->individual_buy_price }}</td>
                <td> {{ $single_data->individual_sale_price }}</td>
                <td> {{ $single_data->packet_buy_price }}</td>
                <td> {{ $single_data->packet_sale_price }}</td>
                <td> {{ $single_data->total_buy_price }}</td>
                <td> {{ $single_data->total_sale_price }}</td>

                <td><a target="_blank" href="{{url('report/cash-report/lot-details-data-edit')}}/{{$single_data->lot_no}}/{{$single_data->cat_id}}/{{$single_data->product_id}}/{{$single_data->type_id}}" class="btn btn-primary btn-sm">Edit</a> </td>

        </tr>

    

        @endforeach
                                                               
        </tbody>
    </table>