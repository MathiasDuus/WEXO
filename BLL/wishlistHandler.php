<?php
session_start();

if (!isset($_SESSION['user_id'])){
    echo json_encode("no_login");
    die();
}
include "../DAL/Wishlist.php";
$wish = new Wishlist();
include "../DAL/Data.php";
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


// Add item to wishlist
if ($action == "show"){
    $userID = $_SESSION['user_id'];
    
    $programs = $wish->show($userID);
    
    $result = [];
    
    
    foreach ($programs['message'] as $program) {
//        print_r($program['program']);
        $temp = $data->getProgram($program['program'], $userID);
        $temp['id'] = $program['program'];
        array_push($result, $temp);
    }
    
    
    echo json_encode($result);
}

