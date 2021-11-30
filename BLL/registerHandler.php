<?php
include "../DAL/Register.php";
$reg = new Register();

// Determines what action should be taken
$action = $_POST['action'];


if ($action == "register"){
    // Gets username and password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    
    if ($password == $password2) {
        // Registres the user and logs them in
        $result = $reg->signUp($username, $password);
    }
    else{
        $result = array(
            'status' => "erroe",
            'message'=>"Password do not match"
        );
    }
    echo json_encode($result);
}



