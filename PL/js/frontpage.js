const projectHandler = "../../BLL/dataHandler.php";


$(document).ready(function() {
    $.post(projectHandler,
        {
            action: 'frontpage'
        },
        function(response){
            // console.log(response);
            let info = JSON.parse(response);
            if (info['status'] === "error")
                alert(info['message']);
            else {
                showFrontpage(info, "movies", "leftCol")
                
                // TODO: do not work with series GL HF
                showFrontpage(info, "series", "rightCol")
                
            }
        });
});

function showFrontpage(info,type,col){
    let i = 0;
    
    Object.keys(info[type]).forEach(key => {
        if (key === "count"){return;}
        const genre = info[type][key];
        let appendString;
        key = key.toLowerCase().replace(/\b[a-z]/g, function (letter) {
            return letter.toUpperCase();
        });

        // displays the genre name and how many entries in each genre
        appendString = '<div class="row"><h2 onclick="showGenre(this, ' + type + ')" class="genre-title">' + key + '</h2>' +
            '<h2 class="genre-count ms-auto">('+info[type]['count'][i]+')</h2></div><div class="row">';

        genre.forEach(movie => {
            // Skips one iteration if it is not an object
            if (typeof movie !== 'object' || movie === null){return;}
            let n = 25;
            let title = movie['title'];
            title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
            appendString += '' +
                '<div class="col-4 card-margin"><div class="card">' +
                '<img class="card-img card-image" src="' + movie["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
                '<h3 class="movie-title">' + title + '</h3>' +
                '</div></div>';
        })

        $('#'+col).append(appendString + '</div>')
        i++;
    })
}


function imgError(image) {
    image.onerror = "";
    image.src = "../billeder/lorem_poster.png";
    return true;
}
// TODO: make show genre function
function showGenre(ele,type){
    
}




