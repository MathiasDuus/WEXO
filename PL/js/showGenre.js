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
    
    // Send post request to php to get data from the API
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
        // If there is less than 18 entries in the genre disable both the nex and previous buttons
        if (info[type]['count'] <=18){
            document.getElementById("previous").disabled = true;
            document.getElementById("next").disabled = true;            
        }
        
        if (key === "count"){return;}
        
        // if there is at least one entry 
        if (info[type]['count'] >=1) {
            // Gets the programs in the genre 
            const programs = info[type][key];
            let appendString;
            // Capitalizes the first letter in the genre name
            key = key.toLowerCase().replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });

            // Genre name and how many entries in the genre
            appendString = '<div class="row"><h2 onclick="first()" class="genre-title">' + key + '</h2>' +
                '<h2 class="genre-count ms-auto">(' + info[type]['count'] + ')</h2></div><div class="row">';
            
            programs.forEach(program => {
                // If its not an object or null skip it
                if (typeof program !== 'object' || program === null) {
                    return;
                }
                
                // Max length of the title
                let n = 17;
                let title = program['title'];
                title = (title.length > n) ? title.substr(0, n - 1) + '&hellip;' : title;
                
                // gets the id number at the end of the url
                let programID = program['url'].split('/').pop();
                // Card with poster and title
                appendString += '' +
                    '<div class="col-2 card-margin" onclick="showProgram('+programID+')"><div class="card">' +
                    '<img class="card-img card-image" src="' + program["poster"] + '" alt="Movie_poster" onerror="imgError(this);" >' +
                    '<h3 class="movie-title">' + title + '</h3>' +
                    '</div></div>';
                
            })
            
            $('#' + col).append(appendString + '</div>')
        }
        i++;
    })
}

/**
 * Replaces a broken image with a placeholder
 * @param image The image element
 */
function imgError(image) {
    image.onerror = "";
    image.src = "../billeder/lorem_poster.png";
}

/**
 * Load the previous set of movies/series
 */
function previous(){
    // Gets the url and gets the range parameter
    let href = new URL(window.location.href);
    let range = href.searchParams.get('range');
    const num = range.split('-');
    // Subtracts 18 from the range
    let first = parseInt(num[0])-18;
    let second = parseInt(num[1])-18;

    // Ensures no negative numbers
    if (first<=0){
        first = 1;
    }
    if (second<=0){
        second = 18;
    }
    // Sets the new range
    href.searchParams.set('range', first+"-"+second);
    // Goes to the new page
    window.location.href = href;

}

/**
 * Load the next set of movies/series
 */
function next(){
    // Gets the url and gets the range parameter
    let href = new URL(window.location.href);
    let range = href.searchParams.get('range');
    const num = range.split('-');
    // Adds 18 to the range
    let first = parseInt(num[0])+18;
    let second = parseInt(num[1])+18;

    // Sets the new range
    href.searchParams.set('range', first+"-"+second);
    // Goes to the new page
    window.location.href = href;

}

/**
 * Return to the first page of the genre
 */
function first(){
    // Gets the url and sets it to the first range
    let href = new URL(window.location.href);
    href.searchParams.set('range', "1-18");
    // Go to the new url
    window.location.href = href;    
}