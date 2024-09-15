<?php
if (isset($_POST['submit'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];



    include '../connection/dbh.php'; 
    include '../model/loginModel.php';
    include '../controller/loginContr.php';

    $login = new Logincontr($username, $password);
    // $login->getUser($username, $password);
    

    header("Location: ../pannel/cashier.html?login=success");
    exit();
} else {
 
    header("Location: ../index.php");
    exit();
}


