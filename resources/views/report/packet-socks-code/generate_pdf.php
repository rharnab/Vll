<!DOCTYPE html>
<html>
<head>
    <title>Pegasus Socks</title>

    <style type="text/css">
        table, td, th {     
      border: 1px solid black;
      text-align: left;
    }

table {
  border-collapse: collapse;
  width: 100%;
}

th{
  padding: 15px;
}
td{
    padding-top:10px;
    padding-bottom:10px;
    padding-left:15px;
    padding-right:15px;
}
.undersockscode{
    font-size: 8px;
}
    </style>
</head>
<body>
   
<h3 style="text-align:center;">Lot No : 
    <?php echo $rack_no; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Date : <?php echo $date; ?></h3>




    <table >
       <?php 
            $output = '';
            $str = '';
            $etr = '';
            $sl = 1;

           

            $new_arr   = [
                "printed_socks_code_array" => [],
                "shop_socks_code_array"    => [],
                "short_code_array"         => [],
                "type_name_array"         => [],
                "brand_size_array"         => []
            ];

            foreach($get_data as $key=>$single_get_data){   
                array_push($new_arr['printed_socks_code_array'], $single_get_data->print_packet_code);
                array_push($new_arr['short_code_array'], $single_get_data->brand_short_code);
                array_push($new_arr['type_name_array'], $single_get_data->types_name);
                array_push($new_arr['brand_size_array'], $single_get_data->brand_size);
            }

         
          

            for($i=0; $i<count($get_data); $i++){
                // tr row starting
                if($sl == 1){
                    $output.="<tr>";
                }
                $brand_short_code   = $new_arr['short_code_array'][$i];
                $print_shocks_code = $new_arr['printed_socks_code_array'][$i];
                $type_name_array = $new_arr['type_name_array'][$i];
                $brand_size_array = $new_arr['brand_size_array'][$i];
                

                // add tr
                $output.="<td style='text-align:center;font-weight:bold; font-size:14px;'>
                 $print_shocks_code<br>
                <small class='undersockscode'>
                   $brand_short_code<br>
                   $type_name_array-$brand_size_array
                </small>
                </td>"; 

                if($sl == 6){
                    $output.="</tr>";
                    $sl = 0;
                }   

                $sl++;    
              
            }

            $need_td =  $i  % 6 ;
           
            if($need_td != 0){
                for($m=$need_td; $m < 6; $m++){
                    $output.="<td style='text-align:center;font-weight:bold;'>-</td>"; 
                }
 
            }
            
            


            if( (($i + 1) % 6) != 0){
                $output.="</tr>";
            }

           

            echo $output;
       ?>
       

    </table>

    


</body>
</html>

