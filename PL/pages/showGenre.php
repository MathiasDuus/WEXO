<?php
include "../templates/header.php";

?>
    
    <div class="container">
        <div class="row">
            <div class="col">
                <button onclick="previous()" id="previous" class="btn btn-primary btn-m">Previous</button>
            </div>
            <div class="col d-flex justify-content-end">
                <button onclick="next()" id="next" class="btn btn-primary btn-m">next</button>
            </div>
        </div>
        
        
        
        <div id="genre_row" class="row">
            
        </div>
    </div>

<?php
include "../templates/footer.html";
?>
<script src="../js/showGenre.js"></script>