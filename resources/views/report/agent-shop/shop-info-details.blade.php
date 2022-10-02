     <table  class="table table-bordered  table-hover table-striped table-sm w-100 text-center dataTable">
        <thead class="bg-primary-600">
            <tr>
               <th>No</th>
               <th>Shop Name</th>
               <th>Contact Number</th>
               <th>Shop Address</th>
               <th>Rack Code</th>
               <th>Unsold Socks</th>
               <th>Sold Socks</th>
               <th>Bill Receive Socks </th>
               <th>Bill Receive Amount </th>
               
               
                
            </tr>
        </thead>
        <tbody>
            @php
        $sl=1;
        @endphp
        @foreach($shop_details as $single_data)

        <tr>
            
                <td> {{ $sl++ }} </td>
                <td> {{ $single_data->shop_name }}</td>
                <td> {{ $single_data->contact_no }}</td>
               

                <td> {{ $single_data->shop_address }}</td>
                <td> {{ $single_data->rack_code }}</td>
                <td> {{ $single_data->unsold_socks }}</td>
                <td> {{ $single_data->sold_socks }}</td>
                <td> {{ $single_data->bill_receive_socks }}</td>
                <td> {{ $single_data->bill_receive_amount }}</td>

                

        </tr>

    

        @endforeach
                                                               
        </tbody>
    </table>


    <input type="hidden" value="{{ $shop_details[0]->agent_name }}" id="agent_name">