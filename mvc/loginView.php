<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        include '../connection/dbh.php';
        include '/loginModel.php';
        include 'loginContr.php';

        // Initialize login controller
        $login = new Logincontr($username, $password);
        $login->loginUser();  // Use the controller to handle the login

        // Redirect after successful login
        header("Location: /overview");
        exit();
    } else {
        // Redirect to login page if form is not submitted
        header("Location: ../index.php");
        exit();
    }
}
?>
