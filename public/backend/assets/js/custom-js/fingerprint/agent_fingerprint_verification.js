function agentFingerprintVerification(successCall, failCall) {
    var uri = "https://localhost:8443/SGIFPCapture";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            fpobject = JSON.parse(xmlhttp.responseText);
            successCall(fpobject);
        }
        else if (xmlhttp.status == 404) {
            failCall(xmlhttp.status)
        }
    }
    xmlhttp.onerror = function () {
        failCall(xmlhttp.status);
    }
    var params = "Timeout=" + "10000";
    params += "&Quality=" + "50";
    params += "&licstr=" + encodeURIComponent(secugen_lic);
    params += "&templateFormat=" + "ISO";
    xmlhttp.open("POST", uri, true);
    xmlhttp.send(params);
}


    var template_1 = "";
    var template_2 = "";     
    function SuccessFunc2(result) {
        if (result.ErrorCode == 0) {
            if (result != null && result.BMPBase64.length > 0) {
                document.getElementById('VERIFICATION_THUMB').src = "data:image/bmp;base64," + result.BMPBase64;
            }
            template_2 = result.TemplateBase64;
            matchScore(succMatch, failureFunc)
        }
        else {
            cuteAlert({
                type      : "error",
                title     : "Fingerprint Verification Failed",
                message   : "Fingerprint Capture Error Code:  " + result.ErrorCode + ".\nDescription:  " + ErrorCodeToString(result.ErrorCode) + ".",
                buttonText: "Try Again"
            });
        }
    }
 
    function ErrorFunc(status) {
        cuteAlert({
            type      : "error",
            title     : "Fingerprint Verification Failed",
            message   : "Check if SGIBIOSRV is running; status = " + status + ":",
            buttonText: "Try Again"
        });
    }
 

 
    function matchScore(succFunction, failFunction) {
        var checkbox   = $('input[name="fingerpint_verification"]:checked').val();
        var fingername =  "AUTH_" + checkbox + "_TEMPLATE";
        var template_1 = $(`#${fingername}`).val();
       var uri = "https://localhost:8443/SGIMatchScore";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                fpobject = JSON.parse(xmlhttp.responseText);
                succFunction(fpobject);
            }
            else if (xmlhttp.status == 404) {
                failFunction(xmlhttp.status)
            }
        }
 
        xmlhttp.onerror = function () {
            failFunction(xmlhttp.status);
        }
       var params = "template1=" + encodeURIComponent(template_1);
       params += "&template2=" + encodeURIComponent(template_2);
       params += "&licstr=" + encodeURIComponent(secugen_lic);
       params += "&templateFormat=" + "ISO";
       xmlhttp.open("POST", uri, false);
       xmlhttp.send(params);
    }
 
    function succMatch(result) {
        
        if (result.ErrorCode == 0) {
            agentFingerprintVerificatinSuccess(result);                 
        }
        else {
            cuteAlert({
                type      : "error",
                title     : "Fingerprint Verification Failed",
                message   : "Error Scanning Fingerprint ErrorCode = " + result.ErrorCode,
                buttonText: "Try Again"
            });
        }
    }

   
 
    function failureFunc(error) {
        cuteAlert({
            type      : "error",
            title     : "Fingerprint Verification Failed",
            message   : "On Match Process, failure has been called",
            buttonText: "Try Again"
        });
    }

    // nice global area, so that only 1 location, contains this information
    // var secugen_lic = "hE/78I5oOUJnm5fa5zDDRrEJb5tdqU71AVe+/Jc2RK0=";   // webapi.secugen.com
    var secugen_lic = "";
 
    function ErrorCodeToString(ErrorCode) {
        var Description;
        switch (ErrorCode) {
            // 0 - 999 - Comes from SgFplib.h
            // 1,000 - 9,999 - SGIBioSrv errors 
            // 10,000 - 99,999 license errors
            case 51:
                Description = "System file load failure";
                break;
            case 52:
                Description = "Sensor chip initialization failed";
                break;
            case 53:
                Description = "Device not found";
                break;
            case 54:
                Description = "Fingerprint image capture timeout";
                break;
            case 55:
                Description = "No device available";
                break;
            case 56:
                Description = "Driver load failed";
                break;
            case 57:
                Description = "Wrong Image";
                break;
            case 58:
                Description = "Lack of bandwidth";
                break;
            case 59:
                Description = "Device Busy";
                break;
            case 60:
                Description = "Cannot get serial number of the device";
                break;
            case 61:
                Description = "Unsupported device";
                break;
            case 63:
                Description = "SgiBioSrv didn't start; Try image capture again";
                break;
            default:
                Description = "Unknown error code or Update code to reflect latest result";
                break;
        }
        return Description;
    }