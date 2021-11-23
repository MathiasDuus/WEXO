const projectHandler = "../../BLL/dataHandler.php";


$(document).ready(function() {
    const queryString = window.location.search.substring(1);
    const urlParams = new URLSearchParams(queryString);
    let type = urlParams.get('type');
    let genre = urlParams.get('genre');
    let count = urlParams.get('count');
    $.post(projectHandler,
        {
            action: 'showGenre',
            genre: genre,
            type: type,
            count: count
        },
        function(response){
        console.log("hello")
        console.log(response)
            let info = JSON.parse(response);
            if (info['status'] === "error")
                alert(info['message']);
            else {
                showGenre(info, type, "genre_row")
            }
        });
});



function showGenre(info,type,col){
    let i = 0;

    Object.keys(info[type]).forEach(key => {
        if (key === "count"){return;}
        console.log("halha")
        if (info[type]['count'] >=1) {
            console.log("asdjaslkdjlak")
            const genre = info[type][key];
            let appendString;
            key = key.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });

            // displays the genre name and how many entries in each genre
            let jsOnClick = "'"+key+"','"+type+"'";
            appendString = '<div class="row"><h2 onclick="showGenre(' + jsOnClick + ')" class="genre-title">' + key + '</h2>' +
                '<h2 class="genre-count ms-auto">(' + info[type]['count'] + ')</h2></div><div class="row">';
            
            genre.forEach(movie => {
                // Skips one iteration if it is not an object
                if (typeof movie !== 'object' || movie === null) {
                    return;
                }
                
                let n = 17;
                let title = movie['title'];
                title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
                appendString += '' +
                    '<div class="col-2 card-margin"><div class="card">' +
                    '<img class="card-img card-image" src="' + movie["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
                    '<h3 class="movie-title">' + title + '</h3>' +
                    '</div></div>';
                
            })

            $('#' + col).append(appendString + '</div>')
        }
        i++;
    })
}

function imgError(image) {
    image.onerror = "";
    image.src = "../billeder/lorem_poster.png";
    return true;
}