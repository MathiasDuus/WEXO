<?php
include "../DAL/Data.php";

$data = new Data();

$action = $_POST['action'];


if ($action == "frontpage"){
    $genres = ["action","comedy","thriller","war","romance","drama","crime","documentary","horror"];
    $movies = $data->getMovies(3, $genres);
//    $movieGenreCount = $data->getGenreCount();
    
    
    $result['movies'] = $movies;
    $result['movies']['count']=$data->getGenreCount($genres);
    
    echo json_encode($result);
}

