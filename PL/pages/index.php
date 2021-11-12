<?php
include "../../DAL/Data.php";
include "../templates/header.php";
$data = new Data();
$mov  = $data->getMoviesByYear(2017);
// ['orig-480x334'] for poster image

//foreach ($mov[1]['plprogram$thumbnails'] as $key=>$entry) {
//    echo $entry."<br>";
//    print_r($entry['plprogram$thumbnails'])."<br><br><br><br>";
//}

