<?php

require_once '../Controller/reportsController.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['transac']) && $_POST['transac'] === "getTSqData") {
        $reportsOBJ = new ReportstController();

        $row = $reportsOBJ->tsqData();

        $discount = [
            $row["today_discount"],
            $row["Ltoday_discount"]
        ];

        $pmethod = [
            (int)$row["gcash_count"],
            (int)$row["cash_count"]
        ];

        $ts = $row["today_sales"];
        $td = $row["today_discount"];
        $to = (int)$row["today_orders"];

        $Lts = $row["Ltoday_sales"];
        $Ltd = $row["Ltoday_discount"];
        $Lto = (int)$row["Ltoday_orders"];

        $salesmonth = $row['salesmonth'];
        $discountmonth = $row['discountmonth'];
        $ordersmonth = $row['ordersmonth'];

        $Lsalesmonth = $row['Lsalesmonth'];
        $Ldiscountmonth = $row['Ldiscountmonth'];
        $Lordersmonth = $row['Lordersmonth'];

        $salesweek = $row['salesweek'];
        $discountweek = $row['discountweek'];
        $ordersweek = $row['ordersweek'];

        $Lsalesweek = $row['Lsalesweek'];
        $Ldiscountweek = $row['Ldiscountweek'];
        $Lordersweek = $row['Lordersweek'];

        // Sales P
        $Std = cP($ts, $Lts);
        $Stm = cP($salesmonth, $Lsalesmonth);
        $Stw = cP($salesweek, $Lsalesweek);

        // Discount P
        $Dtd = cP($td, $Ltd);
        $Dtm = cP($discountmonth, $Ldiscountmonth);
        $Dtw = cP($discountweek, $Ldiscountweek);

        // Orders P
        $Otd = cP($to, $Lto);
        $Otm = cP($ordersmonth, $Lordersmonth);
        $Otw = cP($ordersweek, $Lordersweek);

        $raise = [
            "salesT" => $Std,
            "salesM" => $Stm,
            "salesW" => $Stw,

            "discountT" => $Dtd,
            "discountM" => $Dtm,
            "discountW" => $Dtw,

            "ordersT" => $Otd,
            "ordersM" => $Otm,
            "ordersW" => $Otw,
        ];




        /*
SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS salesmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN discount ELSE 0 END) AS discountmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN 1 ELSE 0 END) AS ordersmonth,

                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS salesweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS discountweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS ordersweek,  

                            -- last things
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS Lsalesmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) - 1 THEN discount ELSE 0 END) AS Ldiscountmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) - 1 THEN 1 ELSE 0 END) AS Lordersmonth,

                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS Lsalesweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS Ldiscountweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS Lordersweek,  

*/
        $sqaredata = [
            "discount" => $discount,
            "pMethod" => $pmethod,
            "todaySales" => $ts,
            "todayDiscount" => $td,
            "todayOrders" => $to,

            "salesmonth" => $salesmonth,
            "discountmonth" => $discountmonth,
            "ordersmonth" => $ordersmonth,

            "salesweek" => $salesweek,
            "discountweek" => $discountweek,
            "ordersweek" => $ordersweek,
            "rates" => $raise,


        ];
        echo json_encode($sqaredata);
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "getTCatData") {
        $reportsOBJ = new ReportstController();

        $rows = $reportsOBJ->tcatData();
        $name = [];
        $countsold = [];

        $notempt = false;
        if (empty($rows[0]["category_name"])) {
            $notempt = false;
        } else {
            $notempt = true;
        }
        foreach ($rows as $row) {
            array_push($name, $row["category_name"]);
            array_push($countsold, $row["total_sold_today"]);
        }


        // echo json_encode(["name" => $name, "sold" => $countsold]);
        echo json_encode(["name" => $name, "sold" => $countsold, "conf" => $notempt]);
    }


    if (isset($_POST['transac']) && $_POST['transac'] === "getTWeekData") {
        $reportsOBJ = new ReportstController();

        $row = $reportsOBJ->twkData();

        $tsales = [
            (float)$row["tmonSales"],
            (float)$row["ttueSales"],
            (float)$row["twedSales"],
            (float)$row["tthuSales"],
            (float)$row["tfriSales"],
            (float)$row["tsatSales"],
            (float)$row["tsunSales"]
        ];
        $torders = [
            (float)$row["tmonOrders"],
            (float)$row["ttueOrders"],
            (float)$row["twedOrders"],
            (float)$row["tthuOrders"],
            (float)$row["tfriOrders"],
            (float)$row["tsatOrders"],
            (float)$row["tsunOrders"]
        ];
        $tdiscounts = [
            (float)$row["tmonDiscount"],
            (float)$row["ttueDiscount"],
            (float)$row["twedDiscount"],
            (float)$row["tthuDiscount"],
            (float)$row["tfriDiscount"],
            (float)$row["tsatDiscount"],
            (float)$row["tsunDiscount"]
        ];



        $lsales = [
            $row["tlmonSales"],
            $row["tltueSales"],
            $row["tlwedSales"],
            $row["tlthuSales"],
            $row["tlfriSales"],
            $row["tlsatSales"],
            $row["tlsunSales"]
        ];
        $lorders = [
            $row["tlmonOrders"],
            $row["tltueOrders"],
            $row["tlwedOrders"],
            $row["tlthuOrders"],
            $row["tlfriOrders"],
            $row["tlsatOrders"],
            $row["tlsunOrders"]
        ];
        $ldiscounts = [
            $row["tlmonDiscount"],
            $row["tltueDiscount"],
            $row["tlwedDiscount"],
            $row["tlthuDiscount"],
            $row["tlfriDiscount"],
            $row["tlsatDiscount"],
            $row["tlsunDiscount"]
        ];

        $torders = rmtrailingzero($torders);
        $tdiscounts = rmtrailingzero($tdiscounts);
        $tsales = rmtrailingzero($tsales);



        echo json_encode([
            "tsales" => $tsales,
            "torders" => $torders,
            "tdiscounts" => $tdiscounts,
            "lsales" => $lsales,
            "lorders" => $lorders,
            "ldiscounts" => $ldiscounts

        ]);
    }






    /*               customize or finding data                 */


    if (isset($_POST['transac']) && $_POST['transac'] === "getCSSQD") {
        $reportsOBJ = new ReportstController();
        $from = ($_POST['from']) ? htmlspecialchars($_POST['from']) : "";
        $to =  (isset($_POST['to'])) ? htmlspecialchars($_POST['to']) : "";
        $Rtype =   htmlspecialchars($_POST['dr']);

        if ($Rtype == "single") {
            if (empty($from)) {
                echo json_encode(["error" => "Specify all date!!"]);
                return;
            }
        } else if ($Rtype == "double") {
            if (empty($from) || empty($to)) {
                echo json_encode(["error" => "Specify all date!!"]);
                return;
            }
        }
        $row = $reportsOBJ->cssqData($from, $to);

        $discount = [
            $row["today_discount"],
            $row["yesterday_discount"]
        ];

        $pmethod = [
            (int)$row["gcash_count"],
            (int)$row["cash_count"]
        ];

        $ts = $row["today_sales"];
        $td = $row["today_discount"];
        $to = (int)$row["today_orders"];


        $sqaredata = [
            "discount" => $discount,
            "pMethod" => $pmethod,
            "todaySales" => $ts,
            "todayDiscount" => $td,
            "todayOrders" => $to,
        ];
        echo json_encode($sqaredata);
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "getCSCatData") {

        $reportsOBJ = new ReportstController();
        $from = ($_POST['from']) ? htmlspecialchars($_POST['from']) : "";
        $to =  (isset($_POST['to'])) ? htmlspecialchars($_POST['to']) : "";
        $Rtype =   htmlspecialchars($_POST['dr']);

        if ($Rtype === "single") {
            if (empty($from)) {
                echo json_encode(["error" => "Specify all date!!"]);
                return;
            }
        } else if ($Rtype === "double") {
            if (empty($from) || empty($to)) {
                echo json_encode(["error" => "Specify all date!!"]);
                return;
            }
        }
        $date = "";
        if (!empty($from)) {
            if (!empty($to)) {
                $date = $from . " - " . $to;
            } else {
                $date = $from;
            }
        }
        $rows = $reportsOBJ->cscatData($from, $to);
        $name = [];
        $countsold = [];

        foreach ($rows as $row) {
            array_push($name, $row["category_name"]);
            array_push($countsold, (float)$row["total_sold_today"]);
        }

        $notempt = rmtrailingzero($countsold);

        // echo json_encode(["name" => $name, "sold" => $countsold]);
        echo json_encode(["name" => $name, "sold" => $countsold, "conf" => $notempt, "date" => $date]);
    }






    if (isset($_POST['transac']) && $_POST['transac'] === "getCSLineData") {
        $reportsOBJ = new ReportstController();
        $from = ($_POST['from']) ? htmlspecialchars($_POST['from']) : "";
        $Rtype =   htmlspecialchars($_POST['rtype']);
        $type =   htmlspecialchars($_POST['type']);

        if ($Rtype != "single") {
            return;
        }
        $idr = 7;
        if ($type == "monthcs") {
            $idr = 12;
        } else {
            $idr = 7;
        }

        if (empty($from)) {
            echo json_encode(["error" => "Specify all date!!"]);
            return;
        }

        $fetched = $reportsOBJ->csLineData($type, $from);
        $row = getCSLineData($fetched, $type);

        $tsales = [];
        $torders = [];
        $tdiscounts = [];

        $temptsales = $row["tsales"];
        $temptorders = $row["torders"];
        $temptdiscounts = $row["tdiscounts"];

        for ($i = 0; $i < $idr; $i++) {
            array_push($tsales, (float)$temptsales[$i]);
            array_push($torders, (float)$temptorders[$i]);
            array_push($tdiscounts, (float)$temptdiscounts[$i]);
            $tsales = array_values($tsales);
            $torders = array_values($torders);
            $tdiscounts = array_values($tdiscounts);
        }

        $tsales = rmtrailingzero($tsales);
        $torders = rmtrailingzero($torders);
        $tdiscounts = rmtrailingzero($tdiscounts);


        $lsales = $row['lsales'];
        $lorders = $row['lorders'];
        $ldiscounts = $row['ldiscounts'];


        echo json_encode(
            [
                "tsales" => $tsales,
                "torders" => $torders,
                "tdiscounts" => $tdiscounts,
                "lsales" => $lsales,
                "lorders" => $lorders,
                "ldiscounts" => $ldiscounts
            ]
        );
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "getItems") {
        $reportsOBJ = new ReportstController();

        $itemtype = htmlspecialchars($_POST['itemtype']);
        $data = htmlspecialchars($_POST['data']);
        $order = htmlspecialchars($_POST['order']);
        $rtype = htmlspecialchars($_POST['rTypeAnl']);
        $from = htmlspecialchars($_POST['from']);
        $to = htmlspecialchars($_POST['to']);

        $submitDate = [];

        if ($rtype === "singleAnl") {
            if (empty($from)) {
                http_response_code(400);
                echo json_encode(["error" => "Select a date."]);
                return;
            }
            $submitDate = [$from];
        } else if ($rtype === "doubleAnl") {
            if (empty($from) || empty($to)) {
                http_response_code(400);
                echo json_encode(["error" => "Select all date ranges."]);
                return;
            }
            $submitDate = [$from, $to];
        }

        if ($itemtype === "proddR") {
            $itemtype = "products";
        } else if ($itemtype === "combbR") {
            $itemtype = "combo";
        }

        if ($data === "orders-data") {
            $data = "oi.quantity";  
        } else if ($data === "sales-data") {
            $data = "(oi.unitPrice)";  
        }

        if ($order === "highest") {
            $order = "DESC";
        } else if ($order === "lowest") {
            $order = "ASC";
        }

        $rows = $reportsOBJ->getDataItem($itemtype, $order, $submitDate, $data);

        $bulk = "";
        if ($rows !== null) {
            $cnt = '';
            if ($data !== "oi.quantity") {
                $cnt = '₱';
            }
            foreach ($rows as $row) {
                
                $rate = RP((int)$row['TW'],(int)$row['LW']);

                
                $bulk .= '
                    <ol>
                        <section class="ssum">
                            <div class="headAnl">
                                <li>
                                    <div class="picMhen"><img id="' . $row['itemID'] . '" src="data:image/jpeg;base64, ' . base64_encode($row['displayPic']) . '" alt=""></div>
                                </li>
                                <li>
                                    <div class="contIn">
                                        <h4>' . $row['item'] . '</h4>
                                    </div>
                                </li>
                            </div>
                            <div class="bdcontt">
                                <div class="tod smm">
                                    <p>'. $cnt . $row['selData'] . '</p>
                                    <p>Today</p>
                                </div>
                                <div class="yd smm">
                                    <p>'. $cnt . $row['beforeData'] . '</p>
                                    <p>Yesterday</p>
                                </div>' . $rate . '
                            </div>
                        </section>
                    </ol>
                    ';

            }
            http_response_code(200);
            echo json_encode(["item" => $bulk]);
        }
    }
}



function getCSLineData($row, $type)
{
    $tsales = [];
    $lsales = [];

    $torders = [];
    $lorders = [];

    $tdiscounts = [];
    $ldiscounts = [];


    if ($type == "monthcs") {

        $tsales = [
            $row["janTS"],
            $row["febTS"],
            $row["marTS"],
            $row["aprTS"],
            $row["mayTS"],
            $row["juneTS"],
            $row["julTS"],
            $row["augTS"],
            $row["septTS"],
            $row["octTS"],
            $row["novTS"],
            $row["decTS"]
        ];
        $lsales = [
            $row["janLS"],
            $row["febLS"],
            $row["marLS"],
            $row["aprLS"],
            $row["mayLS"],
            $row["juneLS"],
            $row["julLS"],
            $row["augLS"],
            $row["septLS"],
            $row["octLS"],
            $row["novLS"],
            $row["decLS"]
        ];






        $torders = [
            $row["janTO"],
            $row["febTO"],
            $row["marTO"],
            $row["aprTO"],
            $row["mayTO"],
            $row["juneTO"],
            $row["julTO"],
            $row["augTO"],
            $row["septTO"],
            $row["octTO"],
            $row["novTO"],
            $row["decTO"]
        ];
        $lorders = [
            $row["janLO"],
            $row["febLO"],
            $row["marLO"],
            $row["aprLO"],
            $row["mayLO"],
            $row["juneLO"],
            $row["julLO"],
            $row["augLO"],
            $row["septLO"],
            $row["octLO"],
            $row["novLO"],
            $row["decLO"]
        ];




        $tdiscounts = [
            $row["janTD"],
            $row["febTD"],
            $row["marTD"],
            $row["aprTD"],
            $row["mayTD"],
            $row["juneTD"],
            $row["julTD"],
            $row["augTD"],
            $row["septTD"],
            $row["octTD"],
            $row["novTD"],
            $row["decTD"]
        ];

        $ldiscounts = [
            $row["janLD"],
            $row["febLD"],
            $row["marLD"],
            $row["aprLD"],
            $row["mayLD"],
            $row["juneLD"],
            $row["julLD"],
            $row["augLD"],
            $row["septLD"],
            $row["octLD"],
            $row["novLD"],
            $row["decLD"]
        ];
    } else if ($type == "weekcs") {


        $tsales = [
            $row["tmonSales"],
            $row["ttueSales"],
            $row["twedSales"],
            $row["tthuSales"],
            $row["tfriSales"],
            $row["tsatSales"],
            $row["tsunSales"]
        ];
        $lsales = [
            $row["tlmonSales"],
            $row["tltueSales"],
            $row["tlwedSales"],
            $row["tlthuSales"],
            $row["tlfriSales"],
            $row["tlsatSales"],
            $row["tlsunSales"]
        ];






        $torders = [
            $row["tmonOrders"],
            $row["ttueOrders"],
            $row["twedOrders"],
            $row["tthuOrders"],
            $row["tfriOrders"],
            $row["tsatOrders"],
            $row["tsunOrders"]
        ];
        $lorders = [
            $row["tlmonOrders"],
            $row["tltueOrders"],
            $row["tlwedOrders"],
            $row["tlthuOrders"],
            $row["tlfriOrders"],
            $row["tlsatOrders"],
            $row["tlsunOrders"]
        ];




        $tdiscounts = [
            $row["tmonDiscount"],
            $row["ttueDiscount"],
            $row["twedDiscount"],
            $row["tthuDiscount"],
            $row["tfriDiscount"],
            $row["tsatDiscount"],
            $row["tsunDiscount"]
        ];

        $ldiscounts = [
            $row["tlmonDiscount"],
            $row["tltueDiscount"],
            $row["tlwedDiscount"],
            $row["tlthuDiscount"],
            $row["tlfriDiscount"],
            $row["tlsatDiscount"],
            $row["tlsunDiscount"]
        ];
    }
    return [
        "tsales" => $tsales,
        "torders" => $torders,
        "tdiscounts" => $tdiscounts,
        "lsales" => $lsales,
        "lorders" => $lorders,
        "ldiscounts" => $ldiscounts
    ];
}
function rmtrailingzero($arr)
{

    while (end($arr) === 0.0) {
        array_pop($arr);
        $arr = array_values($arr);
    }
    return $arr;
}

function cP($s, $e)
{

    $ready = "0";

    if ($e == 0) {
        $ready = $s*100; 
    }else{
        $ready = (($s - $e) / $e ) * 100;
    }
    $ready = number_format($ready, 1, '.');
    $rtt = "";

    if ($ready < 0) {
        $rtt = '<p class="" style="color: rgb(215 0 0); white-space:nowrap;">' . $ready . '%</p>';
    } else if ($ready > 0) {
        $rtt = '<p class="" style="white-space:nowrap;">+' . $ready . '%</p>';
    } else {
        $rtt = '<p class="" style="white-space:nowrap;color: unset;"><b></b>0.0</p>';
    }


    return $rtt;
}
function RP($s, $e)
{

    $ready = "0";

    if ($e === 0) {
        $ready = $s*100; 
    }else{
        $ready = (($s - $e) / $e ) * 100;
    }
    $ready = number_format($ready, 1, '.');
    $rtt = "";

    if ($ready < 0) {
        $rtt = '<div class="rpRs" style="color: rgb(215 0 0); white-space:nowrap;">
                    <p style="">' . $ready . '%</p>
                    <p> From last week.</p>
                </div>';
    } else if ($ready > 0) {
        $rtt = '<div class="rpRs" style="color: green;white-space:nowrap;">
                    <p>+' . $ready . '%</p>
                    <p> From last week.</p>
                </div>';
    } else {
        $rtt = '<div class="rpRs" style="white-space:nowrap;color: unset;">
                    <p>0.0</p>
                    <p> From last week.</p>
                </div>';
    }


    return $rtt;
}
