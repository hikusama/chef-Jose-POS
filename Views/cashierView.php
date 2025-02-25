<?php

require_once '../Controller/cashierController.php';
require_once '../function.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {




    // PRODUCTS SHOW/SEARCH

    if (isset($_POST['transac']) && $_POST["transac"] === "searchNView") {
        // session_start();

        $page = htmlspecialchars(trim($_POST["page"]));
        $searchVal = htmlspecialchars(trim($_POST["searchVal"]));
        $category_id = htmlspecialchars(trim($_POST["category_id"]));

        $pdoTemp = new cashierController(null, $searchVal, null);
        $allCombo;
        $allProd;

        $total_pages = 0;
        $current_page = 1;
        if ($category_id == "cmb") {
            $obj = $pdoTemp->getAllComboss($page);
            $allCombo = $obj['data'];
            $total_pages = intval($obj['total_pages']);
            $current_page = intval($obj['current_page']);
            $_SESSION['categoryState'] = 'cmb';
        } else if (is_numeric((int)$category_id)) {
            unset($_SESSION['categoryState']);
            $obj = $pdoTemp->getAllProducts($category_id, $page);
            $allProd = $obj['data'];
            $total_pages = intval($obj['total_pages']);
            $current_page = intval($obj['current_page']);
        } else {
            echo "Something went wrong..";
            return;
        }

        if ($category_id == "cmb") {
            if ($allCombo) {

                foreach ($allCombo as $cmb) {
                    $availability = $cmb['availability'];
                    $ntv = "";
                    $ops = "";
                    $crs = "";
                    if ($availability === "Not-available") {

                        $ntv = '<p class="ntv">Not-available</p>';
                        $ops = ' style="opacity:50%;"';
                        $crs = ' style="pointer-events:none;"';
                    }
                    echo '
                    <ol' . $crs . '>' . $ntv . '
                        <li' . $ops . '><img id="' . $cmb['comboID'] . '" src="data:image/jpeg;base64,' . base64_encode($cmb['displayPic']) . '" alt="item"></li>
                        <li' . $ops . '>
                            <h5>' . $cmb['comboName'] . '</h5>
                            <h4><b>₱' . number_format($cmb['comboPrice'], 2, '.', ',') . '</b></h4>
                        </li>
                    </ol>
                
                ';
                }
                echo '
                <li id="page-dir-cont" style="">
                    <div class="main-dir-link">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="' . $i . '">';
                    echo $g . $i;
                    echo '</button>';
                }
                echo '</div>
                </li>
                ';
            } else {
                echo '<div class="nopr">No combo\'s..</div>';
            }
        } else {

            if ($allProd) {

                foreach ($allProd as $prod) {
                    $availability = $prod['availability'];
                    $ntv = "";
                    $ops = "";
                    $crs = "";
                    if ($availability === "Not-available") {
                        $ntv = '<p class="ntv">Not-available</p>';
                        $ops = ' style="opacity:50%;"';
                        $crs = ' style="pointer-events:none;"';
                    }
                    echo '
                    <ol' . $crs . '>' . $ntv . '
                        <li' . $ops . '><img id="' . $prod['productID'] . '" src="data:image/jpeg;base64,' . base64_encode($prod['displayPic']) . '" alt="item"></li>
                        <li' . $ops . '>
                            <h5>' . $prod['name'] . '</h5>
                            <h4><b>₱' . number_format($prod['price'], 2, '.', ',') . '</b></h4>
                        </li>
                    </ol>
                
                ';
                }
                echo '
            <li id="page-dir-cont" style="">
                <div class="main-dir-link">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="' . $i . '">';
                    echo $g . $i;
                    echo '</button>';
                }
                echo '</div>
            </li>
            ';
            } else {
                echo '<div class="nopr">No products..</div>';
            }
        }
    }


    // CART CHANGE QUANTITY

    if (isset($_POST['transac']) && $_POST["transac"] === "changeqntity" &&  isset($_POST["qntity"])) {

        // session_start();


        $qntity = htmlspecialchars(trim($_POST["qntity"]));
        $product_id = htmlspecialchars(trim($_POST["product_id"]));
        $type = htmlspecialchars(trim($_POST["type"]));


        if (
            empty($qntity) ||
            empty($product_id) ||
            empty($type)
        ) {
            return;
        }
        if ($qntity < 0) {
            return;
        }

        $prodOrder = array();
        $comboOrder = array();
        $orderSelected = array();
        $ordersSession = array();


        if (isset($_SESSION['comboOrders'])) {
            $comboOrder = $_SESSION['comboOrders'];
        }
        if (isset($_SESSION['prodOrders'])) {
            $prodOrder = $_SESSION['prodOrders'];
        }


        if ($type == "rmitemCombo") {
            if (isset($_SESSION['comboOrders'])) {
                $orderSelected = $_SESSION['comboOrders'];
            } else {
                echo "Something went wrong.....";
            }
        } else if ($type == "rmitem") {
            if (isset($_SESSION['prodOrders'])) {
                $orderSelected = $_SESSION['prodOrders'];
            } else {
                echo "Something went wrong.....";
            }
        }

        $array_size = count($orderSelected);


        for ($i = 0; $i < $array_size; $i++) {
            if ($product_id == $orderSelected[$i]["id"]) {
                $tempNewP = $orderSelected[$i]["price"] / $orderSelected[$i]["qntity"];
                $newP = $tempNewP * $qntity;
                $orderSelected[$i]["qntity"] = $qntity;
                $orderSelected[$i]["price"] = $newP;
                break;
            }
        }

        if ($type == "rmitemCombo") {
            $comboOrder = $orderSelected;
            $_SESSION['comboOrders'] = $comboOrder;
        } else if ($type == "rmitem") {
            $prodOrder = $orderSelected;
            $_SESSION['prodOrders'] = $prodOrder;
        }

        $ordersSession = array_merge($prodOrder, $comboOrder);
        $_SESSION['orders'] = $ordersSession;
    }


    // CART VIEW

    if (isset($_POST['transac']) && $_POST["transac"] === "viewCart") {
        $ordersSession = array();
        $prodOrder = array();
        $comboOrder = array();

        // session_start();
        if (isset($_SESSION['orders'])) {
            $ordersSession = $_SESSION['orders'];
            if (isset($_SESSION['prodOrders'])) {
                $prodOrder = $_SESSION['prodOrders'];
            }
            if (isset($_SESSION['comboOrders'])) {
                $comboOrder = $_SESSION['comboOrders'];
            }
        }


        if (isset($_POST["fakeTransac2"]) && $_POST["fakeTransac2"] === 'itsaprank2') {
            $_SESSION['ordersT'] = $_SESSION['orders'];
            if (isset($_SESSION['discount'])) {
                $_SESSION['discountT'] = $_SESSION['discount'];
                $_SESSION['discountTypeT'] = $_SESSION['discountType'];
            }
            $_SESSION['totalT'] = $_SESSION['total'];
            $_SESSION['subtotalT'] = $_SESSION['subtotal'];
        }

        if (isset($_POST["fakeTransac"]) && $_POST["fakeTransac"] === 'itsaprank') {
            unset($ordersSession);
            unset($_SESSION['orders']);
            unset($_SESSION['discount']);
            unset($_SESSION['discountType']);
            unset($_SESSION['total']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['comboOrders']);
            unset($_SESSION['prodOrders']);
            $ordersSession = array();
            $prodOrder = array();
            $comboOrder = array();
        }

        if (!isset($_POST["fakeTransac3"])) {
            dpCart($prodOrder, $comboOrder);
        }
    }


    // CART ITEM REMOVE

    if (isset($_POST['transac']) && $_POST["transac"] === "removeToCart") {
        $product_id = htmlspecialchars(trim($_POST["product_id"]));
        $itemType = htmlspecialchars(trim($_POST["itemType"]));

        $ordersSession = array();
        $prodOrder = array();
        $comboOrder = array();
        $orderSelected = array();

        // session_start();

        if (isset($_SESSION['comboOrders'])) {
            $comboOrder = $_SESSION['comboOrders'];
        }
        if (isset($_SESSION['prodOrders'])) {
            $prodOrder = $_SESSION['prodOrders'];
        }


        if ($itemType == "combo") {
            if (isset($_SESSION['comboOrders'])) {
                $orderSelected = $_SESSION['comboOrders'];
            } else {
                echo "Something went wrong.....";
            }
        } else if ($itemType == "prod") {
            if (isset($_SESSION['prodOrders'])) {
                $orderSelected = $_SESSION['prodOrders'];
            } else {
                echo "Something went wrong.....";
            }
        }



        $array_size = count($orderSelected);

        for ($i = 0; $i < $array_size; $i++) {
            if ($product_id === $orderSelected[$i]["id"]) {
                unset($orderSelected[$i]);
                $orderSelected = array_values($orderSelected);
                break;
            }
        }


        if ($itemType == "combo") {
            $comboOrder = $orderSelected;
            $_SESSION['comboOrders'] = $comboOrder;
        } else if ($itemType == "prod") {
            $prodOrder = $orderSelected;
            $_SESSION['prodOrders'] = $prodOrder;
        }


        $ordersSession = array_merge($prodOrder, $comboOrder);
        $_SESSION['orders'] = $ordersSession;
        dpCart($prodOrder, $comboOrder);

        if (count($ordersSession) == 0) {
            unset($_SESSION['orders']);
            unset($_SESSION['discountType']);
            unset($_SESSION['discount']);
            unset($_SESSION['total']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['comboOrders']);
            unset($_SESSION['prodOrders']);
        }
    }


    // CART ADD

    if (isset($_POST['transac']) && $_POST["transac"] === "addToCart") {
        // $transac =;
        // session_start();
        $id = htmlspecialchars(trim($_POST["product_id"]));

        $pdoTemp = new cashierController(null, null, $id);
        $prodOrder = array();
        $comboOrder = array();
        $orders = array();

        if (isset($_SESSION['categoryState'])) {
            $state = $_SESSION['categoryState'];
            if ($state == "cmb") {
                $fetch = $pdoTemp->addToCart("cmb");
                $price = (int)$fetch['comboPrice'];
                $availability = $fetch['availability'];
                if ($availability == "Not-available") {
                    echo "notav";
                    return;
                }
                $orderList = array(
                    "id" => $id,
                    "name" => $fetch['comboName'],
                    "qntity" => 1,
                    "itemprice" => $price,
                    "price" => $price
                );

                if (isset($_SESSION['comboOrders'])) {
                    $comboOrder = $_SESSION['comboOrders'];
                }

                $array_size = count($comboOrder);

                $tempVar = 1;

                for ($i = 0; $i < $array_size; $i++) {
                    if ($id == $comboOrder[$i]["id"]) {
                        $comboOrder[$i]["qntity"] += 1;
                        $comboOrder[$i]["price"] += $price;
                        $tempVar++;
                    }
                }


                if ($tempVar === 1) {
                    array_push($comboOrder, $orderList);
                }

                $_SESSION['comboOrders'] = $comboOrder;
            } else {
                echo "Something went wrong...";
                return;
            }
        } else {
            $fetch = $pdoTemp->addToCart("prd");
            $price = (int)$fetch['price'];
            $availability = $fetch['availability'];
            if ($availability === "Not-available") {
                echo "notav";
                return;
            }
            $orderList = array(
                "id" => $id,
                "name" => $fetch['name'],
                "qntity" => 1,
                "itemprice" => $price,
                "price" => $price
            );


            if (isset($_SESSION['prodOrders'])) {
                $prodOrder = $_SESSION['prodOrders'];
            }



            // array_push($prodOrder, $product_id);

            $array_size = count($prodOrder);

            $tempVar = 1;

            for ($i = 0; $i < $array_size; $i++) {
                if ($id == $prodOrder[$i]["id"]) {
                    $prodOrder[$i]["qntity"] += 1;
                    $prodOrder[$i]["price"] += $price;
                    $tempVar++;
                }
            }


            if ($tempVar === 1) {
                array_push($prodOrder, $orderList);
            }

            $_SESSION['prodOrders'] = $prodOrder;
            // var_dump($ordersSession);
            // $array_size = count($ordersSession);
            // var_dump($_SESSION['orders']);
        }
        if (isset($_SESSION['comboOrders'])) {
            $comboOrder = $_SESSION['comboOrders'];
        }
        if (isset($_SESSION['prodOrders'])) {
            $prodOrder = $_SESSION['prodOrders'];
        }
        $orders = array_merge($comboOrder, $prodOrder);
        $_SESSION['orders'] = $orders;


        dpCart($prodOrder, $comboOrder);
        $id = "";
    }


    // CATEGORY GET

    if (isset($_POST['transac']) && $_POST['transac'] === "getCateguri") {

        $pdoTemp = new cashierController(null, null, null);
        $categories = $pdoTemp->getAllCategory();

        echo '<li class="" id="cmb">Combo\'s</li>';
        echo '<li class="prod_nav" id="">All</li>';
        if ($categories) {

            foreach ($categories as $cat) {
                echo '<li id="' . $cat['category_id'] . '">' . $cat['category_name'] . '</li>';
            }
        }
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "showDiscountForm") {
        // session_start();
        $discount;
        $discountType;
        if (isset($_SESSION['discount'], $_SESSION['discountType'])) {
            $discount = $_SESSION["discount"];
            $discountType = $_SESSION["discountType"];
        } else {
            $discount = "";
            $discountType = "";
        }

        echo '
            <form id="addDC">
                <div class="discount-form">
                    <section>
                        <li>
                            <input type="number" value="' . $discount . '" id="discount" name="discount">
                            <p>Discount (%)</p>
                        </li>
                    </section>
                    <section>
                        <li>
                            <p>Discount Type</p>
                            <input type="text" value="' . $discountType . '" id="discountType" name="discountType">
                        </li>
                        <li>
                            <p>Discount Type options</p>
                            <select id="discountOpt">
                                <option class="type" value="">Type</option>
                                <option class="type" value="senior cetizens">Senior cetizens</option>
                                <option class="type" value="PWD">PWD</option>
                                <option class="type" value="* Remove Discount *">* Remove Discount *</option>
                            </select>
                        </li>
                    </section>
                    <section class="last_dd">
                        <button id="cancelD" type="button">Cancel</button>
                        <button id="apply" type="submit">Apply</button>
                    </section>
                    <div class="response"></div>
                </div>
            </form>
            ';
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "print") {
        // session_start();
        $uid = $_SESSION["userID"];
        $role = $_SESSION["userRole"];

        if(!isset($_SESSION['insert'])){
            $uid = $_SESSION["userIDReceipt"];
            $role = $_SESSION["userRoleReceipt"];
        }

        if ($role === "Admin") {
            $role = "Owner";
        }
        $obj = new cashierController(null, null, null);

        $tenderedByInfo = $obj->getName($uid);
        $tenderedBy = $tenderedByInfo["rN"];
        $refNo = '----';
        $subtotal = '----';
        $total = '----';
        $discount = '0';
        $change = "₱0";
        $tendered = "₱";
        $discountType = 'N/A';
        $dsSection = "";
        $gcashSection = "";
        $gcash = [
            "name" => NULL
        ];

        if (isset($_SESSION['subtotalT'], $_SESSION['totalT'])) {
            $subtotal = '₱' . $_SESSION['subtotalT'];
            $total = '₱' . $_SESSION['totalT'];
        }
        if (isset($_SESSION['refNo2'])) {
            $refNo = $_SESSION['refNo2'];
        }
        if (isset($_SESSION['discountT'], $_SESSION['discountTypeT']) && (($_SESSION['discountT'] = ! NULL) && ($_SESSION['discountT'] != NULL))) {
            $discountType = $_SESSION['discountTypeT'];
            // $discount = $_SESSION['discountT'] . '%';
            $discount = $_SESSION['discountT'];
            $sbt = $_SESSION['subtotalT'];
            $tt = $_SESSION['totalT'];
            $discount = (($sbt - $tt) / $sbt) * 100 . '%';
            $dsSection = '
            <ol>
                <li>Discount (%)</li>
                <li>' . $discount . '</li>
            </ol>
            <ol>
                <li>Discount type</li>
                <li style="text-align: end;">' . $discountType . '</li>
            </ol>';
        }

        $ordersSession = array();
        if (isset($_SESSION['ordersT'])) {
            $ordersSession = $_SESSION['ordersT'];
            $tt = $_SESSION['totalT'];
            $tendered = $_SESSION['tendered'];
            $change = "₱" . $tendered - $tt;
        }
        if (isset($_SESSION['gcash'])) {
            $gcash = $_SESSION['gcash'];
        }
        $array_size = count($ordersSession);
        date_default_timezone_set("Asia/manila");
        $date = date('d/m/Y');
        $time = date('h:i A');

        if ($gcash['name'] !== NULL) {
            $gcashSection = '
                            <ol>
                                <li>Gcash Acc. Name </li>
                                <li style="text-align: end;">' . $gcash["name"] . '</li>
                            </ol>
                            <ol>
                                <li>Gcash Acc. No </li>
                                <li>' . $gcash["no"]  . '</li>
                            </ol>';
        }


        echo '
            <div class="details">
                <section>

                    <hr>
                    <ol>
                        <li>Tendered</li>
                        <li>'.$tenderedBy.'</li>
                        <li>'.$role.'</li>
                    </ol>
                    <hr>
                    <ol>
                        <li>Date</li>
                        <li>' . $date . '</li>
                        <li>' . $time . '</li>
                    </ol>
                    <hr>
                    <ol>
                        <li>Ref no.</li>
                        <li>#' . $refNo . '</li>
                    </ol>
                    <hr>
                </section>
            </div>
            <div class="orders-receipt">
                <h3>Orders</h3>
                <table border="0" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
        if (isset($_SESSION['ordersT'])) {
            foreach ($ordersSession as $order) {
                echo '
                    <tr>
                        <td>' . $order['qntity'] . '</td>
                            <td>' . $order['name'] . ' @' . $order['itemprice'] . '</td>
                            <td>₱' . $order['price'] . '</td>
                        </tr>
                     ';
            }
        }



        echo '
                    </tbody>
                </table>
                <hr>
            </div>
            <div class="receipt-summary">
                <ol>
                    <li>Sub Total</li>
                    <li>' . $subtotal . '</li>
                </ol>
                ' . $gcashSection . $dsSection . '

                <ol>
                    <li>Tendered</li>
                    <li>' . $tendered . '</li>
                </ol>
                <ol>
                    <li>Total</li>
                    <li>' . $total . '</li>
                </ol>
                <hr>
                <ol class="chg">
                    <li>Change</li>
                    <li>' . $change . '</li>
                </ol>
            </div>
        ';
        if (isset($_SESSION['ordersT'])) {
            unset($_SESSION['refNo2']);
            unset($_SESSION['openPrint']);
            unset($_SESSION['ordersT']);
            unset($_SESSION['discountT']);
            unset($_SESSION['discountTypeT']);
            unset($_SESSION['totalT']);
            unset($_SESSION['subtotalT']);
            unset($_SESSION['tendered']);
            unset($_SESSION['gcash']);

            unset($_SESSION["userIDReceipt"]);
            unset($_SESSION["userRoleReceipt"]);
        }
        // var_dump($ordersSession);
        // var_dump(implode($ordersSession));


        // var_dump(implode(',',$orderList));
        // var_dump($ordersSession);




    }


    if (isset($_POST['transac']) && $_POST['transac'] === "pay") {
        // session_start();
        $customer_money = intval($_POST["money"]);
        if (isset($_SESSION['total'])) {
            $total = $_SESSION['total'];
            $gcashName = NULL;
            $gcashNum = NULL;
            $pmethod = htmlspecialchars(trim($_POST['pmethod']));


            if (!($pmethod == 'Cash' || $pmethod == 'G-Cash')) {
                echo 'Invalid payment method.';
                return;
            }
            if ($pmethod == 'G-Cash') {
                $gcashName = htmlspecialchars(trim($_POST['gcashName']));
                $gcashNum = htmlspecialchars(trim($_POST['gcashNum']));
                $numSize = $gcashNum;
                $numSize = strlen($numSize);
                if (empty($gcashNum) || empty($gcashName)) {
                    echo 'G-Cash section must be filled.';
                    return;
                } else if (!is_numeric($gcashNum)) {
                    echo 'G-Cash number must be integer.';
                    return;
                } else if ($numSize < 11 || $numSize > 11) {
                    echo 'G-Cash number must be 11Digits.';
                    return;
                }
            }

            if (empty($pmethod) || empty($customer_money)) {
                echo 'Input all fields.';
            } else if ($total > $customer_money) {
                echo 'Customer money is not enough.';
            } else if ($total != 0) {
                $_SESSION['insert'] = true;
                $_SESSION['openPrint'] = true;
                $uid = $_SESSION['userID'];
                $pdoTemp = new cashierController(null, null, null);
                $lastId = strval($pdoTemp->getRefNo());
                $randNo = random_int(10000, 99999);
                $refNo = $lastId . strval($randNo);
                $refNo = intval($refNo);
                $_SESSION['refNo2'] = $refNo;
                $gcash = [
                    "name" => $gcashName,
                    "no" => $gcashNum,
                ];

                submitOrders($refNo, $total, $pmethod, $gcashName, $gcashNum, $customer_money,$uid);

                $tempTotal = ($customer_money - $total);
                $tempTotal = number_format($tempTotal, 2, '.');
                echo '
                    <div class="change-cont">
                        <div class="change">
                            <h2>Change</h2>
                            <h4>₱' . $tempTotal . '</h4>
                            <button type="button" id="counted">Done</button>
                            <p>Next order please...</p>
                        </div>
                    </div>
                ';
                $_SESSION['tendered'] = $customer_money;
                $_SESSION['gcash'] = $gcash;
                $_SESSION['confirmation'] = true;
            }
        } else {
            echo 'No Orders Yet...';
        }
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "addingDiscount") {
        $discountType = htmlspecialchars(trim($_POST["discountType"]));
        $discount = (int)$_POST["discount"];
        // session_start();

        if (
            empty($discount) ||
            empty($discountType)
        ) {
            echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">Fill in all fields...</p>';
        } else if (!isset($_SESSION['orders'])) {
            echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">No Orders Yet...</p>';
        } else  if ($discountType == '* Remove Discount *') {
            if (!isset($_SESSION['discount'])) {
                echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">No discount applied...</p>';
            } else {
                echo 'discount removed';
                unset($_SESSION['discountType']);
                unset($_SESSION['discount']);
            }
        } else if ($discount > 100) {
            echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">Can\'t discount morethan 100%...</p>';
        } else if ($discount < 1) {
            echo '<p style="white-space:nowrap; color:#ff4141;font-size: 1.1rem;" class="errorText">Invalid discount...</p>';
        } else {
            $_SESSION['discount'] = $discount;
            $_SESSION['discountType'] = $discountType;
        }
    }


    if (isset($_POST['transac']) && $_POST['transac'] === "totalShow") {


        // session_start();

        if (!isset($_SESSION['orders'])) {
            echo '
            <section>
                <li>Subtotal</li>
                <li>₱0</li>
            </section>
            <section>
                <li>Discount (%)</li>
                <li>0</li>
            </section>
            <section>
                <li>Total Amount</li>
                <li>₱0</li>
            </section>
            
            
            ';
        } else {



            $orders = $_SESSION['orders'];
            $array_size = count($orders);

            $subtotal = 0;
            $total = 0;

            for ($i = 0; $i < $array_size; $i++) {
                $subtotal += $orders[$i]['price'];
            }



            // if ($discount = 0) {

            //     $_SESSION['discount'] = $discount;
            //     $Tempdiscount = ($discount / 100) * $subtotal;
            //     $total = $subtotal - $Tempdiscount;
            // } else 
            $discount;
            if (isset($_SESSION['discount']) && $_SESSION['discount'] != 0 && $_SESSION['discount'] != NULL) {
                $discount = $_SESSION['discount'];
                $Tempdiscount = ($discount / 100) * $subtotal;
                $total = $subtotal - $Tempdiscount;
            } else {
                $discount = 0;
                $total = $subtotal;
            }
            $totalTemp = number_format($total, 2, '.', ',');
            $subtotalTemp = number_format($subtotal, 2, '.', ',');
            echo '
            <section>
                <li>Subtotal</li>
                <li>₱' . $subtotalTemp . '</li>
            </section>
            <section>
                <li>Discount (%)</li>
                <li>' . $discount . '</li>
            </section>
            <section>
                <li>Total Amount</li>
                <li>₱' . $totalTemp . '</li>
            </section>
            
            
            ';
            $_SESSION['total'] = $total;
            $_SESSION['subtotal'] = $subtotal;
        }
    }
}

function dpCart($prodArr, $comboArr)
{
    if (!$prodArr && !$comboArr) {
        return;
    }
    if ($comboArr) {
        foreach ($comboArr as $value) {
            echo '
                    <ol>
                        <li>
                            <p class="arrow_controll"><i class="fas fa-arrow-right"></i></p>
                            <p>' . $value['qntity'] . '</p>
                            <p>' . $value['name'] . '</p>
                            <p class="pr">₱' . $value['price'] . '</p>
                            <div id="' . $value['id'] . '" class="edga"><i id="rmitemCombo" class="fas fa-plus" title="Remove Item" style="transform: rotate(45deg);"></i></div>
                        </li>
                        <li class="qntity">
                            <div>
                                <p>Quantity</p>
                                <form id="changeqntity">
                                    <input type="number" value="' . $value['qntity'] . '" name="qntity" >
                                </form>
                            </div>
                        </li>
                    </ol>
        ';
        }
    }
    if ($prodArr) {
        foreach ($prodArr as $value) {
            echo '
                    <ol>
                        <li>
                            <p class="arrow_controll"><i class="fas fa-arrow-right"></i></p>
                            <p>' . $value['qntity'] . '</p>
                            <p>' . $value['name'] . '</p>
                            <p class="pr">₱' . $value['price'] . '</p>
                            <div id="' . $value['id'] . '" class="edga"><i id="rmitem" class="fas fa-plus" title="Remove Item" style="transform: rotate(45deg);"></i></div>
                        </li>
                        <li class="qntity">
                            <div>
                                <p>Quantity</p>
                                <form id="changeqntity">
                                    <input type="number" value="' . $value['qntity'] . '" name="qntity" >
                                </form>
                            </div>
                        </li>
                    </ol>
        ';
        }
    }
}

function submitOrders($refNo, $totalAmount, $pmethod, $gcashName, $gcashNum, $tendered,$uid)
{

    if (isset($_SESSION['orders'])) {
        $subtotal = $_SESSION['subtotal'];
        $orders = $_SESSION['orders'];
        $prodOrder = (isset($_SESSION['prodOrders'])) ? $_SESSION['prodOrders'] : [];
        $comboOrder = (isset($_SESSION['comboOrders'])) ? $_SESSION['comboOrders'] : [];
        $discount = 0;
        $discountType = NULL;
        if (isset($_SESSION['discount'])) {
            $discount = $subtotal - $totalAmount;
            $discountType = $_SESSION['discountType'];
        }



        $orderList = [];
        foreach ($prodOrder as $dd) {
            $id = $dd['id'];
            $price = $dd['price'];
            $qntity = $dd['qntity'];
            // array_push($orderList,)
            $orderList[] = [
                "userID" => $uid,
                "product_id" => $id,
                "price" => $price,
                "qntity" => $qntity,
                "refNo" => $refNo,
                "discount" => $discount,
                "discountType" => $discountType,
                "totalAmount" => $totalAmount,
                "pmethod" => $pmethod,
                "gcashName" => $gcashName,
                "gcashNum" => $gcashNum,
                "subtotal" => $subtotal,
                "tendered" => $tendered,
            ];
        }

        $comboOrderList = [];
        foreach ($comboOrder as $dd) {
            $id = $dd['id'];
            $price = $dd['price'];
            $qntity = $dd['qntity'];
            // array_push($orderList,)
            $comboOrderList[] = [
                "userID" => $uid,
                "combo_id" => $id,
                "price" => $price,
                "qntity" => $qntity,
                "refNo" => $refNo,
                "discount" => $discount,
                "discountType" => $discountType,
                "totalAmount" => $totalAmount,
                "pmethod" => $pmethod,
                "gcashName" => $gcashName,
                "gcashNum" => $gcashNum,
                "subtotal" => $subtotal,
                "tendered" => $tendered,

            ];
        }

        $pdoTemp = new cashierController($orderList, null, null);
        $pdoTemp->submitOrdersController($comboOrderList);
        $pdoTemp = new cashierController(null, null, null);
        unset($orders);
        unset($comboOrderList);
        unset($prodOrder);
        unset($comboOrder);
        unset($orderList);
        // unset($_SESSION['refNo']);



    }
}
