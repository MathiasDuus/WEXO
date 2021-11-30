<?php
session_start();

// checks for user id, if none echo error and die
if (!isset($_SESSION['user_id'])){
    echo json_encode("no_login");
    die();
}

include "../DAL/Wishlist.php";
include "../DAL/Data.php";
$wish = new Wishlist();
$data = new Data();

// Determines what action should be taken
$action = $_POST['action'];


// Add item to wishlist
if ($action == "add"){
    $programID = $_POST['movie_id'];
    $userID = $_SESSION['user_id'];
    
    $result = $wish->add($userID, $programID);
    
    echo json_encode($result);
}

// Remove item from wishlist
if ($action == "remove"){
    $programID = $_POST['movie_id'];
    $userID = $_SESSION['user_id'];
    
    $result = $wish->remove($userID, $programID);
    
    echo json_encode($result);
}


// Show all items on wishlist
if ($action == "show"){
    $userID = $_SESSION['user_id'];
    
    $programs = $wish->show($userID);
    
    $result = [];
    
    
    foreach ($programs['message'] as $program) {
        $temp = $data->getProgram($program['program'], $userID);
        $temp['id'] = $program['program'];
        array_push($result, $temp);
    }
    
    
    echo json_encode($result);
}

