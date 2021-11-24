const projectHandler = "../../BLL/dataHandler.php";



$(document).ready(function() {
    // The following gets the parameters from the url
    const queryString = window.location.search.substring(1);
    const urlParams = new URLSearchParams(queryString);
    let type = urlParams.get('type');
    let genre = urlParams.get('genre');
    let range = urlParams.get('range');
    const num = range.split('-');
    // if the first number in the range if 1, disable previous button
    if (num[0]==="1"){
        document.getElementById("previous").disabled = true;
    }
    
    // Send request to get info from the API
    $.post(projectHandler,
        {
            action: 'showGenre',
            genre: genre,
            type: type,
            range: range
        },
        function(response){
        // Converts the JSON response from JSON to JS object
            let info = JSON.parse(response);
            // If there is an error alert it
            if (info['status'] === "error")
                alert(info['message']);
            else {
                // Function to generate all html needed to display the movies with poster and title
                showGenre(info, type, "genre_row")
            }
        });
});

/**
 * Generates the html needed to display the content with their poster and title
 * @param info  All data needed for the movie|series
 * @param type  movie|series
 * @param col   Where it should be placed
 */
function showGenre(info,type,col){
    let i = 0;

    Object.keys(info[type]).forEach(key => {
        if (key === "count"){return;}
        
        if (info[type]['count'] >=1) {
            const genre = info[type][key];
            let appendString;
            key = key.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });

            // displays the genre name and how many entries in each genre
            appendString = '<div class="row"><h2 class="genre-title">' + key + '</h2>' +
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

function previous(){
    let href = new URL(window.location.href);
    let range = href.searchParams.get('range');
    const num = range.split('-');
    let first = parseInt(num[0])-18;
    let second = parseInt(num[1])-18;

    if (first<=0){
        first = 1;
    }
    if (second<=0){
        second = 18;
    }
    
    href.searchParams.set('range', first+"-"+second);
    window.location.href = href;

}

function next(){
    let href = new URL(window.location.href);
    let range = href.searchParams.get('range');
    const num = range.split('-');
    let first = parseInt(num[0])+18;
    let second = parseInt(num[1])+18;

    href.searchParams.set('range', first+"-"+second);
    window.location.href = href;

}