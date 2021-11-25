<?php

session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="../../billeder/icon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/login.css">
    
    
    <title>WEXO - Code Challenge</title>
</head>
<body>

<a class="btn btn-secondary" href="../">Frontpage</a>

<div class="login">
    <form id="register">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input class="form-control" id="username" placeholder="Username" required/>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input class="form-control password" id="password" type="password" placeholder="Password" required/>
        </div>
        <div class="mb-3">
            <p><b>Password must </b></p>
            <ul class="password-check">
                <li id="eightCh">    Be at least 8 characters</li>
                <li id="oneNum">     Have at least one number</li>
                <li id="oneSym">     Have at least one symbol</li>
                <li id="uppercase">  Have at least one upper case letter</li>
                <li id="lowercase">  Have at least one lower case letter</li>
            </ul>
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">Confirm Password</label>
            <input class="form-control password" id="password2" type="password" placeholder="Password" required/>
        </div>
        <button type="submit" id="register-btn" class="btn btn-primary">Register</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="register.js"></script>

</body>
</html>
