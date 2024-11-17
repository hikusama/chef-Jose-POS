<?php

require_once '../Controller/historyController.php';
// require_once 'cashierView.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['transac']) && $_POST['transac'] === "getOrderRecord") {
        session_start();

        $ref = htmlspecialchars(strip_tags($_POST['refno']));
        $historyOBJ = new HistoryController(null, $ref);
        $_SESSION['openPrint'] = true;
        $rows = $historyOBJ->getOrderRecordControll();


        if ($rows) {
            $refNO = $rows[0]["ref_no"];
            echo '
            <ol>
            <p>'. $refNO.'</p>
            <h4>Reference No.</h4>
            </ol>
            <ol class="history_ordered">
            ';
            $ordersSession = array();
            $subtotal = $rows[0]["subtotal"];
            $gname = ($rows[0]["gcashAccountName"] != NULL) ? $rows[0]["gcashAccountName"] : "N/A";
            $gno = ($rows[0]["gcashAccountNo"] != NULL) ? $rows[0]["gcashAccountNo"] : "N/A";
            $dc = ($rows[0]["discount"] != NULL) ? $rows[0]["discount"] : "N/A";
            $dcT = ($rows[0]["discountType"] != NULL) ? $rows[0]["discountType"] : "N/A";
            $tA = $rows[0]["totalAmount"];
            $pM = $rows[0]["paymentMethod"];
            foreach ($rows as $row) {
                $name = ($row["itemType"] === "product") ? $row["name"] : $row["comboName"];
                $unitPrice = $row["unitPrice"];
                $quantity = $row["quantity"];
                echo '
                <li>
                    <p>'. $quantity.'</p>
                    <p>'. $name .'</p>
                    <p>₱'. $unitPrice.'</p>
                </li>
                ';

            $order = [];
            $order = [
                "name" => $name,
                "price" => $unitPrice,
                "qntity" => $quantity
            ];
            array_push($ordersSession,$order);
            }
            echo '
                    </ol>
                    <ol>
                        <li>
                            <p>Subtotal</p>
                            <p>₱'. $subtotal.'</p>
                        </li>
                        <li>
                            <p>Payment Method</p>
                            <p>'. $pM.'</p>
                        </li>
                        <li>
                            <p>Gcash Acc. name</p>
                            <p>'. $gname .'</p>
                        </li>
                        <li>
                            <p>Gcash Acc. no.</p>
                            <p>'.$gno .'</p>
                        </li>
                        <li>
                            <p>Discount (%)</p>
                            <p>'.$dc .'</p>
                        </li>
                        <li>
                            <p>Discount type</p>
                            <p>'.$dcT .'</p>
                        </li>
                        <li>
                            <p>Total Amount</p>
                            <p>₱'.$tA.'</p>
                        </li>
                    </ol>
                    <div class="askReceipt" id="'. $refNO .'">
                        <button type="button" id="print_receipt">Print</button>
                        <button type="button" id="delReceipt" title="Delete receipt">
                            <i class="fas fa-trash"></i>
                            <d>Delete</d>
                        </button>
                    </div>';
                    $_SESSION['ordersT'] = $ordersSession;
                    $_SESSION['discountT'] =( $dc == "N/A") ? NULL : $dc ;
                    $_SESSION['discountTypeT'] = ( $dcT == "N/A") ? NULL : $dcT;
                    $_SESSION['totalT'] = $tA;
                    $_SESSION['subtotalT'] = $subtotal;
                    $_SESSION['refNo2'] = $refNO;


        }else{
            echo '<div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%,-50%);">No producs...</div>';
        }
    }




    
    if (isset($_POST['transac']) && $_POST['transac'] === "getFindGroup") {

        $ref = htmlspecialchars(strip_tags($_POST['searchVal']));
        $group = htmlspecialchars(strip_tags($_POST['group']));
        $page = htmlspecialchars(strip_tags($_POST['page']));

        $valid_group = ["todayH", "yesterdayH", "weekH","tweekH"];

        if (!empty($group)) {
            if ((!in_array($group, $valid_group))) {
                echo "Invalid Group...".$group;
                return;
            }
        }
        $group_final = $group;
        // $group_final = (!$group) ? : "";
        if ($group == "todayH") {
            $group_final = " orderDate = CURDATE()";
        } else if ($group == "yesterdayH") {
            $group_final = " orderDate = CURDATE() - INTERVAL 1 DAY";
        } else if ($group == "tweekH") {
            // $group_final = " YEARWEEK(orderDate) = YEARWEEK(CURDATE(),3)";
            $group_final = " YEARWEEK(orderDate,1) = YEARWEEK(CURDATE(),1)";
        } else if ($group == "weekH") {
            $group_final = "MONTH(orderDate) = MONTH(CURDATE())";
        }
        

        $historyOBJ = new HistoryController(null, $ref);

        $obj = $historyOBJ->groupFind($group_final,$page);
        $rows = $obj['data'];
        $total_pages = $obj['total_pages'];
        $current_page = $obj['current_page'];


        if ($rows) {
            foreach ($rows as $row) {
                $rf = $row['ref_no'];
                $totalAmount = $row['totalAmount'];
                $orderDate = $row['orderDate'];
                $orderTime = $row['orderTime'];
                echo '
                    <ol>
                        <li class="key" id="' . $rf . '">
                            <h5>Amount Paid</h5>
                            <p>₱' . $totalAmount . '</p>
                        </li>
                        <li>
                            <h5>Reference No.</h5>
                            <p>' . $rf . '</p>
                        </li>
                        <li>
                            <h5>Date Time</h5>
                            <p>' . $orderDate . ' - ' . $orderTime . '</p>
                        </li>
                    </ol>
                ';
                
            }
            echo '
            <ol id="page-dir-cont" style="">
                <div class="main-dir-link">';
                for ($i=1; $i <= $total_pages ; $i++) {
                    // if ($i === 8) {
                    //     echo '<button type="button" id="more">...</button>';
                    //     break;
                    // }
                    $g = ($i == $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="'.$i.'">' ;
                    echo $g.$i;
                    echo '</button>';

                }
                echo '</div>
            </ol>
            ';
        } else {
            echo 'No order history...';
        }
    }
}
