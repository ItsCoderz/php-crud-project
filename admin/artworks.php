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

if(isset($_POST["btn_delete"]))
{
    $id = $_POST["id"];
    $stmt = $conn->prepare("DELETE FROM tb_Artwork WHERE id = :id;");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

}

// list fetch
try {
    $stmt = $conn->prepare("SELECT * FROM tb_Artwork;");
    $stmt->execute();
    $result = $stmt->fetchAll();

    // print_r($result);
    // exit;
} catch (PDOException $e) {
    echo $e;
}
$conn = null;
?>


<!-- list -->
<div class="container">
    <h1 class="text-center my-5">All Artworks</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Artwork name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($result as $row) {
                ?>

                    <tr>
                        <th scope="row"><img src="logo.png" width="50"></th>
                        <td><?php echo $row["artwork_name"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td class="">
                            <a href="edit_artwork.php?id=<?php echo $row["id"]; ?>" class="mx-2 action-icon"><i class="fa-solid fa-pen-to-square"></i></a>

                            <form action="artworks.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button name="btn_delete" type="submit">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            
                            <a href="" class="mx-2 action-icon"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>



<?php
include 'footer.php';
?>