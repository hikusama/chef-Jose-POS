<?php
session_start();
include '../Connection/dbh.php';
include '../Model/classModel.php';
include '../Controller/Logincontroller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $username = htmlspecialchars(strip_tags($_POST['username']));
        $password = htmlspecialchars(strip_tags($_POST['password']));

        if (empty($username) || empty($password)) {
            header("Location: ../index.php?error=Empty Inputs.");
        }


        $login = new Logincontroller($username, $password);
        $role = $login->loginUser(); 

        if ($role === "Admin") {
            header("Location: /chef-Jose-POS/pannel/overview.php");
        }else if ($role === "Employee"){
            header("Location: /chef-Jose-POS/pannel/cashier.php");
        }else{
            header("Location: /chef-Jose-POS/pannel/404.php");
        }
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }

}
