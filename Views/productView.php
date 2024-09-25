<?php

session_start();
include '../Connection/dbh.php';
include '../Model/classModel.php';
include '../Controller/productController.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transac']) && $_POST['transac'] == "addProd")  {
    // Retrieve form data
        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        $category_name = htmlspecialchars(strip_tags($_POST['category']));
        $price = htmlspecialchars(strip_tags($_POST['price']));
        $quantity = htmlspecialchars(strip_tags($_POST['quantityInStock']));

        $product_image = null;

        if (isset($_FILES['displayPic']) && $_FILES['displayPic']['error'] == 0) {
            $image_file_type = strtolower(pathinfo($_FILES['displayPic']['name'], PATHINFO_EXTENSION));

            $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($image_file_type, $allowed_types)) {
                $errors["invalid_format"] = 'Invalid format ( <b style="font-size:1rem;">jpg, png, jpeg, gif</b> )';
            }
            $product_image = file_get_contents($_FILES['displayPic']['tmp_name']);
        }else{
            $errors["no_img"] = 'Please insert image of product.';

        }


        $addProd = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);
        $delete = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);
        $update = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);
        $show = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image);


        if ($addProd->is_empty_inputs($product_name, $category_name, $price, $quantity)) {
            $errors["empty_inputs"] = "Please fill in all fields"; 
        }
        if (!$errors) {
            $addProd->addProducts();
            echo '<p style="color:green" class="goodText">Added succesfully..</p>';
        }else{
            foreach ($errors as $error) {
                echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">'.$error.'</p>';
            }
        }





}else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transac']) && $_POST['transac'] == "editProd") {



}else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transac']) && $_POST['transac'] == "viewProd_info") {
    


}else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transac']) && $_POST['transac'] == "removeProd") {

    $delete->deleteProducts($product_id);  


}else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transac']) && $_POST['transac'] == "showSearchProd") {




}
