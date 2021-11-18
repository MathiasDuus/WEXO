<?php
include "../DAL/Data.php";

$data = new Data();

$action = $_POST['action'];


if ($action == "frontpage"){
    $genres = ["action","comedy","thriller","war","romance","drama","crime","documentary","horror"];
    $movies = $data->getData("movie",3, $genres);
    $series = $data->getData("series",3, $genres);
    
    
    $result['movies'] = $movies;
    $result['movies']['count']=$data->getGenreCount($genres, "movie");
    $result['series'] = $series;
    $result['series']['count']=$data->getGenreCount($genres, "series");
    
    echo json_encode($result);
}

