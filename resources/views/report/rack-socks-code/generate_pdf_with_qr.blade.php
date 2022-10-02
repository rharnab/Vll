
<!DOCTYPE html>
<html>
<head>
    <title>VLL Socks</title>

    <style type="text/css">
        table, td, th {     
      border: 1px solid black;
      text-align: left;
      
    }

table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 18.89px;
  
  
  
}

th{
  padding: 10px;
  
}


.price{
    font-size: 12px;
    font-weight: 'bold';
}

.devider{
    margin-bottom:29px;
}
    </style>
    <?php if($price_tag == 1){
        
        ?>
            <style>
                td{
                padding-top:5px;
                padding-bottom:5px;
                padding-left:15px;
                padding-right:15px;
            }
            .undersockscode{
                font-size: 15px;
             
            }

            </style>  
        <?php 
    }else{
        
        ?>
        <style>
               
            .undersockscode{
                font-size: 18px;
                
            }

            </style> 
        <?php
    }
    ?>
</head>
<body>
   
   <h4>With QR</h4>
<p style="font-weight:bold;font-size:12px;"> Shop Name : <?php echo $shop_info->shop_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Contact No : <?php echo $shop_info->contact_no; ?> &nbsp;&nbsp; Address : <?php echo $shop_info->shop_address; ?></p>

<p style="text-align:center;font-weight:bold;font-size:12px;" class="devider">Rack Code : 
    <?php echo $rack_no; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Refil No :  <?php echo $refill_count; ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last Refil Date : <?php echo $date; ?></p>

  

    <table style="margin-left:-13px;">
       <?php 
            $output = '';
            $str = '';
            $etr = '';
            $sl = 1;

           // $resource = asset("public/backend/assets/img/avatar.png");
            $resource =  QrCode::size(300)->generate('RemoteStack');

            $img = '<img style="width:150px; height:100px;" src="'.$resource.'" alt=""> ';

            $new_arr   = [
                "printed_socks_code_array" => [],
                "shop_socks_code_array"    => [],
                "short_code_array"         => [],
                "short_price_array"         => [],
            ];

            foreach($get_data as $key=>$single_get_data){   
                array_push($new_arr['printed_socks_code_array'], $single_get_data->printed_socks_code);
                array_push($new_arr['shop_socks_code_array'], $single_get_data->shop_socks_code);
                array_push($new_arr['short_code_array'], $single_get_data->brand_name);
                array_push($new_arr['short_price_array'], $single_get_data->selling_price);
            }



            for($i=0; $i<count($get_data); $i++){
                // tr row starting
                if($sl == 1){
                    $output.="<tr>";
                }
                $shop_socks_code   = $new_arr['shop_socks_code_array'][$i];
                $short_code        = $new_arr['short_code_array'][$i];
                $print_shocks_code = $new_arr['printed_socks_code_array'][$i];
                $price = $new_arr['short_price_array'][$i];
                
                if(!empty($shop_socks_code)){
                    $finally_shop_socks_code = "<td style='text-align:center;font-weight:bold;padding-top:2px;
                    padding-bottom:2px;
                    padding-left:10px;
                    padding-right:10px;'>
                    <p style='font-size:22px;'>  $img  </p>
                    <p class='undersockscode'  style='font-size: 12px' >
                        $short_code-$print_shocks_code
                    </p>";
                }else{
                    $finally_shop_socks_code = "<td style='text-align:center;font-weight:bold;  padding-top:13px;
                    padding-bottom:13px;
                    padding-left:15px;
                    padding-right:15px;'>
                    <p class='undersockscode' style='font-size: 14px' >
                        $short_code-$print_shocks_code
                    </p>";
                }

                // add tr
                $output.="$finally_shop_socks_code";
                
                if($price_tag == '1'){                    
                     $output .="<p class='price'>
                      MRP - $price TK
                    </p>";
                }
               
                $output .="</td>"; 

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

