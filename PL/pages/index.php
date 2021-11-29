<?php
include "../templates/header.php";
//include "../../DAL/Data.php";
//$dat = new Data();
//$movies = $dat->getData("movie");
//print("<pre style='background-color: white'>".print_r($movies,true)."</pre>");
//$genres = ["action","comedy","thriller","war","romance","drama","crime","documentary","horror"];
//$movies = $dat->getGenreCount($genres);


?>

<div class="container">
    <div class="row">
        <div id="leftCol" class="col-6">
            <div class="row">
                <h1>Movies</h1>
            </div>            
        </div>
            
            
        <div id="rightCol" class="col-6">
            <div class="row">
                <h1>Series</h1>
            </div>
        </div>
        
    </div>
</div>




<?php
include "../templates/jsLinks.html";
?>
<script src="../js/frontpage.js"></script>