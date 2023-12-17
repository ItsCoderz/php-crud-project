<?php

session_start();
//  if not logged in redirect to login page
if(!isset($_SESSION["id"]))
{
    header("location: login.php");
    exit;
}


include 'header.php';

//  html form data recieved
if (isset($_POST["btn_save"])) {
    $name = $_POST["artwork_name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    

    include("../shared/connection.php");


    try {
        $stmt = $conn->prepare("INSERT INTO tb_Artwork (artwork_name, price, description) VALUES (:name, :price, :description);");

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":description", $description);

        $stmt->execute();
        header("location: artworks.php");
        exit;
    } catch (PDOException $e) {
        echo $e;
    }
    $conn = null;
}

?>


<!-- add Artwork form -->
<div class="container">
    <h1 class="text-center my-5">Add Artwork</h1>

    <form class="px-5" action="create_artwork.php" method="POST">
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Artwork Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Artwork name" name="artwork_name">
            </div>
        </div>
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Price" name="price">
            </div>
        </div>
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" placeholder="Description" name="description"></textarea>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-secondary" name="btn_save">Add Artwork</button>
        </div>
    </form>
</div>



<?php
include 'footer.php';
?>