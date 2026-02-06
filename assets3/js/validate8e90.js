// first captcha code 
var recaptcha_response = '';
function submitUserForm() {
    if(recaptcha_response.length === 0) {
        document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;"> Please Verify Captcha. </span>';
        return false;
    }
    return true;
}

function verifyCaptcha(token) {
    recaptcha_response = token;
    document.getElementById('g-recaptcha-error').innerHTML = '';
}

// first captcha code end


// second captcha code 
var recaptcha_response = '';
function submitUserForm2() {
    if(recaptcha_response.length === 0) {
        document.getElementById('g-recaptcha-error2').innerHTML = '<span style="color:red;"> Please Verify Captcha. </span>';
        return false;
    }
    return true;
}

function verifyCaptcha(token) {
    recaptcha_response = token;
    document.getElementById('g-recaptcha-error2').innerHTML = '';
}

// second captcha code end


// third captcha code 
var recaptcha_response = '';
function submitUserForm3() {
    if(recaptcha_response.length === 0) {
        document.getElementById('g-recaptcha-error3').innerHTML = '<span style="color:red;"> Please Verify Captcha. </span>';
        return false;
    }
    return true;
}

function verifyCaptcha(token) {
    recaptcha_response = token;
    document.getElementById('g-recaptcha-error3').innerHTML = '';
}

// third captcha code end

// ==================================
// ==================================

// first requirement validation code

function myFunction() {
    var regex = /\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9]*[-a-z0-9]/i;
    var regex2 = /[a-zA-Z0-9.-]+\.[a-zA-Z -]/i;
    var value = document.getElementById('youo').value;

    if (regex.test(value) || regex2.test(value) ) {
            
         document.getElementById('warden_id').innerHTML = '<span style="color:red;"> Please Remove Link And Domain Name * </span>';
         document.getElementById("search").disabled = true;
           
    }else{
       document.getElementById("warden_id").innerHTML = " ";
       document.getElementById("search").disabled = false;
    }
   
}
// first requirement validation code end


// second requirement validation code

function myFunction2() {
    var regex = /\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9]*[-a-z0-9]/i;
    var regex2 = /[a-zA-Z0-9.-]+\.[a-zA-Z -]/i;
    var value = document.getElementById('youo2').value;

    if (regex.test(value) || regex2.test(value) ) {
            
         document.getElementById('warden_id2').innerHTML = '<span style="color:red;"> Please Remove Link And Domain Name * </span>';
         document.getElementById("search2").disabled = true;
           
    }else{
       document.getElementById("warden_id2").innerHTML = " ";
       document.getElementById("search2").disabled = false;
    }
   
}
// second requirement validation code end

// ==================================
// ==================================

// first phone validation code 

function PhoneV() {
    
    var validregex = /([9876])\1{0}/g;
    var commregex = /([0-9])\1{5,}$/i;
     var regex = /^\+\d{12}$/;
    var phonevalue = document.getElementById('phone').value;
    
    
     if (validregex.test(phonevalue) === true  &&  commregex.test(phonevalue) === false &&  regex.test(phonevalue) === true ) {
            
        document.getElementById("phoneval22").innerHTML = '';
        document.getElementById("search").disabled = false;
           
        }else{
            
        document.getElementById('phoneval22').innerHTML = '<span style="color:red;">  Please Enter Correct Mobile Number (E.g. +91XXXXXXX..) * </span>';
        document.getElementById("search").disabled = true;
        
        }
}


function PhoneV2() {
    
    var validregex = /([9876])\1{0}/g;
    var commregex = /([0-9])\1{5,}$/i;
     var regex = /^\+\d{12}$/;
    var phonevalue = document.getElementById('phone2').value;
    
    
     if (validregex.test(phonevalue) === true  &&  commregex.test(phonevalue) === false &&  regex.test(phonevalue) === true ) {
            
        document.getElementById("phoneval222").innerHTML = '';
        document.getElementById("search2").disabled = false;
           
        }else{
            
        document.getElementById('phoneval222').innerHTML = '<span style="color:red;">  Please Enter Correct Mobile Number (E.g. +91XXXXXXX..) * </span>';
        document.getElementById("search2").disabled = true;
        
        }
}


function PhoneV3() {
    
        var validregex = /([9876])\1{0}/g;
        var commregex = /([0-9])\1{5,}$/i;
        var regex = /^\+\d{12}$/;
        var phonevalue = document.getElementById('phone3').value;
    
    
     if (validregex.test(phonevalue) === true  &&  commregex.test(phonevalue) === false &&  regex.test(phonevalue) === true ) {
            
        document.getElementById("phoneval223").innerHTML = '';
        document.getElementById("search3").disabled = false;
           
        }else{
            
        document.getElementById('phoneval223').innerHTML = '<span style="color:red;">  Please Enter Correct Mobile Number (E.g. +91XXXXXXX..) * </span>';
        document.getElementById("search3").disabled = true;
        
        }
}


function PhoneV4() {
    
        var validregex = /([9876])\1{0}/g;
        var commregex = /([0-9])\1{5,}$/i;
        var regex = /^\+\d{12}$/;
        var phonevalue = document.getElementById('phone4').value;
    
    
     if (validregex.test(phonevalue) === true  &&  commregex.test(phonevalue) === false &&  regex.test(phonevalue) === true ) {
            
        document.getElementById("phoneval224").innerHTML = '';
        document.getElementById("search4").disabled = false;
           
        }else{
            
        document.getElementById('phoneval224').innerHTML = '<span style="color:red;">  Please Enter Correct Mobile Number (E.g. +91XXXXXXX..) * </span>';
        document.getElementById("search4").disabled = true;
        
        }
}