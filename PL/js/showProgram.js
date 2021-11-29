const projectHandler = "../../BLL/dataHandler.php";

$(document).ready(function (){
    const queryString = window.location.search.substring(1);
    const urlParams = new URLSearchParams(queryString);
    let id = urlParams.get('id');
    $.post(projectHandler,
        {
            action: 'program',
            id: id
        },
        function(response){
        console.log(response)
            let info = JSON.parse(response);
            // If there is an error alert it
            if (info['status'] === "error")
                alert(info['message']);
            else {
                // calls function to display the movie
                program(info);
            }
        });
})



function program(data){
    // Adds backdrop if any
    if (data['backdrop'] !==""){
        $('.backdrop').css('background-image', 'url(' + data['backdrop'] + ')');
    }
        
    let appendString="";
    
    // add title
    appendString += "<div class='row'> <h1 class='movie-title'>"+data['title']+"</h1> </div>";
    
    // Add to wishlist button
    appendString += '' +
        '<div class="row"> <div class="ms-auto form-check">' +
        '  <input onclick="addWishlist()" class="form-check-input" type="checkbox" id="wishlistCheck">' +
        '  <label class="form-check-label" for="wishlistCheck">' +
        '    Add to wishlist' +
        '  </label>' +
        '</div></div>'

    
    appendString += "<div class='row'>";
    
    // add poster
    appendString += '' +
        '<div class="col-4 card-margin"><div class="card np">' +
        '<img class="card-img card-image" src="' + data["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
        '</div></div>';


    appendString += '<div class="col"><div class="row">';
    // Left side general info
    appendString += '<div class="col card-margin">'+
        '<h3> <span class="red-text">Release year:</span> '+data['year']+'</h3>' +
        '<h3> <span class="red-text">genre:';
    data['genre'].forEach(function(genre, index, array){
        appendString += '</span> '+genre;
        if (index !== array.length - 1){
            appendString += ','
        }
    });
    appendString += '</h3></div>'

        
    // Director(s)
    appendString += '<div class="col card-margin">' +
        '<h3> <span class="red-text">Director:</span> ';
    data['director'].forEach(function(director, index, array){
        appendString += '</span> '+director;
        if (index !== array.length - 1){
            appendString += ','
        }
    });
    
    appendString += '</h3></div></div><div class="row">';
    
    
    // Actors
    appendString += '</h3>'+
        '<h3> <span class="red-text">Actors:</span> ';
    
    data['actor'].forEach((actor, index, array)=>{
        appendString += '</span> '+actor;
        if (index !== array.length - 1){
            appendString += ','
        }
    });
    appendString += '</h3>'
    
    // Description
    appendString += '<h3> <span class="red-text">Description:</span> '+data['description']+'</h3>';

    // Closes all divs
    appendString += "</div></div></div>";    
    
    // Appends everything to the container
    $('.container').append(appendString);
}

function addWishlist(){
    if (document.getElementById('#wishlistCheck').checked){
        // Add movie to wishlist
        $.post(projectHandler,
            {
                action: 'add',
                id: id
            },
            function(response){
                console.log(response)
                let info = JSON.parse(response);
                // If there is an error alert it
                if (info['status'] === "error")
                    alert(info['message']);
                else {
                    // calls function to display the movie
                    program(info);
                }
            });
    } else {
        // Removes movie from wishlist
    }
}