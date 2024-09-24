<?php
    session_start();
    include '../Connection/dbh.php';
    include '../Model/classModel.php';
    include '../Controller/productController.php';
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submited'])) {
        // Retrieve form data
        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        $category_name = htmlspecialchars(strip_tags($_POST['category']));
        $price = htmlspecialchars(strip_tags($_POST['price']));
        $quantity = htmlspecialchars(strip_tags($_POST['quantityInStock']));
        
        if (isset($_FILES['product_image'])) {
            if ($_FILES['product_image']['error'] == 0) {
                $target_dir = "../uploads/";
                $file_name = basename($_FILES["product_image"]["name"]);
                $target_file = $target_dir . $file_name;
                $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
                $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
                if (!in_array($image_file_type, $allowed_types)) {
                    header("Location: /myproducts?error=invalidimageformat");
                    exit();
                }
        
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    $product_image = $target_file;
                } else {
                    error_log("File upload failed: " . print_r($_FILES['product_image'], true));
                    header("Location: /myproducts?error=uploadfailed");
                    exit();
                }
            } else {
                $error_code = $_FILES['product_image']['error'];
                header("Location: /myproducts?error=uploadfailed&code=" . $error_code);
                exit();
            }
        }
        
        //DELETE
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id'])) {
                $product_id = htmlspecialchars(strip_tags($_POST['id']));
            } else {
                // Handle the case where 'id' is not set, e.g., log an error or set a default value
                error_log("Product ID not set in POST request.");
            }
        }
        

        $addProd = new ProductController(null,$product_name, $category_name, $price, $quantity, $product_image);
        $delete = new ProductController(null,$product_name, $category_name, $price, $quantity, $product_image);
        $update = new ProductController(null,$product_name, $category_name, $price, $quantity, $product_image);
        $show = new ProductController(null,$product_name, $category_name, $price, $quantity, $product_image);
        
        $addProd->addProducts();
        $delete->deleteProducts($product_id);
        $update->updateProducts();
        $show->showProducts();


        header("Location: /myproducts");
        exit();
        } else {
            error_log("Form submitted: " . print_r($_POST, true)); // Check what is being posted
            exit();
        }
    }



