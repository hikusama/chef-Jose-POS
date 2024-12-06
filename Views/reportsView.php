<?php

require_once '../Controller/reportsController.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['transac']) && $_POST['transac'] === "getTSqData") {
        $reportsOBJ = new ReportstController();

        $row = $reportsOBJ->tsqData("", "");

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



    if (isset($_POST['transac']) && $_POST['transac'] === "getTCatData") {
        $reportsOBJ = new ReportstController();

        $rows = $reportsOBJ->tcatData("", "");
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
            $row["tmonSales"],
            $row["ttueSales"],
            $row["twedSales"],
            $row["tthuSales"],
            $row["tfriSales"],
            $row["tsatSales"],
            $row["tsunSales"]
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
        $tdiscounts = [
            $row["tmonDiscount"],
            $row["ttueDiscount"],
            $row["twedDiscount"],
            $row["tthuDiscount"],
            $row["tfriDiscount"],
            $row["tsatDiscount"],
            $row["tsunDiscount"]
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
        }else{
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
