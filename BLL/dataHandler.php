<?php
session_start();
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
    
    
    $movies = $data->getAllGenre($type, $genre, $range);
    
    $result[$type] = $movies;
    $result[$type]['count']=$data->getGenreCount($genre, $type);
    
    // Converts the array to JSON before sending it back
    echo json_encode($result);
}

if ($action == "program") {
    $id = $_POST['id'];
    $userID=-1;
    // Gets the user id if it is present, otherwise a default is used
    if (isset($_SESSION['user_id']))
        $userID = $_SESSION['user_id'];
    
    $result = $data->getProgram($id, $userID);
    
    // Converts the array to JSON before sending it back
    echo json_encode($result);
}

