<?php

require_once '../Controller/historyController.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {



    if (isset($_POST['transac']) && $_POST['transac'] === "getOrderRecord") {
        $ref = htmlspecialchars(strip_tags($_POST['ref']));
        $historyOBJ = new HistoryController(null, $ref);
        $rows = $historyOBJ->getOrderRecordControll();


        if ($rows) {
            foreach ($rows as $row) {
                echo '
                    <ol>
                    <p>7874445741</p>
                    <h4>Reference No.</h4>
                    </ol>
                    <ol class="history_ordered">
                        <li>
                            <p>3</p>
                            <p>Beef patty sdsadadsd</p>
                            <p>₱121</p>
                        </li>

                    </ol>
                    <ol>
                    <li>
                        <p>Payment Method</p>
                        <p>Gcash</p>
                    </li>
                    <li>
                        <p>Subtotal</p>
                        <p>₱1451</p>
                    </li>
                    <li>
                        <p>Discount (%)</p>
                        <p>10</p>
                    </li>
                    <li>
                        <p>Total Amount</p>
                        <p>₱1351</p>
                    </li>
                    </ol>
                    <div class="askReceipt" id="">
                        <button type="button" id="print_receipt">Print</button>
                        <button type="button" id="delReceipt" title="Delete receipt">
                            <i class="fas fa-trash"></i>
                            <d>Delete</d>
                        </button>
                    </div>
                ';
            }
        }
    }




    
    if (isset($_POST['transac']) && $_POST['transac'] === "getFindGroup") {

        $ref = htmlspecialchars(strip_tags($_POST['searchVal']));
        $group = htmlspecialchars(strip_tags($_POST['group']));
        $page = htmlspecialchars(strip_tags($_POST['page']));

        $valid_group = ["todayH", "yesterdayH", "weekH"];

        if (!empty($group)) {
            if ((!in_array($group, $valid_group))) {
                echo "Invalid Group...".$group;
                return;
            }
        }
        $group_final = $group;
        // $group_final = (!$group) ? : "";
        if ($group == "todayH") {
            $group_final = " CURDATE()";
        } else if ($group == "yesterdayH") {
            $group_final = " CURDATE() - INTERVAL 1 DAY";
        } else if ($group == "weekH") {
            $group_final = " CURDATE() - INTERVAL 7 DAY";
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
