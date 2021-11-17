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

                let i = 0;
                Object.keys(info['movies']).forEach(key => {
                    const genre = info['movies'][key];
                    const type = "movies";
                    let appendString;
                    key = key.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                        return letter.toUpperCase();
                    });
                    
                    // displays the genre name and how many movies in genre
                    appendString = '<div class="row"><h2 onclick="showGenre(this, ' + type + ')" class="genre-title">' + key + '</h2>' +
                        '<h2 class="genre-count ms-auto">('+genre['count']+')</h2></div><div class="row">';
                    // delete genre['count'];
                    console.log(genre)
                    genre.forEach(movie => {
                        let n = 25;
                        let title = movie['title'];
                        title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
                        appendString += '' +
                            '<div class="col-4 card-margin"><div class="card">' +
                            '<img class="card-img card-image" src="' + movie["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
                            '<h3 class="movie-title">' + title + '</h3>' +
                            '</div></div>';
                    })

                    $('#leftCol').append(appendString + '</div>')
                })
            }
        });
});


function imgError(image) {
    image.onerror = "";
    image.src = "../billeder/lorem_poster.png";
    return true;
}
// TODO: make show genre function
function showGenre(ele,type){
    
}




