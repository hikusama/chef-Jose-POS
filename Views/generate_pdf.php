<?php
require 'libfunc/vendor/autoload.php';
require_once '../Controller/overviewController.php';

use Dompdf\Dompdf;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['transac']) && $_POST['transac'] == "todayReports") {
        $range = array();

        $start = htmlspecialchars(trim($_POST['start']));
        $end = $_POST['end'] ?? "";
        $range[0] = $start;

        if (!empty($end)) {
            $range[1] = $end;
        }

        $obj = new OverviewController();

        $mainSum = $obj->pdfDataMain($range);
        $tProd = $obj->pdfTopProd($range);
        $lProd = $obj->pdfLeastProd($range);

        $tCmb = $obj->pdfTopCombo($range);
        $lCmb = $obj->pdfLeastCombo($range);

        $orders = $obj->pdfOrderList($range);


        if (!empty($end)) {
            $mainSum['date'] = date('M j, Y', strtotime($start)) . ' to ' . date('M j, Y', strtotime($end));
        } else {
            $mainSum['date'] = date('M j, Y', strtotime($start));
        }
        $html = getHtml($mainSum, $tProd, $lProd, $tCmb, $lCmb, $orders);

        $dompdf = new Dompdf();
 
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="converted.pdf"');
        echo $dompdf->output();
    } else {
        echo "No HTML content received.";
    }
}


function getHtml($sum, $tProd, $lProd, $tCmb, $lCmb, $orders)
{
    $dc = number_format($sum['discounts'], 0, ',');
    $ord = number_format($sum['ordered'], 0, ',');
    $sales = number_format(intval($sum['sales']), 0, ',');
    $date = $sum['date'];
    $Pdiv = count($lProd);
    $Pover = count($tProd)  + count($lProd) ;
    $Poutof = $Pdiv . ' Out of ' . $Pover . '<br>Unordered';

    $Cdiv = count($lCmb) ;
    $Cover = count($tCmb)  + count($lCmb) ;
    $Coutof = $Cdiv . ' Out of ' . $Cover . '<br>Unordered';
    $content = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            height: 100vh;
            padding: 2rem 10%;
        }

        .top1 {
            margin-top: 2rem;
            width: 100%;
            text-align: center;
        }

        .top1 h1 {
            margin-bottom: 1rem;
        }

        .top1 p {
            margin-bottom: 3rem;
        }

        .pdfCont {
            /* width: 100vw; */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .pdfCont table {
            border-collapse: collapse;
            /* width: 85%; */
            font-size: .8rem;
        }

        .ordersSec {
            margin: 2rem 0 3rem;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .ordersSec h3 {
            width: 100%;
            text-align: center;
            margin-bottom: 1rem;
        }

        .pdfCont table {
            width: 100%;
        }

        .pdfCont table tr>* {
            padding: .2rem .5rem;
        }

        .pdfCont table thead tr>* {
            padding: .6rem 1rem !important;
        }

        .pdfCont table thead tr {
            background-color: rgba(3, 255, 200, 0.514);
            /* color: white; */
        }

        .pdfCont .tops thead tr {
            background-color: rgba(3, 255, 200, 0.514);
            /* color: white; */
        }

        .pdfCont .least thead tr {
            background-color: rgba(255, 32, 3, 0.514);
            /* color: white; */
        }

        .sumr {
            width: 100%;
            /* display: flex;
    justify-content: center;
    flex-direction: column; 
    align-items: center;
    gap: 3rem; */
            position: relative;
            margin-bottom: 2rem;
            height: 11.95rem;
        }

        .sumr li {
            list-style: none;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);

        }

        .sumr li>* {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .sumr li>*:nth-child(2) {
            top: 65%;

        }

        /* .sumr section {
    display: flex;
    justify-content: center;
    gap: 3rem;
} */

        .sumr li {
            background-color: rgba(24, 230, 203, 0.596);
            height: 8rem;
            width: 8rem;
            border: solid 4px;
            border-top: none;
            border-left: none;
            border-right: none;

        }

        .sumr li:nth-child(1) {
            left: 28%;
        }

        .sumr li:nth-child(3) {
            left: 72%;
        }

        .sumr li:nth-child(1),
        .sumr li:nth-child(3) {
            border-color: rgb(21, 114, 255);
        }

        .sumr li:nth-child(2) {
            left: 50%;
            background-color: rgba(165, 24, 230, 0.596);
            border-color: rgb(160, 0, 253);
        }

        .sumr .rpSales {
            height: 12rem;
            width: 12rem;
        }

        .sumraw {
            width: 100%;

        }

        .sout {
            width: 100%;
        }

        .sumraw table td {
            text-align: center;
        }

        .sumraw .top2 {
            margin: 1rem 0;
        }

 

        .lastG > *:nth-child(1) ,
        .sumraw section:nth-child(1) {
            margin-bottom: 1.5rem;
        }

        .lastG > * ,
        .sumraw section>* {
            padding: 0 5rem;
        }

        .top1out {
            height: 39rem;
            width: 100%;
            position: relative;
        }
        .top2out{
            position: absolute;
            width: 100%;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="pdfCont">

        <div class="top1out">
            <div class="top2out">

                <div class="top1">
                    <h1>Chef José Reports</h1>
                    <p>' . $date . '</p>
                </div>

                <div class="sumr">
                    <li class="rpDc">
                        <h2>P' . $dc . '</h2>
                        <p>Discounts</p>
                    </li>
                    <li class="rpSales">
                        <h2>P' . $sales . '</h2>
                        <p>Sales</p>
                    </li>
                    <li class="rpOrd">
                        <h2>' . $ord . '</h2>
                        <p>Orders</p>
                    </li>
                </div>
            </div>
        </div>


        <div class="sout">
            <div class="sumraw">
                <section>
                    <div class="prodAnalytics">

                        <div class="top2">
                            <h3>Popular products</h3>
                        </div>
                        <table border="1" class="tops">
                            <thead>
                                <tr>
                                    <th>Rank 10</th>
                                    <th>Date</th>
                                    <th>Item</th>
                                    <th>Ordered</th>
                                    <th>Sales</th>
                                </tr>
                            </thead>
                            <tbody>';

    $i = 1;

    if ($tProd) {
        foreach ($tProd as $row) {
            $nm = number_format(intval($row['sales']), 0, ",");

            $content .= '
            <tr>
                <td>' . $i . '</td>
                <td>' . $date . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['total_order'] . '</td>
                <td>P' . $nm . '</td>
            </tr>';
            $i++;
        }
    } else {
        $content .= '
            <tr>
                <td>0</td>
                <td>' . $date . '</td>
                <td>-----</td>
                <td>No product orders..</td>
                <td>N/A</td>
            </tr>';
    }
    $content .= ' 
                            </tbody>
                        </table>
                    </div>


                    

                </section>

                <section>
                    <div class="cmbAnalytics">

                        <div class="top2">
                            <h3>Popular combo`s</h3>
                        </div>
                        <table border="1" class="tops">
                            <thead>
                                <tr>
                                    <th>Rank 10</th>
                                    <th>Date</th>
                                    <th>Item</th>
                                    <th>Ordered</th>
                                    <th>Sales</th>
                                </tr>
                            </thead>
                            <tbody>';

    $i = 1;

    if ($tCmb) {
        foreach ($tCmb as $row) {
            $nm = number_format(intval($row['sales']), 0, ",");

            $content .= '
            <tr>
                <td>' . $i . '</td>
                <td>' . $date . '</td>
                <td>' . $row['comboName'] . '</td>
                <td>' . $row['total_order'] . '</td>
                <td>P' . $nm . '</td>
            </tr>';
            $i++;
        }
    } else {
        $content .= '
                <tr>
                    <td>0</td>
                    <td>' . $date . '</td>
                    <td>-----</td>
                    <td>No combo orders..</td>
                    <td>N/A</td>
                </tr>';
    }
    $content .= ' </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>

        <div class="ordersSec">
            <div class="top3">
                <h3>Orders</h3>
            </div>
            <table border="1">
                <thead>
                    <tr>
                        <th>##</th>
                        <th>Ref #</th>
                        <th>Tendered by</th>
                        <th>Item/s</th>
                        <th>To pay</th>
                        <th>Subtotal</th>
                        <th>Tendered</th>
                        <th>Method</th>
                        <th>Discount</th>
                        <th>Time</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>';

    $i = 1;
    if ($orders) {
        foreach ($orders as $row) {
            $name = $row['ename'] ?? $row['dname'];
            $content .= '
            <tr>
                <td>' . $i . '</td>
                <td>' . $row['ref_no'] . '</td>
                <td>' . $name . '</td>
                <td>' . $row['totalItems'] . '</td>
                <td>P' . $row['totalAmount'] . '</td>
                <td>P' . $row['subtotal'] . '</td>
                <td>P' . $row['tendered'] . '</td>
                <td>' . $row['paymentMethod'] . '</td>
                <td>' . $row['discount'] . '</td>
                <td>' . $row['orderTime'] . '</td>
                <td>
                    '. $date .'
                </td>
            </tr>';
            $i++;
        }
    } else {
        $content .= '
                <tr>
                    <td>0</td>
                    <td>-----</td>
                    <td>No orders..</td>
                    <td>N/A</td>
                    <td>P0</td>
                    <td>P0</td>
                    <td>P0</td>
                    <td>-</td>
                    <td>0</td>
                    <td>N/A</td>
                    <td>
                        ' . $date . '
                    </td>
                </tr>';
    }

 



    $content .= '</tbody>
            </table>
        </div>


        <div class="lastG">
            <div class="cmbAnalytics2">

                <div class="top2">
                    <h3>Least combo`s</h3>
                </div>
                <table border="1" class="least">
                    <thead>
                        <tr>
                            <th>' . $Coutof . '</th>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Ordered</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>';

    $i = 1;
    if ($lCmb) {
        foreach ($lCmb as $row) {

            $content .= '
            <tr>
                <td>' . $i . '</td>
                <td>' . $date . '</td>
                <td>' . $row['comboName'] . '</td>
                <td>0</td>
                <td>P0</td>
            </tr>';
            $i++;
        }
    } else {
        $content .= '
                <tr>
                    <td>0</td>
                    <td>' . $date . '</td>
                    <td>-----</td>
                    <td>All combo`s ordered..</td>
                    <td>N/A</td>
                </tr>';
    }

    $content .= '</tbody>
                </table>

            </div>
            <div class="prodAnalytics2">

                <div class="top2">
                    <h3>Least products</h3>
                </div>
                <table border="1" class="least">
                    <thead>
                        <tr>
                            <th>' . $Poutof . '</th>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Ordered</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>';

    $i = 1;
    if ($lProd) {
        foreach ($lProd as $row) {

            $content .= '
            <tr>
                <td>' . $i . '</td>
                <td>' . $date . '</td>
                <td>' . $row['name'] . '</td>
                <td>0</td>
                <td>P0</td>
            </tr>';
            $i++;
        }
    } else {
        $content .= '
                <tr>
                    <td>0</td>
                    <td>' . $date . '</td>
                    <td>-----</td>
                    <td>All products ordered..</td>
                    <td>N/A</td>
                </tr>';
    }


    $content .= '</tbody>
                </table>
            </div>
        </div>


    </div>
</body>

</html>';

    return $content;
}
