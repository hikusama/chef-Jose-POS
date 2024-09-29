<?php

session_start();
include '../Connection/dbh.php';
include '../Model/classModel.php';
include '../Controller/productController.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // PRODUCT ADD

    if (isset($_POST['transac']) && $_POST['transac'] == "addProd") {
        $errors = [];

        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        $category_name = htmlspecialchars(strip_tags($_POST['category']));
        $price = htmlspecialchars(strip_tags($_POST['price']));
        $quantity = htmlspecialchars(strip_tags($_POST['quantityInStock']));

        $product_image = null;

        if (isset($_FILES['displayPic']) && $_FILES['displayPic']['error'] == 0) {

            $image_file_type = strtolower(pathinfo($_FILES['displayPic']['name'], PATHINFO_EXTENSION));
            $fileSize = $_FILES['displayPic']['size'];

            $maxFileSize = 3 * 1024 * 1024;
            $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($image_file_type, $allowed_types)) {
                $errors["invalid_format"] = 'Invalid format ( <b style="font-size:1rem;">jpg, png, jpeg, gif</b> )';
            } else {
                if ($fileSize <= $maxFileSize) {
                    $ImageData = file_get_contents($_FILES['displayPic']['tmp_name']);
                } else {
                    $errors["pic_error"] = "The file size exceeds the maximum allowed limit (3 MB)!";
                }
            }
            $product_image = file_get_contents($_FILES['displayPic']['tmp_name']);
        } else {
            $errors["no_img"] = 'Please insert image of product.';
        }


        $addProd = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image, null);


        if ($addProd->is_empty_inputs($product_name, $category_name, $price, $quantity)) {
            $errors["empty_inputs"] = "Please fill in all fields";
        }
        if (!$errors) {
            $addProd->addProducts();
            echo 'productAdded';
        } else {
            foreach ($errors as $error) {
                echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">' . $error . '</p>';
            }
        }






        // CATEGORY ADD

    } 
    

    // CATEGORY ADD
    
    if (isset($_POST['transac']) && $_POST['transac'] == "addCategory") {


        $errors = [];


        $category_name = htmlspecialchars(strip_tags($_POST['category']));

        if (empty($category_name)) {
            $errors["empty_inputs"] = "Please fill in all fields";
        }

        $addCategory = new ProductController(null, null, null, null, null, null, $category_name);

        if (!$errors) {

            $addCategory->addCategory();
            echo 'categoryAdded';
        } else {
            foreach ($errors as $error) {
                echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">' . $error . '</p>';
            }
        }








        // PRODUCT EDIT

    } 
    

    // PRODUCT EDIT
    
    if (isset($_POST['transac']) && $_POST['transac'] == "editProd") {

        $update = new ProductController(null, $product_name, $category_name, $price, $quantity, $product_image, null);





        // PRODUCT VIEW INFO

    } 
    
    
    // VIEW PROD INFO

    if (isset($_POST['transac']) && $_POST['transac'] == "viewProd_info") {






        // GET CATEGORY

    } 
    
    
    // CATEGORY GET
    
    if (isset($_POST['transac']) && $_POST['transac'] == "getCategory") {
        $getCategory = new ProductController(null, null, null, null, null, null, null);

        $rowsCat = $getCategory->getCat();

        echo '<option value="">Category</option>';


        if ($rowsCat) {
            foreach ($rowsCat as $row) {

                echo '<option value="' . $row["category_id"] . '" name="category">' . $row["category_name"] . '</option>';
            }
        }





        // PRODUCT DELETE

    } 
    
    
    // PRODUCT REMOVE
    
    if (isset($_POST['transac']) && $_POST['transac'] == "removeProd") {

        $product_id = htmlspecialchars(strip_tags($_POST['product_id']));


        $delete = new ProductController($product_id, null, null, null, null, null, null);

        $delete->deleteProducts();






        // GET PRODUCT

    } 
    
    
    // PRODUCTS SHOW/SEARCH
    
    if (isset($_POST['transac']) && $_POST['transac'] == "showSearchProd") {


        $product_name = htmlspecialchars(strip_tags($_POST['name']));




        $searchShow = new ProductController(null, $product_name, null, null, null, null, null);
        $rows = $searchShow->getProdSearch();
        echo '
        <div class="loading_sc">
            <div>
                <p class="dp"></p>
                <div class="desc"></div>                                
            </div>
            <div>
                <p class="dp"></p>
                <div class="desc"></div>                                
            </div>
            <div>
                <p class="dp"></p>
                <div class="desc"></div>
            </div>

        </div>
        ';

        if ($rows) {
            foreach ($rows as $row) {
                echo '
            <li>
                <div class="dp">
                    <img src="data:image/jpeg;base64, ' . base64_encode($row['displayPic']) . '" alt="">
                </div>
                <p>' . $row['name'] . '</p>
                <p>' . $row['category_name'] . '</p>
                <p>' . $row['quantityInStock'] . '</p>
                <p>₱' . $row['price'] . '</p>
                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>
                    <div class="action_select" id="' . $row['productID'] . '">
                        <p><i class="fas fa-edit"></i> Edit</p>
                        <p><i class="fas fa-trash"></i> Delete</p>
                        <p><i class="fas fa-eye"></i> View</p>
                    </div>
            </li>';
            }
        } else {
            echo "No products..";
        }
    }

    



}
