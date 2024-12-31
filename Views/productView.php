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
    }


    // PRODUCT EDIT

    if (isset($_POST['transac']) && $_POST['transac'] == "editProd") {
        $errors = [];

        $imgChangeProd = htmlspecialchars(strip_tags($_POST['imgChange']));
        $id = htmlspecialchars(strip_tags($_POST['id']));
        $reqtype = htmlspecialchars(strip_tags($_POST['reqtype']));
        $name = htmlspecialchars(strip_tags($_POST['name']));
        $category_id = htmlspecialchars(strip_tags($_POST['category']));
        $price = intval($_POST['price']);
        $availability = htmlspecialchars(strip_tags($_POST['availability']));

        $obj = new ProductController(null, $name, $category_id, $price, $availability, null, null);

        if ($obj->is_empty_inputs($name, $category_id, $price, $availability) || $price < 1) {
            $msg = "<p>Please fill in all fields</p>";
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
            return;
        }

        $product_image = "";
        if (isset($_FILES['displayPic']) && $_FILES['displayPic']['error'] == 0) {

            $image_file_type = strtolower(pathinfo($_FILES['displayPic']['name'], PATHINFO_EXTENSION));
            $fileSize = $_FILES['displayPic']['size'];

            $maxFileSize = 3 * 1024 * 1024;
            $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($image_file_type, $allowed_types)) {
                $msg = '<p>Invalid format ( <b style="font-size:1rem;">jpg, png, jpeg, gif</b> )</p>';
                http_response_code(200);
                header("Content-Type: application/json");
                echo json_encode(["res" => "minorerr", "msg" => $msg]);
                return;
            } else {
                if ($fileSize <= $maxFileSize) {
                    $product_image = file_get_contents($_FILES['displayPic']['tmp_name']);
                } else {
                    $msg = "<p>The file size exceeds the maximum allowed limit (3 MB)!</p>";
                    http_response_code(200);
                    header("Content-Type: application/json");
                    echo json_encode(["res" => "minorerr", "msg" => $msg]);
                    return;
                }
            }
        } else {
            $msg = "<p>Please insert image of product.</p>";
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
            return;
        }

        $orgData = $obj->productDataLight($id);

        $modifieds = [];
        /*
            prd.name,
            prd.price,
            prd.category_id,
            prd.availability 
        */

        if ($imgChangeProd > 0) {
            $modifieds["displayPic"] = $product_image;
        }

        if (isNotSame($orgData['name'], $name)) {
            $modifieds["name"] = $name;
        }

        if (isNotSame($orgData['price'], $price)) {
            $modifieds["price"] = $price;
        }

        if (isNotSame($orgData['category_id'], $category_id)) {
            $modifieds["category_id"] = $category_id;
        }

        if (isNotSame($orgData['availability'], $availability)) {
            $modifieds["availability"] = $availability;
        }





        if (count($modifieds) !== 0) {
            $res = "";
            $msg = "";
            if ($reqtype === "check") {
                $msg = '<p style="color:#00dd00">Ready to update...</p>';
                http_response_code(200);
                $res = "no error";
            } else if ($reqtype === "update") {
                // $obj->addCategory();
                $errorCount = 0;
                foreach ($modifieds as $key => $value) {
                    if (!$obj->updateProductThings($id, $key, $value)) {
                        $errorCount += 1;
                    }
                }
                if ($errorCount === 0) {
                    $msg = "Products Updated Successfully...";
                    $res = "success";
                    http_response_code(200);
                } else {
                    $msg = "Execution error.";
                    $res = "failed";
                    http_response_code(400);
                }
            }
            header("Content-Type: application/json");
            echo json_encode(["res" => $res, "msg" => $msg]);
        } else {
            $msg = "<p>No changes</p>";
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
        }
    }

    // CATEGORY EDIT

    if (isset($_POST['transac']) && $_POST['transac'] == "editCategory") {

        $reqtype = htmlspecialchars(strip_tags($_POST['reqtype']));
        $id = htmlspecialchars(strip_tags($_POST['ID']));
        $category_name = htmlspecialchars(strip_tags($_POST['category']));

        $isModified = false;

        if (empty($category_name)) {
            $msg = "<p>Please fill in all fields.</p>";
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
            return;
        }

        $obj = new ProductController(null, null, null, null, null, null, $category_name);
        $orgCatName = $obj->getCategoryName($id);

        if ($orgCatName === $category_name) {
            $isModified = true;
        }

        if ($isModified === false) {
            if ($obj->isCategoryExist($category_name)) {
                $msg = "<p>Category name already used</p>";
                http_response_code(200);
                header("Content-Type: application/json");
                echo json_encode(["res" => "minorerr", "msg" => $msg]);
                return;
            }
        }

        $res = "";
        $msg = "";
        if ($isModified === false) {
            if ($reqtype === "check") {
                $msg = '<p style="color:#00dd00">Ready to update...</p>';
                http_response_code(200);
                $res = "no error";
            } else if ($reqtype === "update") {
                // $obj->addCategory();
                if ($obj->updateCategoryName($id, $category_name)) {
                    $msg = "Category Updated Successfully...";
                    $res = "success";
                    http_response_code(200);
                } else {
                    $msg = "Execution error.";
                    $res = "failed";
                    http_response_code(400);
                }
            }
            header("Content-Type: application/json");
            echo json_encode(["res" => $res, "msg" => $msg]);
        } else {
            $msg = "<p>No changes</p>";
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
        }
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
    }


    // ITEM UPDATE

    if (isset($_POST['transac']) && $_POST['transac'] == "fetchDataAction") {

        $ID = htmlspecialchars(strip_tags($_POST['ID']));
        $res = "";
        $formType = "products";
        if (empty($ID)) {
            http_response_code(400);
            $res = "No id";
            header("Content-Type: application/json");
            echo json_encode(["form" => $res, "formType" => $formType]);
            return false;
        }

        $state = 1;
        if (isset($_SESSION['currstate'])) {
            $state = $_SESSION['currstate'];
        }
        $obj = new ProductController(null, null, null, null, null, null, null);
        $rowsCat = $obj->getCat();

        $org = "";

        if ($state === 1) {
            $formType = "products";
            $data = $obj->productData($ID);
            $bulk = getPForm($ID, $data, $rowsCat);
            $res = $bulk["RtData"];
            $org = $bulk['check'];
        } else if ($state === 2) {
            $formType = "category";
            $data = $obj->categoryData($ID);
            $res = getCatForm($ID, $data);
            $org = $data['category_name'];
        } else if ($state === 3) {
            $formType = "combo";
            $data = $obj->comboData($ID);
            $bulk = getCbForm($ID, $data);
            $res = $bulk["RtData"];
            $org = $bulk['check'];
        }
        if ($res === "") {
            http_response_code(400);
            $res = "No data";
        }





        header("Content-Type: application/json");
        echo json_encode(["form" => $res, "formType" => $formType, "orgData" => $org]);
        return;
    }


    // ITEM REMOVE

    if (isset($_POST['transac']) && $_POST['transac'] == "removeAction") {

        $ID = htmlspecialchars(strip_tags($_POST['ID']));
        $state = 1;
        if (isset($_SESSION['currstate'])) {
            $state = $_SESSION['currstate'];
            // if ($state === 2) {
            //     $state = 2;
            // } else if ($state === 3) {
            //     $state = 3;
            // }
        }

        $res = "";

        if (empty($ID)) {
            http_response_code(400);
            $res = "No id";
            return false;
        }
        $delete = new ProductController(null, null, null, null, null, null, null);

        if ($delete->delete_things($ID, $state)) {
            http_response_code(200);
            $res = "Deleted";
        } else {
            http_response_code(400);
            $res = "Error deleting";
        }

        header("Content-Type: application/json");
        echo json_encode(["result" => $res]);
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
            for ($i = 1; $i <= $total_pages; $i++) {

                // if ($i === 8) {
                //     echo '<button type="button" id="more">...</button>';
                //     break;
                // }
                $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="' . $i . '">';
                echo $g . $i;
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



        if (count($combos) !== 10) {
            array_push($combos, $productID);
            getSelected($combos, "update");
            $_SESSION['combos'] = $combos;
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "good", "msg" => ""]);
        } else {
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "error", "msg" => "Max(10) combo selected."]);
        }

        // $_SESSION['combo'] = count($combos);
    }






    // Edit Combo Things 

    if (isset($_POST['transac']) && $_POST['transac'] == "dumpComboProd") {
        $comboID = (int)($_POST['comboID']);
        $obj = new ProductController(null, null, null, null, null, null, null);
        $productsIDs = $obj->dumpReqData($comboID);
        if (empty($comboID)) {
            echo "No id.";
            return;
        }
        $combosDumped = array();

        if (isset($_SESSION['combosDumped'])) {
            unset($_SESSION['combosDumped']);
        }

        foreach ($productsIDs as $id) {
            array_push($combosDumped, $id['productID']);
        }

        $_SESSION['combosDumped'] = $combosDumped;
        getSelected($combosDumped, "update", 2);
    }


    if (isset($_POST['transac']) && $_POST['transac'] == "unsetF") {
        if (isset($_SESSION['combosDumped'])) {
            unset($_SESSION['combosDumped']);
        }
        if (isset($_SESSION['comboDumpedSummary'])) {
            unset($_SESSION['comboDumpedSummary']);
        }
    }


    if (isset($_POST['transac']) && $_POST['transac'] == "viewSelectedDumpedProd") {
        $combosDumped = array();
        $comboID = (int)($_POST['comboID']);

        if (isset($_SESSION['combosDumped'])) {
            $combosDumped = $_SESSION['combosDumped'];
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
        $obj = new ProductController(null, null, null, null, null, null, null);
        $orgData = $obj->comboDataLight($comboID);
        $orgProducts = array();

        $i = -1;
        foreach ($orgData as $val) {
            $orgProducts[$i += 1] = $val['productID'];
        }

        $res = "nahh";
        $notMatching = array_diff($combosDumped, $orgProducts);

        if (count($orgProducts) === count($combosDumped)) {
            if (!empty($notMatching)) {
                $res = "modif";
            }
        } else {
            $res = "modif";
        }


        getSelected($combosDumped, $res, 2);
    }


    if (isset($_POST['transac']) && $_POST['transac'] == "comboSectionShowSearchProdEdit") {
        $product_name = htmlspecialchars(strip_tags($_POST['name']));
        $combosDumped = array();

        if (isset($_SESSION['combosDumped'])) {
            $combosDumped = $_SESSION['combosDumped'];
        }



        $searchShow = new ProductController(null, $product_name, null, null, null, null, null);
        $rows = $searchShow->getProdSearchCombo($combosDumped);


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
                            <i class="fas fa-plus" id="selectProdEdit" style="color: rgb(107, 252, 107);"></i>                        
                        </div>
                    </li>
                </ol>';
            }
        } else {
            echo "No products..";
        }
    }


    if (isset($_POST['transac']) && $_POST['transac'] == "rmSelectedProdEdit") {
        $productID = htmlspecialchars(strip_tags($_POST['productID']));

        if (empty($productID)) {
            echo "No id";
            return;
        }
        $combosDumped = array();

        if (isset($_SESSION['combosDumped'])) {
            $combosDumped = $_SESSION['combosDumped'];
        }

        $array_size = count($combosDumped);


        for ($i = 0; $i < $array_size; $i++) {
            if ($combosDumped[$i] == $productID) {
                unset($combosDumped[$i]);
                $combosDumped = array_values($combosDumped);
                break;
            }
        }

        $array_size = count($combosDumped);

        if ($array_size == 0) {
            unset($_SESSION['combosDumped']);
            echo "No products..";
            return;
        }

        $_SESSION['combosDumped'] = $combosDumped;
        getSelected($combosDumped, "na", 2);
    }


    if (isset($_POST['transac']) && $_POST['transac'] == "selectProdEdit") {
        $productID = (int)($_POST['productID']);


        if (empty($productID)) {
            echo "No id";
            return;
        }
        $combosDumped = array();

        if (isset($_SESSION['combosDumped'])) {
            $combosDumped = $_SESSION['combosDumped'];
        }

        if (count($combosDumped) !== 10) {
            array_push($combosDumped, $productID);
            getSelected($combosDumped, "update", 2);
            $_SESSION['combosDumped'] = $combosDumped;
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "good", "msg" => ""]);
        } else {
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "error", "msg" => "Max(10) combo selected."]);
        }

        // $_SESSION['combo'] = count($combosDumped);
    }


    if (isset($_POST['transac']) && $_POST['transac'] == "viewComboSummaryEdit") {
        $totalPriceCombo = 0;
        $item = 0;
        if (isset($_SESSION['combosDumped'], $_SESSION['comboDumpedSummary'])) {
            $cmb = $_SESSION['comboDumpedSummary'];
            $totalPriceCombo = $cmb['totalPriceCombo'];
            $item = $cmb['totalItemCombo'];
        } else {
            var_dump($_SESSION['combosDumped']);
            var_dump($_SESSION['comboDumpedSummary']);
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


    if (isset($_POST['transac']) && $_POST['transac'] == "comboDoubleAction") {

        $reqtype = htmlspecialchars(strip_tags(trim($_POST['reqtype'])));
        $comboID = htmlspecialchars(strip_tags(trim($_POST['comboID'])));
        $imgChanges = htmlspecialchars(strip_tags(trim($_POST['imgChanges'])));
        $comboName = htmlspecialchars(strip_tags(trim($_POST['comboName'])));
        $comboPrice = intval($_POST['comboPrice']);
        $comboCode = htmlspecialchars(strip_tags(trim($_POST['comboCode'])));
        $availability = htmlspecialchars(strip_tags(trim($_POST['availability'])));

        $combosDumped = array();


        if (empty($comboName) || empty($comboPrice) || empty($availability) || empty($comboCode)) {
            $msg = "Fill in all fields.";
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
            return;
        }
        $comboIMG;
        if (isset($_FILES['comboPic']) && $_FILES['comboPic']['error'] == 0) {

            $image_file_type = strtolower(pathinfo($_FILES['comboPic']['name'], PATHINFO_EXTENSION));
            $fileSize = $_FILES['comboPic']['size'];

            $maxFileSize = 3 * 1024 * 1024;
            $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($image_file_type, $allowed_types)) {
                $msg = 'Invalid pic format ( <b style="font-size:1rem;">jpg, png, jpeg, gif</b> )';
                http_response_code(200);
                header("Content-Type: application/json");
                echo json_encode(["res" => "minorerr", "msg" => $msg]);
                return;
            } else {
                if ($fileSize <= $maxFileSize) {
                    $comboIMG = file_get_contents($_FILES['comboPic']['tmp_name']);
                } else {
                    $msg = "The file size exceeds the maximum allowed limit (3 MB)!";
                    http_response_code(200);
                    header("Content-Type: application/json");
                    echo json_encode(["res" => "minorerr", "msg" => $msg]);
                    return;
                }
            }
        } else {
            $msg =  'Please insert image of combo.';
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
            return;
        }



        if (!isset($_SESSION['combosDumped'])) {
            $msg = "No combo selected.";
            http_response_code(200);
            header("Content-Type: application/json");
            echo json_encode(["res" => "minorerr", "msg" => $msg]);
            return;
        }


        if (isset($_SESSION['combosDumped'])) {
            $combosDumped = $_SESSION['combosDumped'];
            $sz = count($combosDumped);
            if ($sz <= 1) {
                $msg = "Selecting combo must be more than 1.";
                http_response_code(200);
                header("Content-Type: application/json");
                echo json_encode(["res" => "minorerr", "msg" => $msg]);
                return;
            }
        }
        $modifItems = 0;
        $modifiedsAtrr = [];

        $obj = new ProductController(null, null, null, null, null, null, null);
        $orgData = $obj->comboDataLight($comboID);
        $orgProducts = [];
        $i = -1;
        if ($orgData[0]['productID']) {
            foreach ($orgData as $val) {
                $orgProducts[$i += 1] = $val['productID'];
            }
        }

        $notMatching = array_diff($combosDumped, $orgProducts);

        if (count($orgProducts) === count($combosDumped)) {
            if (!empty($notMatching)) {
                $modifItems = 1;
            }
        } else {
            $modifItems = 1;
        }

        if (isNotSame($orgData[0]['comboName'], $comboName)) {
            $modifiedsAtrr["comboName"] = $comboName;
        }

        if (isNotSame($orgData[0]['comboCode'], $comboCode)) {
            $modifiedsAtrr["comboCode"] = $comboCode;
        }

        if (isNotSame($orgData[0]['comboPrice'], $comboPrice)) {
            $modifiedsAtrr["comboPrice"] = $comboPrice;
        }

        if (isNotSame($orgData[0]['availability'], $availability)) {
            $modifiedsAtrr["availability"] = $availability;
        }

        if ($imgChanges == 1) {
            $modifiedsAtrr["displayPic"] = $comboIMG;
        }





        if (isset($modifiedsAtrr["comboCode"])) {
            if ($obj->checkCombo($comboName, "comboName")) {
                $msg = "Combo name already used.";
                http_response_code(200);
                header("Content-Type: application/json");
                echo json_encode(["res" => "minorerr", "msg" => $msg]);
                return;
            }
        }

        if (isset($modifiedsAtrr["comboCode"])) {
            if ($obj->checkCombo($comboCode, "comboCode")) {
                $msg = "Combo code already used.";
                http_response_code(200);
                header("Content-Type: application/json");
                echo json_encode(["res" => "minorerr", "msg" => $msg]);
                return;
            }
        }
        $resType = "minorerr";


        if (count($modifiedsAtrr) !== 0 || $modifItems !== 0) {
            $msg = "";
            if ($reqtype === "check") {
                $msg = '<p style="color:#00dd00">Ready to update...</p>';
                http_response_code(200);
                $resType = "no error";
            } else if ($reqtype === "update") {
                // $obj->addCategory();

                // if ($obj->updateCategoryName($id,$category_name)) {
                $msg = "Combo Updated Successfully...";
                $resType = "success";
                http_response_code(200);
                // }else{
                //     $msg = "Execution error.";
                //     $res = "failed";
                //     http_response_code(400);
                // }
                $errorCount = 0;

                if ($obj->combo_itemsdelete($comboID)) {
                    if ($modifItems !== 0) {
                        foreach ($combosDumped as $key => $value) {
                            if (!$obj->newComboItems(intval($comboID),$value)) {
                                $errorCount += 1;
                            }
                        }
                    }
                    if (count($modifiedsAtrr) !== 0) {
                        foreach ($modifiedsAtrr as $key => $value) {
                            if (!$obj->updateComboThings($key, $value, $comboID)) {
                                $errorCount += 1;
                            }
                        }
                    }
                }else{
                    $errorCount += 1;
                }
                if ($errorCount > 0) {
                    $msg = "Execution error.";
                    http_response_code(400);
                }
            } else {
                $msg = "Execution error.";
                http_response_code(400);
            }
        } else {
            $msg = "No changes made.";
            $resType = "minorerr";
        }



        http_response_code(200);
        header("Content-Type: application/json");
        echo json_encode(["res" => $resType, "msg" => $msg]);
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

        $comboName = htmlspecialchars(strip_tags(trim($_POST['comboName'])));
        $comboPrice = intval($_POST['comboPrice']);
        $comboCode = htmlspecialchars(strip_tags(trim($_POST['comboCode'])));
        $availability = htmlspecialchars(strip_tags(trim($_POST['availability'])));

        $combos = array();


        if (empty($comboName) || empty($comboPrice) || empty($availability) || empty($comboCode)) {
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
        if ($prodController->checkCombo($comboName, "comboName")) {
            echo "Combo name already used.";
            return;
        }
        if ($prodController->checkCombo($comboCode, "comboCode")) {
            echo "Combo code already used.";
            return;
        }
        $prodController->insertCombo($combos, $comboIMG, $comboName, $comboCode, $comboPrice, $availability);

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
        $obj = $prodController->findCatGt($catName, $selected_page);
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
            for ($i = 1; $i <= $total_pages; $i++) {
                // if ($i === 8) {
                //     echo '<button type="button" id="more">...</button>';
                //     break;
                // }
                $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="' . $i . '">';
                echo $g . $i;
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
        $obj = $prodController->findComboGt($comboName, $selected_page);
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
            for ($i = 1; $i <= $total_pages; $i++) {
                // if ($i === 8) {
                //     echo '<button type="button" id="more">...</button>';
                //     break;
                // }
                $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="' . $i . '">';
                echo $g . $i;
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

function getSelected($comboIDSelected, $type, $sumT = 1)
{

    $searchShow = new ProductController(null, $comboIDSelected, null, null, null, null, null);
    $rows = $searchShow->getProdSearchComboByID();

    $tPrice = 0;
    $item = 0;
    $eventID = "";
    if ($sumT == 1) {
        $eventID = "rmSelectedCombo";
    } else {
        $eventID = "rmSelectedComboEdit";
    }
    $modif = "";
    if ($type == "modif") {
        $modif = "modif ";
    }
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
            if ($sumT == 1) {
                $_SESSION['comboSummary'] = $sum;
            } else {
                $_SESSION['comboDumpedSummary'] = $sum;
            }
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
            <ol class="' . $modif . '">
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
                        <i class="fas fa-minus" id="' . $eventID . '" style="color: rgb(241, 86, 65);"></i>                        
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
            if ($sumT == 1) {
                $_SESSION['comboSummary'] = $sum;
            } else {
                $_SESSION['comboDumpedSummary'] = $sum;
            }
        }
    } else {
        if ($sumT == 1) {
            unset($_SESSION['comboSummary']);
        } else {
            unset($_SESSION['comboDumpedSummary']);
        }
        echo "No selected products..";
    }
}


function getPForm($id, $data, $cat)
{

    $av = "";
    $availability = $data['availability'];
    if ($availability === "Available") {
        $av = '
        <option value="Available">Available</option>
        <option value="Not-available">Not-available</option>
        <option value="">Availability</option>
        ';
    } else if ($availability === "Not-available") {
        $av = '
        <option value="Available">Available</option>
        <option value="Not-available">Not-available</option>
        <option value="">Availability</option>
        ';
    } else {
        $av = '
        <option value="">Availability</option>
        <option value="Available">Available</option>
        <option value="Not-available">Not-available</option>
        ';
    }

    $catIDORG = $data['category_id'];
    $catSel = '<option value="' . $catIDORG . '" name="category">' . $data["category_name"] . '</option>';

    $check = [
        "name" => $data['name'],
        "categoryID" => $catIDORG,
        "availability" => $data['availability'],
        "price" => $data['price']
    ];

    foreach ($cat as $row) {
        $catIDLoop = $row["category_id"];
        if ($catIDLoop !== $catIDORG) {
            $catSel .= '<option value="' . $catIDLoop . '" name="category">' . $row["category_name"] . '</option>';
        }
    }
    $catSel .= '<option value="">Category</option>';

    return ["RtData" => '
        <div class="label_style">
            <p></p>
            <h3>Edit Products</h3>
            <p></p>
        </div>
        <section>
        <ol>
            <li class="picmeEdit">
                <div>
                    <img src="data:image/jpeg;base64 ,' . base64_encode($data['displayPic']) . '" id="editimgdisplay" dt="' . $id . '" alt="Display pic">
                </div>
                <label for="addpicedit">
                    <i class="fas fa-plus"></i>
                </label>
                <input type="file" id="addpicedit" style="visibility: hidden; position: absolute; height: 0; width: 0; " name="displayPic">
            </li>
        </ol>
        <ol>
            <li>
                <div>
                    <i class="fas fa-book"></i>
                    <input placeholder="Price" autocomplete="off" type="number" name="price" value="' . $data['price'] . '" id="prod_priceedit">
                </div>
                <p>Price</p>
            </li>
        </ol>
        </section>
        <section>
        <ol>
            <li>
                <div>
                    <i class="fas fa-book"></i>
                    <input type="text" autocomplete="off"  placeholder="Product" value="' . $data['name'] . '" id="prod_nameedit" name="name">
                </div>
                <p>Product</p>
            </li>
        </ol>
        <ol>
            <li>
                <div>
                    <i class="fas fa-book"></i>
                    <select name="availability" id="availabilityedit">
                        ' . $av . '
                    </select>
                </div>
                <p>Availability</p>
            </li>
            <li>
                <div>
                    <i class="fas fa-book"></i>
                    <select name="category" id="prod_category">
                        ' . $catSel . '
                    </select>
                </div>
                <p>Category</p>
            </li>
        </ol>
        <div class="edit_cont_button">
            <button type="submit" class="actr" id="validateProd" name="reqtype" value="check"><i class="fas fa-check-square"></i>Validate</button>
            <p>Need to remove BG? <a style="color: #00c4ff;" href="https://www.remove.bg/upload" target="blank">Click here..</a></p>
        </div>
        </section>
        <button type="button" id="cancedit" title="Cancel">
        <i class="fas fa-plus"></i>
        </button>
        <div class="responseedit">
        </div>
    ', "check" => $check];
}
// submit_editprod
function getCatForm($id, $data)
{

    return '
        <div class="uiInfo">
            <p></p>
            <h3>Edit Category</h3>
            <p></p>
        </div>
        <button id="cancelEditCat"><i class="fas fa-plus" style="transform: rotate(45deg);"></i></button>
        <form id="editcategory" dt="' . $id . '">
            <li>
                <i class="fas fa-book"></i>
                <input type="text" autocomplete="off"  id="editCatInput" placeholder="Category" value="' . $data['category_name'] . '" name="category">
                <p>Category</p>
            </li>
            <button id="validateCat" name="reqtype" value="check" type="submit"><i class="fas fa-check-square"></i>Validate</button>
        </form>
        <div class="editcategory-response">
        </div>
    ';
}
// submiteditCategory
function getCbForm($id, $data)
{
    $av = "";
    $availability = $data['availability'];
    if ($availability === "Available") {
        $av = '
        <option value="Available">Available</option>
        <option value="Not-available">Not-available</option>
        <option value="">Availability</option>
        ';
    } else if ($availability === "Not-available") {
        $av = '
        <option value="Available">Available</option>
        <option value="Not-available">Not-available</option>
        <option value="">Availability</option>
        ';
    } else {
        $av = '
        <option value="">Availability</option>
        <option value="Available">Available</option>
        <option value="Not-available">Not-available</option>
        ';
    }
    $totalPriceCombo = 0;
    $totalItemCombo = 0;
    $check = [
        "comboName" => $data['comboName'],
        "comboCode" => $data['comboCode'],
        "availability" => $data['availability'],
        "comboPrice" => $data['comboPrice']
    ];

    if (isset($_SESSION['comboDumpedSummary'])) {
        $sum = $_SESSION['comboDumpedSummary'];
        $totalPriceCombo = $sum['totalPriceCombo'];
        $totalItemCombo = $sum['totalItemCombo'];
    }
    return ["RtData" => '
    <div class="exitedit">
    <i class="fas fa-plus"></i>
</div>
<form id="editComboForm" enctype="multipart/form-data">
    <section>
        <div class="img-wrap-out">

            <div class="image-wrap">
                <img src="data:image/jpeg;base64 ,' . base64_encode($data['displayPic']) . '" id="comboDPEdit" dt="' . $id . '" alt="">
                <input type="file" style="visibility: hidden;" id="selectComboPicEdit" name="comboPic">
            </div>
            <label for="selectComboPicEdit">
                <i class="fas fa-plus"></i>
            </label>
        </div>
    </section>
    <section>
        <ol>
            <li>
                <i class="fas fa-book"></i>
                <input type="text" autocomplete="off"  name="comboName" value="' . $data['comboName'] . '" placeholder="Combo name..." id="comboNameEdit">
                <p>Combo name</p>
            </li>
            <li>
                <i class="fas fa-book"></i>
                <input type="text" autocomplete="off"  name="comboCode" value="' . $data['comboCode'] . '" placeholder="Combo code..." id="comboCodeEdit">
                <p>Combo code</p>
            </li>
        </ol>
        <ol>
            <li>
                <i class="fas fa-book"></i>
                <input type="number"  value="' . $data['comboPrice'] . '" name="comboPrice" placeholder="Price..." id="comboPriceEdit">
                <p>Price</p>
            </li>
            <div class="data_summary_combo_edit">
                <li>
                    <h3>₱' . $totalPriceCombo . '</h3>
                    <p>Products in Total</p>
                </li>
                <li>
                    <h3>' . $totalItemCombo . '</h3>
                    <p>Item/s</p>
                </li>
            </div>
        </ol>
        <ol>
            <li>
                <i class="fas fa-book"></i>
                <select name="availability" id="availEdit">
                    ' . $av . '
                </select>
            </li>
        </ol>
        <button id="tgedit" type="submit"></button>
    </section>
</form>
<div class="outer-response">
    <section>
        <div class="action-products-outer">

            <div class="action-products">
                <div id="viewSelEdit">

                    <h3>Products selected</h3>
                    <div class="data-products-selected">
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

                    </div>
                </div>

                <div id="findProdControllerEdit">

                    <h3>Find to add</h3>
                    <div class="find-prod">
                        <li>
                            <i class="fas fa-search"></i>
                            <input type="search" id="findProdInputEdit" autocomplete="off"
                                placeholder="Search for products or category..">
                        </li>
                    </div>
                    <div class="data-products">
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

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="combo-main-action">
            <button id="addRm-comboEdit" type="button"> <i class="fas fa-search"></i>Find producs</button>
            <button id="validateCombo" class="comboActr" type="submit" name="reqtype" value="check"><i class="fas fa-check-square"></i> Validate</button>
        </div>
        <div class="combo-response">
            <div class="waiting">
                <p></p>
                <p></p>
                <p></p>
                <p></p>
            </div>
        </div>
    </section>
</div>
    ', "check" => $check];
}

function isNotSame($org, $test)
{
    if ($org != $test) {
        return true;
    }
    return false;
}
// submiteditCombo
