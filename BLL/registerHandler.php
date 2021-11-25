<?php
include "../DAL/Register.php";

$reg = new Register();

// Determines what action should be taken
$action = $_POST['action'];


if ($action == "register"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    
    $result = $reg->signUp($username, $password);
        
    echo json_encode($result);
}



