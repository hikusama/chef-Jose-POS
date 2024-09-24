<?php
session_start();
include '../connection/dbh.php';
include '../model/classModel.php';
include '../controllers/productController.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submited'])) {
    // RETRIEVE DATA
        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        $category_name = htmlspecialchars(strip_tags($_POST['category']));
        $price = htmlspecialchars(strip_tags($_POST['price']));
        $quantity = htmlspecialchars(strip_tags($_POST['quantityInStock']));

        $product_image = null;

        if (isset($_FILES['displayPic']) && $_FILES['displayPic']['error'] == 0) {
            $image_file_type = strtolower(pathinfo($_FILES['displayPic']['name'], PATHINFO_EXTENSION));

            $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($image_file_type, $allowed_types)) {
                header("Location: /myproducts?error=invalidimageformat");
                exit();
            }
            $product_image = file_get_contents($_FILES['displayPic']['tmp_name']);
        }

        //DELETE PRODUCT
        if (isset($_POST['id'])) {
            $product_id = htmlspecialchars(strip_tags($_POST['id']));
        } else {
            $product_id = null;
            error_log("Product ID not set in POST request.");
        }

        $addProd = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);
        $delete = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);
        $update = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);
        $show = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);

        $addProd->addProducts();

        if ($product_id !== null) {
            $delete->deleteProducts($product_id); 
        } else {
            error_log("No product ID provided for deletion.");
        }

        $update->updateProducts();
        $product = $show->showProducts();

        header("Location: /myproducts");
        exit();
    } else {
        error_log("Form not submitted: " . print_r($_POST, true)); 
        exit();
    }
}
