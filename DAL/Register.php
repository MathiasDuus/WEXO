<?php
session_start();
include "Connect.php";

class Register
{
    /**
     * Registers user to the database
     * @param string $username
     * @param string $password
     * @return array
     */
    function signUp(string $username, string $password)
    {
        global $conn;
    
        $response = array(
            "status" => "error",
            "message" => "Noget gik galt"
        );
        $_SESSION['login'] = false;
        
        // Check to see if username is already taken
        $sql = "SELECT id FROM login WHERE username=?"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->num_rows;
        
        if ($user==0) {
            $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashedPassword);
            if ($stmt->execute()) {
                $response = array(
                    "status" => "success",
                    "message" => "Account created"
                );
                $_SESSION['login'] = true;
            }
        }else{
            $response = array(
                "status" => "error",
                "message" => "Username exist"
            );
            $_SESSION['login'] = false;
        }
        return $response;
    }
}