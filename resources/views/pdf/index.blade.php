<!DOCTYPE html> 

<html> 

<head> 

    <title>Laravel 8 PDF File Download using JQuery Ajax Request Example</title> 

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 

</head> 

<body> 

    @include('pdf.pdf') 

    <div class="text-center pdf-btn"> 

        <button type="button" class="btn btn-info download-pdf">Download Pdf</button> 

    </div> 

</body> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

<script type="text/javascript"> 

    $(".download-pdf").click(function(){ 

 

        var data = ''; 

        $.ajax({ 

            type: 'GET', 

            url: 'generate', 

            data: data, 


            success: function(response){ 
                alert("ok");

                // var blob = new Blob([response]); 

                // var link = document.createElement('a'); 

                // link.href = window.URL.createObjectURL(blob); 

                // link.download = "Sample.pdf"; 

                // link.click(); 

            }, 

            error: function(blob){ 

              

            } 

        }); 

    }); 

 

</script> 

</html> 