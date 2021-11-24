<?php
include "../DAL/Data.php";

$data = new Data();

$action = $_POST['action'];


if ($action == "frontpage"){
    $genres = ["action","crime","thriller","war","romance","drama","comedy","documentary","horror"];    
    
    $movies = $data->getData("movie",3, $genres);
    $series = $data->getData("series",3, $genres);
    
    $result['movie'] = $movies;
    $result['movie']['count']=$data->getGenreCount($genres, "movie");
    $result['series'] = $series;
    $result['series']['count']=$data->getGenreCount($genres, "series");
    
    echo json_encode($result);
}

if ($action == "showGenre") {
    $genre = $_POST['genre'];
    $type = $_POST['type'];
    $range = $_POST['range'];
    
    $movies = $data->getAllGenre($type, $genre, $range);
    
    $result[$type] = $movies;
    $result[$type]['count']=$data->getGenreCount($genre, $type);
    
    echo json_encode($result, JSON_UNESCAPED_SLASHES);
}

