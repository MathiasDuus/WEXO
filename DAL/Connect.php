<?php

$conn = mysqli_connect("localhost", "pman01.skp-dp.sd", "2pp3q2p5", "WEXO")?:die("Connection failed");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}