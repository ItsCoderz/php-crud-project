<?php

session_start();

//  if logged in redirect to login page
if(isset($_SESSION["id"]))
{
    header("location: index.php");
    exit;
}

include 'header.php';

include("../shared/connection.php");

if(isset($_POST["btn_login"]))
{
    $form_email = $_POST["email"];
    $form_pw = $_POST["password"];

    try {
        $stmt = $conn->prepare("SELECT * FROM tb_user WHERE email = :email;");
        $stmt->bindParam(":email", $form_email);
        $stmt->execute();
        $result = $stmt->fetch();


        if($result)
        {
            if(password_verify($form_pw, $result["user_password"]))
            {
                $_SESSION["id"] = $result["user_id"];
                $_SESSION["name"] = $result["user_name"];

                header("location: artworks.php");
                exit;
            }
            else
            {
                echo "Invalid password!";
            }
        }
        else
        {
            echo "Invalid email!";
        }
    
        // print_r($result);
        // exit;
    } catch (PDOException $e) {
        echo $e;
    }
    $conn = null;
}

?>


<div class="container">
    <h1 class="text-center my-5">Login</h1>

    <form class="px-5" action="login.php" method="post">
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Email Name</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" placeholder="Email" name="email">
            </div>
        </div>
        <div class="row mb-3">
            <label for="" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-secondary" name="btn_login">Add Artwork</button>
        </div>
    </form>
</div>


<?php
include 'footer.php';
?>