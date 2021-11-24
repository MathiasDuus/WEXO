<?php
include "../DAL/Data.php";
$data = new Data();

// Determines what action should be taken
$action = $_POST['action'];


if ($action == "frontpage"){
    // Genre to be displayed on the front page
    $genres = ["action","crime","thriller","war","romance","drama","comedy","documentary","horror"];    
    
    // Get 3 movies and series from each genre, if any
    $movies = $data->getData("movie",3, $genres);
    $series = $data->getData("series",3, $genres);
    
    // Adds the movies and series to the final array
    // Also adds a number of how many in each genre
    $result['movie'] = $movies;
    $result['movie']['count']=$data->getGenreCount($genres, "movie");
    $result['series'] = $series;
    $result['series']['count']=$data->getGenreCount($genres, "series");
    
    // Converts the result to json and sends it back to the js function the made the call
    echo json_encode($result);
}

if ($action == "showGenre") {
    // Gets the genre ,type(movie/series) and range
    $genre = $_POST['genre'];
    $type = $_POST['type'];
    $range = $_POST['range'];
    
    // Gets all data within the parameters
    $movies = $data->getAllGenre($type, $genre, $range);
    
    $result[$type] = $movies;
    $result[$type]['count']=$data->getGenreCount($genre, $type);
    
    // Converts the array to JSON before sending it back
    echo json_encode($result);
}

