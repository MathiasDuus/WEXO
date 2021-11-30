<?php
include "Connect.php";

class Wishlist
{
    /**
     * Adds a program to the users wishlist
     * @param int $userID       ID of user
     * @param int $programID    ID of the program to be added
     * @return string[]
     */
    function add(int $userID,int $programID):array
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO wishlist (userID, program) VALUES (?, ?)");
        $stmt->bind_param("ii", $userID, $programID);
        
        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => "Program add to wishlist created"
            );
        }else{
            $response = array(
                "status" => "error",
                "message" => "Could not add program to wishlist"
            );
        }
    
        $stmt->close();
        return $response;
    }
    
    /**
     * Removes a program to the users wishlist
     * @param int $userID       ID of user
     * @param int $programID    ID of the program to be added
     * @return string[]
     */
    function remove(int $userID,int $programID):array
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM wishlist WHERE program = ? AND userID = ?");
        $stmt->bind_param("ii",$programID, $userID);
        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => "Program add to wishlist created"
            );
        }else{
            $response = array(
                "status" => "error",
                "message" => "Could not add program to wishlist"
            );
        }
    
        $stmt->close();
        return $response;
    }
    
    /**
     * Gets everything on users wishlist
     * @param int $userID   user id
     * @return string[]     programs on the wishlist
     */
    function show(int $userID):array
    {
        global $conn;
        $stmt = $conn->prepare("SELECT program FROM wishlist WHERE userID=?");
        $stmt->bind_param("i", $userID);
    
        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => $stmt->get_result()->fetch_all(MYSQLI_ASSOC)
            );
        }else{
            $response = array(
                "status" => "error",
                "message" => "Could not add program to wishlist"
            );
        }
        
        $stmt->close();
        return $response;
    }
}