<?php

session_start();
//  if not logged in redirect to login page
if(!isset($_SESSION["id"]))
{
    header("location: login.php");
    exit;
}

include 'header.php';

include("../shared/connection.php");


if(isset($_GET["id"]))
{
    $id = $_GET["id"];
}
else
{
    $id = $_POST["id"];
}

$stmt = $conn->prepare("SELECT * FROM tb_Artwork WHERE id = :id;");
$stmt->bindParam(":id", $id);
$stmt->execute();
$artwork = $stmt->fetch();

// print_r($artwork);
// exit;


//  html form data recieved
if (isset($_POST["btn_save"])) {
    $name = $_POST["artwork_name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    
    try {
        $stmt = $conn->prepare("UPDATE tb_Artwork SET artwork_name=:name, price=:price, description=:description where id=:id;");

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":id", $id);

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
    <h1 class="text-center my-5">Edit Artwork</h1>

    <form class="px-5" action="edit_artwork.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $artwork['id'];  ?>">

        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Artwork Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Artwork name" name="artwork_name" value="<?php echo $artwork['artwork_name'];  ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" placeholder="Price" name="price" value="<?php echo $artwork['price'];  ?>">
            </div>
        </div>
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" placeholder="Description" name="description"><?php echo $artwork['description'];  ?></textarea>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-secondary" name="btn_save">Update Artwork</button>
        </div>
    </form>
</div>



<?php
include 'footer.php';
?>