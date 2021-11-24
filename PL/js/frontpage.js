const projectHandler = "../../BLL/dataHandler.php";


$(document).ready(function() {
    $.post(projectHandler,
        {
            action: 'frontpage'
        },
        function(response){
            let info = JSON.parse(response);
            if (info['status'] === "error")
                alert(info['message']);
            else {
                showContent(info, "movie", "leftCol")

                showContent(info, "series", "rightCol")

            }
        });
});

function imgError(image) {
    image.onerror = "";
    image.src = "../billeder/lorem_poster.png";
    return true;
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
        if (key === "count"){return;}
        if (info[type]['count'][i] >=1) {
            const genre = info[type][key];
            let appendString;
            key = key.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });

            // displays the genre name and how many entries in each genre
            let jsOnClick = "'"+key+"','"+type+"'";
            appendString = '<div class="row"><h2 onclick="showGenre(' + jsOnClick + ')" class="genre-title">' + key + '</h2>' +
                '<h2 class="genre-count ms-auto">(' + info[type]['count'][i] + ')</h2></div><div class="row">';
            
            genre.forEach(movie => {
                // Skips one iteration if it is not an object
                if (typeof movie !== 'object' || movie === null) {
                    return;
                }
                
                let n = 17;
                let title = movie['title'];
                title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
                appendString += '' +
                    '<div class="col-4 card-margin"><div class="card">' +
                    '<img class="card-img card-image" src="' + movie["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
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
    genre = genre.toLowerCase();
    window.location.href = "./showGenre.php?genre="+genre+"&type="+type+"&range=1-18";
    
}



