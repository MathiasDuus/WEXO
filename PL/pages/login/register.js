$("#register-btn").prop("disabled",true);


$( ".password" ).on('input', function() {
    let password = $('#password').val();
    let password2 = $('#password2').val();
    
    
    if (password === password2) {
        $('.password').addClass(' password-success').removeClass(' password-error');
    }
    else {
        $('.password').addClass(' password-error').removeClass(' password-success');
    }
    
    if (testPassword(password) && password === password2){
        $("#register-btn").prop("disabled", false);
    }else {
        $("#register-btn").prop("disabled", true);        
    }
    
});

function goBack(){
    window.history.back();
}


/**
 * Validates the password
 * @param password      string
 * @returns {boolean}   true on success
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
        console.log(response)
            let info = JSON.parse(response);
            if (info['status'] === "error")
                alert(info['message']);
            if (info['status'] === "success")
                location.assign("../")
        });
});