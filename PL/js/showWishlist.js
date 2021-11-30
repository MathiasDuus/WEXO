const wishlistHandler = "../../BLL/wishlistHandler.php";


$(document).ready(function() {
    $.post(wishlistHandler,
        {
            action: 'show'
        },
        function (response) {
            let info = JSON.parse(response);
            if (info === "no_login") {
                window.location.href = "../pages";
            }
            // If there is an error alert it
            if (info['status'] === "error")
                alert(info['message']);
            else {
                show(info)
            }
        });
});


function show(data) {

    data.forEach((program, index) => {
        let appendString = "";

        let n = 17;
        let title = program['title'];
        title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
        let checked = data['wishlist'] ? "checked" : "";
        appendString += '' +
            '<div id="' + program['id'] + '" class="col-2">' +
            '   <div class="form-check">' +
            '       <input value="' + program['id'] + '" class="form-check-input" ' + checked + ' type="checkbox" id="wishlistCheck' + index + '">' +
            '       <label class="form-check-label" for="wishlistCheck' + index + '">' +
            '       Remove' +
            '       </label>' +
            '   </div>'+
            '   <div onclick="showProgram(' + program['id'] + ')" class="card">' +
            '       <img class="card-img card-image" src="' + program["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
            '       <h3 class="movie-title">' + title + '</h3>' +
            '   </div>' +
            '</div>';


        // Appends program to the container
        $('#wishlist').append(appendString);
        index--;
    });

}

function removeWishlist(){
    $(':checkbox:checked').each(function(i){
        let val = $(this).val();
        $.post(wishlistHandler,
            {
                action: "remove",
                movie_id: val
            },
            function(response){
                let info = JSON.parse(response);
                if (info['status'] === "error")
                    alert(info['message']);
                else 
                    $('#'+val).remove();
            });
    });
    
    
}

/**
 * Replaces a broken image with a placeholder
 * @param image The image element
 */
function imgError(image) {
    image.onerror = "";
    image.src = "../billeder/lorem_poster.png";
}