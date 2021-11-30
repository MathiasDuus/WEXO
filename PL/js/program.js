const projectHandler = "../../BLL/dataHandler.php";
const wishlistHandler = "../../BLL/wishlistHandler.php";

$(document).ready(function (){
    // Gets the url and id of the movie
    const queryString = window.location.search.substring(1);
    const urlParams = new URLSearchParams(queryString);
    let id = urlParams.get('id');
    $.post(projectHandler,
        {
            action: 'program',
            id: id
        },
        function(response){
            let info = JSON.parse(response);
            // If there is an error alert it
            if (info['status'] === "error")
                alert(info['message']);
            else {
                // calls function to display the movie
                program(info, id);
            }
        });
})

/**
 * Displays all relevant info about the program
 * @param data  Array of data
 * @param id    The id of the movie
 */
function program(data, id){
    // Adds backdrop if any
    if (data['backdrop'] !==""){
        $('.backdrop').css('background-image', 'url(' + data['backdrop'] + ')');
    }
        
    let appendString="";
    
    // add title
    appendString += "<div class='row'> <h1 class='movie-title'>"+data['title']+"</h1> </div>";
    
    // add back button
    appendString += '<div class="row"><button class="width-fit btn btn-m btn-secondary" onclick="goBack()">Back</button>'
    
    // Add to wishlist button
    if (data['wishlist'] !== "login") {
        let checked = data['wishlist'] ? "checked" : "";
        appendString += '' +
            '<div class="ms-auto form-check">' +
            '  <input onclick="addWishlist(' + id + ')" class="form-check-input" ' + checked + ' type="checkbox" id="wishlistCheck">' +
            '  <label class="form-check-label" for="wishlistCheck">' +
            '    Add to wishlist' +
            '  </label>' +
            '</div></div>'
    }
    
    appendString += "<div class='row'>";
    
    // add poster
    appendString += '' +
        '<div class="col-4 card-margin"><div class="card np">' +
        '<img class="card-img card-image" src="' + data["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
        '</div></div>';


    appendString += '<div class="col"><div class="row">';
    // release year
    appendString += '<div class="col card-margin">'+
        '<h3> <span class="red-text">Release year:</span> '+data['year']+'</h3>';
    
    // Genre

    appendString += '<h3> <span class="red-text">genre:';
    if (data['genre'].length >=1) {
        data['genre'].forEach(function (genre, index, array) {
            appendString += '</span> ' + genre;
            if (index !== array.length - 1) {
                appendString += ','
            }
        });
    }
    appendString += '</h3></div>'

        
    // Director(s)
    appendString += '<div class="col card-margin">' +
        '<h3> <span class="red-text">Director:</span> ';
    if (data['director'].length >=1) {
        data['director'].forEach(function (director, index, array) {
            appendString += '</span> ' + director;
            if (index !== array.length - 1) {
                appendString += ','
            }
        });
    }
    
    appendString += '</h3></div></div><div class="row">';
    
    
    // Actors
    appendString += '</h3>'+
        '<h3> <span class="red-text">Actors:</span> ';
    
    if (data['actor'].length >=1) {
        data['actor'].forEach((actor, index, array) => {
            appendString += '</span> ' + actor;
            if (index !== array.length - 1) {
                appendString += ','
            }
        });
    }
    appendString += '</h3>'
    
    // Description
    appendString += '<h3> <span class="red-text">Description:</span> '+data['description']+'</h3>';

    // Closes all divs
    appendString += "</div></div></div>";    
    
    // Appends everything to the container
    $('.container').append(appendString);
}

/**
 * Adds or removes an item from the wishlist
 * @param id    ID of the movie
 */
function addWishlist(id){
    $('#status').empty();
    if (document.getElementById('wishlistCheck').checked){
        // Add movie to wishlist
        let msg = "Program added to wishlist"
        postWishlist('add', id)
    } else {
        // Removes movie from wishlist
        let msg = "Program removed from wishlist"
        postWishlist('remove', id)
        
    }
}

/**
 * POST call to PHP to delete or add to wishlist
 * @param action    remove|add
 * @param id        Program id
 */
function postWishlist(action, id){
    $.post(wishlistHandler,
        {
            action: action,
            movie_id: id
        },
        function(response){
            let info = JSON.parse(response);

            if (info['status'] === "error")
                alert(info['message']);
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
