<?php

include '../Connection/dbh.php';
include '../Model/classModel.php';
include '../Controller/productController.php';
require_once "../function.php";
isAdminRole();


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['transac'])) {

    // PRODUCT ADD

    if (isset($_POST['transac']) && $_POST['transac'] == "addProd") {
        $errors = [];

        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        $category_name = htmlspecialchars(strip_tags($_POST['category']));
        $price = intval($_POST['price']);
        $availability = htmlspecialchars(strip_tags($_POST['availability']));

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
                    $product_image = file_get_contents($_FILES['displayPic']['tmp_name']);
                } else {
                    $errors["pic_error"] = "The file size exceeds the maximum allowed limit (3 MB)!";
                }
            }
        } else {
            $errors["no_img"] = 'Please insert image of product.';
        }


        $addProd = new ProductController(null, $product_name, $category_name, $price, $availability, $product_image, null);



        if ($addProd->is_empty_inputs($product_name, $category_name, $price, $availability) || $price < 1) {
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

        if ($addCategory->isCategoryExist($category_name)) {
            $errors["used"] = "Category name already used";
        }
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

        $update = new ProductController(null, $product_name, $category_name, $price, $availability, $product_image, null);





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

        $ID = htmlspecialchars(strip_tags($_POST['ID']));
        $state = 1;
        if (isset($_SESSION['currstate'])) {
            $state = $_SESSION['currstate'];
            if ($state === 2) {
                $state = 2;
            }else if ($state === 3) {
                $state = 3;
            }
        }

        
        if (empty($ID)) {
            return false;
        }
        $delete = new ProductController(null, null, null, null, null, null, null);

        if($delete->delete_things($ID,$state)){
            echo "Deleted";
        }else{
            echo "Error deleting";
        }
        return;


    }


    // PRODUCTS SHOW/SEARCH

    if (isset($_POST['transac']) && $_POST['transac'] == "showSearchProd") {

        if (isset($_SESSION['currstate'])) {
            unset($_SESSION['currstate']);
        }

        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        
        (int)$selected_page = (intval($_POST['page']) == 0) ? 1 : intval($_POST['page']);




        $searchShow = new ProductController(null, $product_name, null, null, null, null, null);
        $obj = $searchShow->getProdSearch($selected_page);
        $rows = $obj['data'];
        $total_pages = $obj['total_pages'];
        $current_page = $obj['current_page'];

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
                <p>' . $row['availability'] . '</p>
                <p>₱' . $row['price'] . '</p>
                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>
                    <div class="action_select" id="' . $row['productID'] . '">
                        <p id="editByID"><i class="fas fa-edit" ></i> Edit</p>
                        <p id="deleteByID"><i class="fas fa-trash" ></i> Delete</p>
                        <p id="viewByID"><i class="fas fa-eye"></i> View</p>
                    </div>
            </li>';
            }
            echo '
            <li id="page-dir-cont" style="">
                <div class="main-dir-link">';
                // $iterate = 1;
                // $pg =  (51 / 100)  ;
                // if ($current_page == 7) {
                    
                // }
                for ($i=1; $i <= $total_pages ; $i++) {

                    // if ($i === 8) {
                    //     echo '<button type="button" id="more">...</button>';
                    //     break;
                    // }
                    $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="'.$i.'">' ;
                    echo $g.$i;
                    echo '</button>';

                }
                echo '</div>
            </li>
            ';

        } else {
            echo "No products..";
        }
    }



    // PRODUCTS COMBO ADD SHOW/SEARCH

    if (isset($_POST['transac']) && $_POST['transac'] == "comboSectionShowSearchProd") {
        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        $combos = array();

        if (isset($_SESSION['combos'])) {
            $combos = $_SESSION['combos'];
        }



        $searchShow = new ProductController(null, $product_name, null, null, null, null, null);
        $rows = $searchShow->getProdSearchCombo($combos);


        if ($rows) {
            echo '
            <div class="loadingScComboForm-outer">
                <div class="loadingScComboForm">
                    <ol>
                        <li>
                            <div>

                            </div>
                        </li>
                        <li>

                        </li>
                    </ol>
                    <ol>
                        <li>
                            <div>

                            </div>
                        </li>
                        <li>

                        </li>
                    </ol>
                    <ol>
                        <li>
                            <div>

                            </div>
                        </li>
                        <li>

                        </li>
                    </ol>
                </div>
            </div>        
            ';
            foreach ($rows as $row) {
                echo '
                <ol>
                    <li>
                        <div>
                            <img src="data:image/jpeg;base64, ' . base64_encode($row['displayPic']) . ' " alt="">
                        </div>
                    </li>
                    <li>
                        <p>' . $row['name'] . '</p>
                    </li>
                    <li>
                        <div class="action-combo" id="' . $row['productID'] . '">
                            <i class="fas fa-plus" id="selectProd" style="color: rgb(107, 252, 107);"></i>                        
                        </div>
                    </li>
                </ol>';
            }

        } else {
            echo "No products..";
        }
    }

    if (isset($_POST['transac']) && $_POST['transac'] == "selectProd") {
        $productID = (int)($_POST['productID']);


        if (empty($productID)) {
            echo "Empty inputs";
            return;
        }
        $combos = array();

        if (isset($_SESSION['combos'])) {
            $combos = $_SESSION['combos'];
        }

        array_push($combos, $productID);
        getSelected($combos, "update");

        // $_SESSION['combo'] = count($combos);
        $_SESSION['combos'] = $combos;
    }

    if (isset($_POST['transac']) && $_POST['transac'] == "rmSelectedProd") {
        $productID = htmlspecialchars(strip_tags($_POST['productID']));



        if (empty($productID)) {
            echo "Empty inputs";
            return;
        }
        $combos = array();

        if (isset($_SESSION['combos'])) {
            $combos = $_SESSION['combos'];
        }

        $array_size = count($combos);


        for ($i = 0; $i < $array_size; $i++) {
            if ($combos[$i] == $productID) {
                unset($combos[$i]);
                $combos = array_values($combos);
                break;
            }
        }
        // foreach ($combos as $combo) {
        //     if ($combo == $productID) {
        //         unset($combo);
        //         $combos = array_values($combos);
        //         break;
        //     }
        // }
        $array_size = count($combos);

        if ($array_size == 0) {
            unset($_SESSION['combos']);
            echo "No products..";
            return;
        }

        $_SESSION['combos'] = $combos;
        getSelected($combos, "na");
    }

    if (isset($_POST['transac']) && $_POST['transac'] == "viewSelectedProd") {
        $combos = array();

        if (isset($_SESSION['combos'])) {
            $combos = $_SESSION['combos'];
        } else {
            echo '            <div class="loadingScComboForm-outer">
                <div class="loadingScComboForm">
                    <ol>
                        <li>
                            <div>

                            </div>
                        </li>
                        <li>

                        </li>
                    </ol>
                    <ol>
                        <li>
                            <div>

                            </div>
                        </li>
                        <li>

                        </li>
                    </ol>
                    <ol>
                        <li>
                            <div>

                            </div>
                        </li>
                        <li>

                        </li>
                    </ol>
                </div>
            </div> ';
            echo "No selected products..";
            return;
        }

        getSelected($combos, "na");
    }

    if (isset($_POST['transac']) && $_POST['transac'] == "viewComboSummary") {
        $totalPriceCombo = 0;
        $item = 0;
        if (isset($_SESSION['combos'], $_SESSION['comboSummary'])) {
            $cmb = $_SESSION['comboSummary'];
            $totalPriceCombo = $cmb['totalPriceCombo'];
            $item = $cmb['totalItemCombo'];
        }
        $totalPriceComboTmp = number_format($totalPriceCombo, 0, ',');

        echo '
        <li>
            <h3>₱' . $totalPriceComboTmp . '</h3>
            <p>Products in Total</p>
        </li>
        <li>
            <h3>' . $item . '</h3>
            <p>Item/s</p>
        </li>
        ';
    }





    if (isset($_POST['transac']) && $_POST['transac'] == "insertCombo") {

        $comboName = htmlspecialchars(strip_tags($_POST['comboName']));
        $comboPrice = intval($_POST['comboPrice']);
        $comboCode = htmlspecialchars(strip_tags($_POST['comboCode']));
        $availability = htmlspecialchars(strip_tags($_POST['availability']));
    
        $combos = array();


        if (empty($comboName) || empty($comboPrice)|| empty($availability) || empty($comboCode)) {
            echo "Fill in all fields.";
            return;
        }
        $comboIMG;
        if (isset($_FILES['comboPic']) && $_FILES['comboPic']['error'] == 0) {

            $image_file_type = strtolower(pathinfo($_FILES['comboPic']['name'], PATHINFO_EXTENSION));
            $fileSize = $_FILES['comboPic']['size'];

            $maxFileSize = 3 * 1024 * 1024;
            $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($image_file_type, $allowed_types)) {
                echo 'Invalid pic format ( <b style="font-size:1rem;">jpg, png, jpeg, gif</b> )';
                return;
            } else {
                if ($fileSize <= $maxFileSize) {
                    $comboIMG = file_get_contents($_FILES['comboPic']['tmp_name']);
                } else {
                    echo "The file size exceeds the maximum allowed limit (3 MB)!";
                    return;
                }
            }
        } else {
            echo 'Please insert image of combo.';
            return;
        }



        if (!isset($_SESSION['combos'])) {
            echo "No combo selected.";
            return;
        }
        $sz;

        if (isset($_SESSION['combos'])) {
            $combos = $_SESSION['combos'];
            $sz = count($combos);
            if ($sz <= 1) {
                echo "Selecting combo must be more than 1.";
                return;
            }
        }
        $prodController = new ProductController(null, null, null, null, null, null, null);

        // var_dump($combos);
        // $prodController->checkCombo($comboName,"comboName");
        if ($prodController->checkCombo($comboName,"comboName")) {
            echo "Combo name already used.";
            return;
        }
        if ($prodController->checkCombo($comboCode,"comboCode")) {
            echo "Combo code already used.";
            return;
        }
        $prodController->insertCombo($combos,$comboIMG,$comboName,$comboCode,$comboPrice,$availability);

        // echo $prodController->checkCombo($comboCode,"comboCode");
        unset($_SESSION['combos']);


        // $prodController->insertCombo($combos,$comboName,$comboCode,$comboPrice);
        // if (!$prodController) {
        //     echo "Error Inserting..";
        // }
    
    }


    if (isset($_POST['transac']) && $_POST['transac'] == "findCat") {

        $_SESSION['currstate'] = 2;

        $catName = htmlspecialchars(strip_tags($_POST['catName']));
        (int)$selected_page = (intval($_POST['page']) == 0) ? 1 : intval($_POST['page']);

        $prodController = new ProductController(null, null, null, null, null, null, null);
        $obj = $prodController->findCatGt($catName,$selected_page);
        $rows = $obj['data'];
        $total_pages = $obj['total_pages'];
        $current_page = $obj['current_page'];
        
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
                    <p>' . $row['total_prod'] . '</p>
                </div>
                <p>' . $row['category_name'] . '</p>
                <h5></h5>
                <h5></h5>
                <h5></h5>
                
                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>
                    <div class="action_select" id="' . $row['category_id'] . '">
                        <p id="editByID" ><i class="fas fa-edit"></i> Edit</p>
                        <p id="deleteByID"><i class="fas fa-trash"></i> Delete</p>
                        <p id="viewByID"><i class="fas fa-eye" ></i> View</p>
                    </div>
            </li>';
            }
            echo '
            <li id="page-dir-cont" style="">
                <div class="main-dir-link">';
                for ($i=1; $i <= $total_pages ; $i++) {
                    // if ($i === 8) {
                    //     echo '<button type="button" id="more">...</button>';
                    //     break;
                    // }
                    $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="'.$i.'">' ;
                    echo $g.$i;
                    echo '</button>';

                }
                echo '</div>
            </li>
            ';
        } else {
            echo "No category..";
        }
        
        
    }
    if (isset($_POST['transac']) && $_POST['transac'] == "findCombo") {

        $_SESSION['currstate'] = 3;

        $comboName = htmlspecialchars(strip_tags($_POST['comboName']));
        (int)$selected_page = (intval($_POST['page']) == 0) ? 1 : intval($_POST['page']);

        $prodController = new ProductController(null, null, null, null, null, null, null);
        $obj = $prodController->findComboGt($comboName,$selected_page);
        $rows = $obj['data'];
        $total_pages = $obj['total_pages'];
        $current_page = $obj['current_page'];
        
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
                <p>' . $row['comboName'] . ' (' . $row['comboCode'] . ')</p>
                <p>' . $row['total_comboID'] . '</p>
                <p>' . $row['availability'] . '</p>
                <p>₱' . $row['comboPrice'] . '</p>
                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>
                    <div class="action_select" id="' . $row['comboID'] . '">
                        <p id="editByID" ><i class="fas fa-edit"></i> Edit</p>
                        <p id="deleteByID"><i class="fas fa-trash"></i> Delete</p>
                        <p id="viewByID"><i class="fas fa-eye" ></i> View</p>
                    </div>
            </li>';
            }
            echo '
            <li id="page-dir-cont" style="">
                <div class="main-dir-link">';
                for ($i=1; $i <= $total_pages ; $i++) {
                    // if ($i === 8) {
                    //     echo '<button type="button" id="more">...</button>';
                    //     break;
                    // }
                    $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="'.$i.'">' ;
                    echo $g.$i;
                    echo '</button>';

                }
                echo '</div>
            </li>
            ';
        } else {
            echo "No combo..";
        }
        
        
    }





}

function getSelected($comboIDSelected, $type)
{

    $searchShow = new ProductController(null, $comboIDSelected, null, null, null, null, null);
    $rows = $searchShow->getProdSearchComboByID();

    $tPrice = 0;
    $item = 0;

    if ($rows) {
        if ($type == "update") {

            foreach ($rows as $row) {
                $tPrice += $row['price'];
                $item = $item + 1;
            }
            $sum = [
                "totalPriceCombo" => $tPrice,
                "totalItemCombo" => $item
            ];
            $_SESSION['comboSummary'] = $sum;
        } else {


            echo '
        <div class="loadingScComboForm-outer">
            <div class="loadingScComboForm">
                <ol>
                    <li>
                        <div>

                        </div>
                    </li>
                    <li>

                    </li>
                </ol>
                <ol>
                    <li>
                        <div>

                        </div>
                    </li>
                    <li>

                    </li>
                </ol>
                <ol>
                    <li>
                        <div>

                        </div>
                    </li>
                    <li>

                    </li>
                </ol>
            </div>
        </div>        
        ';
            foreach ($rows as $row) {
                echo '
            <ol>
                <li>
                    <div>
                        <img src="data:image/jpeg;base64, ' . base64_encode($row['displayPic']) . ' " alt="">
                    </div>
                </li>
                <li>
                    <p>' . $row['name'] . '</p>
                </li>
                <li>
                    <div class="action-combo" id="' . $row['productID'] . '">
                        <i class="fas fa-minus" id="rmSelectedCombo" style="color: rgb(241, 86, 65);"></i>                        
                    </div>
                </li>
            </ol>';
                $tPrice += $row['price'];
                $item = $item + 1;
            }
            $sum = [
                "totalPriceCombo" => $tPrice,
                "totalItemCombo" => $item
            ];
            $_SESSION['comboSummary'] = $sum;
        }
    } else {
        unset($_SESSION['comboSummary']);
        echo "No selected products..";
    }
}
