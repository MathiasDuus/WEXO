<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="../billeder/icon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    

    <title>WEXO - Code Challenge</title>
</head>
<body>

<header id="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">
        <div class="container-fluid">
            <a id="logo" href="./"><img class="navbar-img" src="../billeder/navbar-icon.png" alt="WEXO Code Challenge"/></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <?php
                if ($_SESSION['login']){
                ?>
                <div class="navbar-nav ms-auto">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link cursor-point" href="../pages/user.php">My wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link cursor-point" onclick="logout()">Log out</a>
                        </li>
                    </ul>
                </div>
                <?php
                }else{
                ?>
                <div class="navbar-nav ms-auto">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/login/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/login/register.php">Sign-up</a>
                        </li>
                    </ul>

                </div>
                <?php } ?>
            </div>
        </div>
    </nav>


</header>
