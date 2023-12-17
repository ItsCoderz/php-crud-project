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

if (isset($_POST["btn_register"])) {
    $name = $_POST["fullname"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $pw = $_POST["password"];
    
    $pw = password_hash($pw, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO tb_user (user_name, contact, address, email, user_password) VALUES (:user_name, :contact, :address, :email, :user_password);");

        $stmt->bindParam(":user_name", $name);
        $stmt->bindParam(":contact", $contact);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":user_password", $pw);

        $stmt->execute();
        header("location: login.php");
        exit;
    } catch (PDOException $e) {
        echo $e;
    }
    $conn = null;
}
?>

<div class="container">
        <h1 class="text-center my-5">Sign Up</h1>

        <form class="px-5" action="signup.php" method="post">
            <div class="row mb-3">
                <label for="" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Full name" name="fullname">
                </div>
            </div>
            <div class="row mb-3">
                <label for="" class="col-sm-2 col-form-label">Contact Number</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Contact Number" name="contact">
                </div>
            </div>
            <div class="row mb-3">
                <label for="" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Address" name="address">
                </div>
            </div>
            <div class="row mb-3">
                <label for="" class="col-sm-2 col-form-label">Email</label>
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
                <button type="submit" class="btn btn-secondary" name="btn_register">Sign Up</button>
            </div>
        </form>
    </div>

<?php
include 'footer.php';
?>