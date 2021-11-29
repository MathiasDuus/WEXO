const wishlistHandler = "../../BLL/wishlistHandler.php";


$(document).ready(function() {
    $.post(wishlistHandler,
        {
            action: 'show'
        },
        function(response){
        console.log(response)
            let info = JSON.parse(response);
            // If there is an error alert it
            if (info['status'] === "error")
                alert(info['message']);
            else {
                show(info['message'])
            }
        });
});


function show(data){
    
}

