// Disables the register button 
$("#register-btn").prop("disabled",true);


$( ".password" ).on('input', function() {
    // Gets the value of both password boxes
    let password = $('#password').val();
    let password2 = $('#password2').val();
    
    // Checks if they match
    if (password === password2) {
        $('.password').addClass(' password-success').removeClass(' password-error');
    }
    else {
        $('.password').addClass(' password-error').removeClass(' password-success');
    }
    
    // Enables the register button if complexity requirements are met
    if (testPassword(password) && password === password2){
        $("#register-btn").prop("disabled", false);
    }else {
        $("#register-btn").prop("disabled", true);        
    }
    
});


/**
 * Validates the password
 * @param password      string password
 * @returns {boolean}   true on success, false on failure
 */
function testPassword(password){
    let cl =' password-check-success';
    
    let regExp = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&*()]).{8,}/;
    
    
    (password.length>=8)?$('#eightCh').addClass(cl):$('#eightCh').removeClass(cl);
    
    (/(?=.*\d)/.test(password))?$('#oneNum').addClass(cl):$('#oneNum').removeClass(cl);
    
    (/(?=.*[a-z])/.test(password))?$('#lowercase').addClass(cl):$('#lowercase').removeClass(cl);
    
    (/(?=.*[A-Z])/.test(password))?$('#uppercase').addClass(cl):$('#uppercase').removeClass(cl);
    
    (/(?=.*[!@#$%&*()])/.test(password))?$('#oneSym').addClass(cl):$('#oneSym').removeClass(cl);
    
    return regExp.test(password);
}


$("form#register").submit(function(e) {
    e.preventDefault();

    // Gets the value of username and both passwords
    let username = $('#username').val();
    let password = $('#password').val();
    let password2 = $('#password2').val();

    $.post("../../../BLL/registerHandler.php",
        {
            action: 'register',
            username: username,
            password: password,
            password2: password2
        },
        function(response){
            // Checks if the user was registered on success returns 
            // to the previous page on failed alert shown
            let info = JSON.parse(response);
            if (info['status'] === "error")
                alert(info['message']);
            if (info['status'] === "success")
                goBack();
        });
});