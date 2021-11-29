/**
 * Sends POST request to update selected row
 */
$("form#loginForm").submit(function(e) {
    e.preventDefault();
    var fd = new FormData(this);

    let username = $('#username').val();
    let password = $('#password').val();


    fd.append('action','verify')
    fd.append('username',username);
    fd.append('password',password);
    $.ajax({
        url: 'verify_login.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            let info = JSON.parse(response);
            if (info['status'] === "error")
                alert(info['message']);
            if (info['status'] === "success")
                location.assign("../")
        },
    });
});


function logout(){
    $.post("login/verify_login.php",
        {
            action: 'logout'
        },
        function(data){
            let info = JSON.parse(data);
            if (info['status'] === "error")
                alert(info['message']);
            if (info['status'] === "success")
                location.reload();
        });
}