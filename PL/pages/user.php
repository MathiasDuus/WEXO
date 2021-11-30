<?php
include "../templates/header.php";

?>

<div class="container">
    <div class="row">
        <button class="width-fit btn btn-m btn-secondary" onclick="goBack()">Back</button>
        <h1 class="width-fit">My wishlist</h1>
        <button class="btn btn-m btn-danger width-fit ms-auto" onclick="removeWishlist()">Remove selected</button>
    </div>
    <div class="row" id="wishlist">
        
    </div>
</div>




<?php
include "../templates/jsLinks.html";
?>
<script src="../js/showWishlist.js"></script>
