const projectHandler = "../../BLL/dataHandler.php";


$(window).on('load', function() {
    // Send post request to php to get data from the API
    $.post(projectHandler,
        {
            action: 'frontpage'
        },
        function(response){
        // Converts the JSON to JS object
            let info = JSON.parse(response);
            if (info['status'] === "error")
                alert(info['message']);
            else {
                // Calls function to display movies and series
                showContent(info, "movie", "leftCol")

                showContent(info, "series", "rightCol")

            }
        });
});

/**
 * Replaces a broken image with a placeholder
 * @param image The image element
 */
function imgError(image) {
    image.onerror = "";
    image.src = "../billeder/lorem_poster.png";
}

/**
 * Display a movie/series poster and title
 * @param info      Array containing all data
 * @param type      string movie|series
 * @param col       Name of collum
 */
function showContent(info,type,col){
    let i = 0;

    Object.keys(info[type]).forEach(key => {
        // if the key is count it shall return
        if (key === "count"){return;}
        // Ensures that there is at least one movie/series 
        if (info[type]['count'][i] >=1) {
            // All movies/series in a genre
            const data = info[type][key];
            // String used for appending to col
            let appendString;
            // Makes the first letter in the genre name uppercase
            key = key.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });

            // displays the genre name and how many entries in each genre
            let jsOnClick = "'"+key+"','"+type+"'";
            appendString = '<div class="row"><h2 onclick="showGenre(' + jsOnClick + ')" class="genre-title">' + key + '</h2>' +
                '<h2 class="genre-count ms-auto">(' + info[type]['count'][i] + ')</h2></div><div class="row">';
            
            // Loop to add poster and title to append string
            data.forEach(content => {
                // Skips one iteration if it is not an object
                if (typeof content !== 'object' || content === null) {
                    return;
                }
                
                let n = 17;
                let title = content['title'];
                let programID = content['url'].split('/').pop();
                title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
                appendString += '' +
                    '<div class="col-4 card-margin" onclick="showProgram('+programID+')"><div class="card">' +
                    '<img class="card-img card-image" src="' + content["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
                    '<h3 class="movie-title">' + title + '</h3>' +
                    '</div></div>';
                
            })

            $('#' + col).append(appendString + '</div>')
        }
        i++;
    })
}

/**
 * Redirects to showGenre.php
 * @param genre String gener
 * @param type  movie|series
 */
function showGenre(genre,type){
    // Makes the genre name lower case
    genre = genre.toLowerCase();
    // Sends user to the link
    window.location.href = "./showGenre.php?genre="+genre+"&type="+type+"&range=1-18";
    
}




