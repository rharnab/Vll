<style type="text/css">
  .entry-meta ul li a,i{
    
    color: gray;
}

.entry-meta ul {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0;
}

</style>



  <div class="rack_product_modal_body_show_details container">
    

    <table class="table table-bordered table-hover table-striped ">
        

         <tr>
            <th>Agent Name</th>
            <td><?php echo $data->agent_name;  ?></td>
        </tr>


        <tr>
            <th>Shop Name</th>
            <td><?php echo $data->shop_name;  ?></td>
        </tr>

        <tr>
            <th>Rack Code</th>
             <td><?php echo $data->rack_code;  ?></td>
        </tr>


         <tr>
            <th>Rack Category</th>
             <td><?php echo $data->rack_category;  ?></td>
        </tr>


         <tr>
            <th>Rack Level</th>
             <td><?php echo $data->rack_level;  ?></td>
        </tr>


         <tr>
            <th>Current Shocks</th>
             <td><?php echo $data->current_shocks;  ?></td>
        </tr>

         <tr>
            <th>Total Count</th>
             <td><?php echo $data->total_count;  ?></td>
        </tr>
        

          <tr>
            <th>Buying Price</th>
             <td><?php echo $data->buying_price;  ?></td>
          </tr>


          <tr>
            <th>Selling Price</th>
             <td><?php echo $data->selling_price;  ?></td>
          </tr>


        


       


    </table>

  

  </div>


   
