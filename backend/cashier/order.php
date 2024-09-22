<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_id = $_POST["prod_id"];

    $orders = array();


    array_push($orders, $product_id);


    session_start();
    $_SESSION['orders'] = $orders;
}
