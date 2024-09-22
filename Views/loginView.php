<?php
include '../Connection/dbh.php';
include '../Model/classModel.php';
include '../Controller/loginContr.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $username = htmlspecialchars(strip_tags($_POST['username']));
        $password = htmlspecialchars(strip_tags($_POST['password']));


        // Initialize login controller
        $login = new Logincontr($username, $password);
        $login->loginUser();  // Use the controller to handle the login

        // Redirect after successful login
        header("Location: /overview");
        exit();
    } else {
        // Redirect to login page if form is not submitted
        header("Location: /");
        exit();
    }

}
