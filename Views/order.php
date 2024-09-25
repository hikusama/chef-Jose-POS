<?php

require_once '../Controller/cashierController.php';



class order extends cashierController
{


    public function displayOnCart($product_id): array
    {
        $pdoTemp = new cashierController();
        $rows = $pdoTemp->addToCart($product_id);

        if ($rows) {
            return $rows;
        } else {
            return null;
        }
    }
    public function dpCart($ordersSession)
    {
        if ($ordersSession) {
            foreach ($ordersSession as $value) {
                echo '
                    <ol>
                        <li>
                            <p class="arrow_controll"><i class="fas fa-arrow-right"></i></p>
                            <p>' . $value['qntity'] . '</p>
                            <p>' . $value['product_name'] . '</p>
                            <p class="pr">₱' . $value['price'] . '</p>
                            <div id="' . $value['product_id'] . '" class="edga"><i id="rmitem" class="fas fa-plus" title="Remove Item" style="transform: rotate(45deg);"></i></div>
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
}




if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST["transac"] === "changeqntity" &&  isset($_POST["qntity"])) {



    $qntity = $_POST["qntity"];
    $product_id = $_POST["product_id"];

    $pdoTemp = new order();
    $ordersSession = array();

    session_start();
    if (isset($_SESSION['orders'])) {
        $ordersSession = $_SESSION['orders'];
    }

    $array_size = count($ordersSession);
    

    for ($i = 0; $i < $array_size; $i++) {
        if ($product_id == $ordersSession[$i]["product_id"]) {
            $tempNewP = $ordersSession[$i]["price"] / $ordersSession[$i]["qntity"];
            $newP = $tempNewP * $qntity;
            $ordersSession[$i]["qntity"] = $qntity;
            $ordersSession[$i]["price"] = $newP;
            break;
        }
    }

    $_SESSION['orders'] = $ordersSession;











}






if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST["transac"] === "viewCart" &&  !isset($_POST["qntity"])) {
    $pdoTemp = new order();
    $ordersSession = array();

    session_start();
    if (isset($_SESSION['orders'])) {
        $ordersSession = $_SESSION['orders'];
    }

    $pdoTemp->dpCart($ordersSession);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST["transac"] === "removeToCart" &&  !isset($_POST["qntity"])) {
    $product_id = $_POST["product_id"];


    $pdoTemp = new order();
    $ordersSession = array();

    session_start();
    if (isset($_SESSION['orders'])) {
        $ordersSession = $_SESSION['orders'];
    }
    $array_size = count($ordersSession);


    for ($i = 0; $i < $array_size; $i++) {
        if ($product_id == $ordersSession[$i]["product_id"]) {
            unset($ordersSession[$i]);
            $ordersSession = array_values($ordersSession);
            break;
        }
    }

    $array_size = count($ordersSession);



    $_SESSION['orders'] = $ordersSession;
    // $pdoTemp->dpCart($ordersSession);
    if ($array_size > 0) {
        echo "not_empty";
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST["transac"] === "addToCart" &&  !isset($_POST["qntity"])) {
    // $transac =;
    $product_id = $_POST["product_id"];


    $pdoTemp = new order();
    $product_fetch = $pdoTemp->displayOnCart($product_id);
    $price = (int)$product_fetch['price'];

    $orderList = array(
        "product_id" => $product_id,
        "product_name" => $product_fetch['name'],
        "qntity" => 1,
        "price" => $price
    );

    session_start();
    $ordersSession = array();

    if (isset($_SESSION['orders'])) {
        $ordersSession = $_SESSION['orders'];
    }



    // array_push($ordersSession, $product_id);

    $array_size = count($ordersSession);

    $tempVar = 1;

    for ($i = 0; $i < $array_size; $i++) {
        if ($product_id == $ordersSession[$i]["product_id"]) {
            $ordersSession[$i]["qntity"] += 1;
            $ordersSession[$i]["price"] += $price;
            $tempVar++;
        }
    }

    if ($tempVar === 1) {
        array_push($ordersSession, $orderList);
    }
    $product_id = "";

    $_SESSION['orders'] = $ordersSession;
    // var_dump($ordersSession);
    $array_size = count($ordersSession);
    // var_dump($_SESSION['orders']);
    $pdoTemp->dpCart($ordersSession);
}
