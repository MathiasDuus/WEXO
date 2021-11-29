<?php
session_start();
include '../../../DAL/Connect.php';
global $conn;

$action = mysqli_real_escape_string($conn, $_POST['action']);

if ($action == 'verify'){
    echo json_encode(verify::verifyLogin());
}
if ($action == 'logout'){
    echo json_encode(verify::logout());
}
class verify
{
    static function ExtendedAddSlash(&$params)
    {
        foreach ($params as &$var) {
            is_array($var) ? self::ExtendedAddSlash($var) : $var = addslashes($var);
        }
    }

    static function verifyLogin(): array
    {
        global $conn;
        self::ExtendedAddSlash($_POST);

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $response = array(
            "status" => "error",
            "message" => "Noget gik galt"
        );
        $_SESSION['login'] = false;

        $stmt = $conn->prepare("SELECT * FROM login WHERE username=?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];
                $id = $row['id'];
                if (password_verify($password, $hashedPassword)) {
                    $response = array(
                        "status" => "success",
                        "message" => "Du er logget ind"
                    );
                    $_SESSION['login'] = true;
                    $_SESSION['user_id'] =$id;
                } else {
                    $response = array(
                        "status" => "error",
                        "message" => "Forkert brugernavn eller kodeord"
                    );
                    $_SESSION['login'] = false;
                }
            } else {
                $response = array(
                    "status" => "error",
                    "message" => "Forkert brugernavn eller kodeord"
                );
                $_SESSION['login'] = false;
            }
        }
        $stmt->close();
        return $response;
    }

    static function logout():array
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        if (session_destroy())
            $response = array(
                "status" => "success",
                "message" => "Du er nu logget ud"
            );
        else
            $response = array(
                "status" => "error",
                "message" => "Kunne ikke logge dig ud"
            );
        return $response;
    }
}