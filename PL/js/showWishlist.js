const wishlistHandler = "../../BLL/wishlistHandler.php";


$(document).ready(function() {
    // POST call to PHP, to get all programs from wishlist
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
                // Display the programs
                show(info)
            }
        });
});

/**
 * Displays all programs on the wishlist
 * @param data  Array of programs
 */
function show(data) {

    data.forEach((program, index) => {
        let appendString = "";
        
        // Max length of the title
        let n = 17;
        let title = program['title'];
        title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
        
        // Card with checkbox the top, with poster and title below
        appendString += '' +
            '<div id="' + program['id'] + '" class="col-2">' +
            '   <div class="form-check">' +
            '       <input value="' + program['id'] + '" class="form-check-input" type="checkbox" id="wishlistCheck' + index + '">' +
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

/**
 * Removes all selected programs from the wishlist
 */
function removeWishlist(){
    // Loop to go through all checked checkboxes
    $(':checkbox:checked').each(function(){
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