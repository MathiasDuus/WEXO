<?php
session_start();
include "../DAL/Wishlist.php";
$data = new Wishlist();

// Determines what action should be taken
$action = $_POST['action'];


// Add item to wishlist
if ($action == "add"){
    $programID = $_POST['movie_id'];
    $userID = $_SESSION['user_id'];
    
    $result = $data->add($userID, $programID);
    
    echo json_encode($result);
}

// Remove item from wishlist
if ($action == "remove"){
    $programID = $_POST['movie_id'];
    $userID = $_SESSION['user_id'];
    
    $result = $data->remove($userID, $programID);
    
    echo json_encode($result);
}



