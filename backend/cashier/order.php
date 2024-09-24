<?php

require_once "cashier.controller.php";


class order extends cashier_controller
{


    public function displayOnCart($product_id): array
    {
        $pdoTemp = new cashier_controller();
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
                            <p>₱' . $value['price'] . '</p>
                            <div id="' . $value['product_id'] . '"><i id="rmitem" class="fas fa-plus" title="Remove Item" style="transform: rotate(45deg);"></i></div>
                        </li>
                        <li class="qntity">
                            <div>
                                <p>Quantity</p>
                                <input type="number" value="' . $value['qntity'] . '" name="qntity" id="">
                            </div>
                        </li>
                    </ol>
        ';
            }
        }
    }
}




if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST["transac"] === "viewCart") {
    $pdoTemp = new order();
    $ordersSession = array();

    session_start();
    if (isset($_SESSION['orders'])) {
        $ordersSession = $_SESSION['orders'];
    }

    $pdoTemp->dpCart($ordersSession);

}

if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST["transac"] === "removeToCart") {
    $product_id = $_POST["product_id"];


    $pdoTemp = new order();
    $ordersSession = array();

    session_start();
    if (isset($_SESSION['orders'])) {
        $ordersSession = $_SESSION['orders'];
    }
    $array_size = count($ordersSession);


    for ($i = 0; $i < $array_size; $i++) {
        if (in_array($product_id, $ordersSession[$i])) {
            unset($ordersSession[$i]);
            $ordersSession = array_values($ordersSession);
            break;
        }
    }




    $_SESSION['orders'] = $ordersSession;
    $pdoTemp->dpCart($ordersSession);

}


if ($_SERVER["REQUEST_METHOD"] === "POST" &&  $_POST["transac"] === "addToCart") {
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
