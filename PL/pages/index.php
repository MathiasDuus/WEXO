<?php
include "../templates/header.php";
//include "../../DAL/Data.php";
//$dat = new Data();
//$movies = $dat->getMovies();
//print("<pre>".print_r($movies,true)."</pre>");
//print_r($movies);
//foreach ($movies['action'] as $key=>$movie) {
//    echo $movie."<br>";
////    $array_data = $movie['plprogram$tags'];//['plprogram$title'];
////    $array_data=array_slice($array_data,0,2);
////    print("<pre>".print_r($array_data,true)."</pre>");
//}


?>

<div id="check"></div>
<div class="container">
    <div class="row">
        <div id="leftCol" class="col-6">
            <div class="row">
                <h1>Movies</h1>
            </div>

            
            <div class="row">
                <h2 onclick="showGenre(this, /*Movies*/)" class="genre-title">Action</h2><h2 class="genre-count ms-auto">(345)</h2>
            </div>
            <div class="row">
                <div class="col-4 card-margin">
                    <div class="card">
                        <img id="book" class="card-img card-image" src="../billeder/chery.jpg" alt="Movie poster">

                        <h3 class="movie-title">TheAssassinationOfJesseJamesByTheCoward Robert Ford</h3>
                    </div>
                </div>
                <div class="col-4 card-margin">
                    <div class="card">
                        <img class="card-img card-image" src="../billeder/chery.jpg" alt="Movie poster">

                        <h3>TitleTitleTi  </h3>
                    </div>
                </div>
                <div class="col-4 card-margin">
                    <div class="card">
                        <img class="card-img card-image" src="../billeder/chery.jpg" alt="Movie poster">

                        <h3>TitleTitleTi  </h3>
                    </div>
                </div>
            </div>
        </div>
            
            
        <div id="rightCol" class="col">
            <div class="row">
                <h1>Series</h1>
            </div>
            <div class="row">
                <h2 onclick="showGenre(this, /*Series*/)" class="genre-title">Series</h2>
            </div>
            <div class="row">

                <div class="col-4 card-margin">
                    <div class="card">
                        <img class="card-img card-image" src="../billeder/chery.jpg" alt="Movie poster">

                        <div class="card-img-overlay">
                            <a href="#">
                                <img alt="Movie Poster Overlay" class="card-image" src="../billeder/poster-overlay.png">
                            </a>
                            <p id="poster-overlay-title">tiel</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 card-margin">
                    <div class="card">
                        <img class="card-img card-image" src="../billeder/chery.jpg" alt="Movie poster">

                        <div class="card-img-overlay">
                            <a href="#">
                                <img alt="Movie Poster Overlay" class="card-image" src="../billeder/poster-overlay.png">
                            </a>
                            <p id="poster-overlay-title">tiel</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 card-margin">
                    <div class="card">
                        <img class="card-img card-image" src="../billeder/chery.jpg" alt="Movie poster">

                        <div class="card-img-overlay">
                            <a href="#">
                                <img alt="Movie Poster Overlay" class="card-image" src="../billeder/poster-overlay.png">
                            </a>
                            <p id="poster-overlay-title">tiel</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>




<?php
include "../templates/footer.html";