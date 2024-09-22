<?php

include '../Connection/dbh.php';
include '../Model/classModel.php';
include '../Controller/loginContr.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
    // Retrieve form data
    $productName = htmlspecialchars(strip_tags($_POST['name']));
    $category = htmlspecialchars(strip_tags($_POST['category']));
    $price = htmlspecialchars(strip_tags($_POST['price']));


    $quantiyStock = htmlspecialchars(strip_tags($_POST['quantityInStock']));
        
    

    $addProd = new ProductController($product_name, $category_name, $price, $display_pic, $quantity);
    $addProd->addProduct($product_name, $category_name, $price, $display_pic, $quantity); 

    // Redirect after adding a product
    header("Location: /myproducts");
    exit();
    } else {
        // Redirect to product page if form is not submitted
        header("Location: ../");
        exit();
    }
}



