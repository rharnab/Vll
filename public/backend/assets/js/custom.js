
// toaster working section
    toastr.options = {
        "closeButton"      : true,
        "debug"            : true,
        "newestOnTop"      : true,
        "progressBar"      : true,
        "positionClass"    : "toast-top-right",
        "preventDuplicates": true,
        "showDuration"     : 300,
        "hideDuration"     : 100,
        "timeOut"          : 5000,
        "extendedTimeOut"  : 1000,
        "showEasing"       : "swing",
        "hideEasing"       : "linear",
        "showMethod"       : "fadeIn",
        "hideMethod"       : "fadeOut"
    }
    

    function loaderStart(){
        $('.loader-bg').show();
    }


    function loaderEnd(){
        $('.loader-bg').hide();
    }



    loaderEnd();
