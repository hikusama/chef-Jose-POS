<?php

require_once '../Controller/reportsController.php';
require_once "../function.php";
isAdminRole();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['transac']) && $_POST['transac'] === "getTSqData") {
        $reportsOBJ = new ReportstController();

        $row = $reportsOBJ->tsqData();

        $discount = [
            $row["today_discount"] ?? 0,
            $row["Ltoday_discount"] ?? 0
        ];

        $pmethod = [
            (int)$row["gcash_count"] ?? 0,
            (int)$row["cash_count"] ?? 0
        ];

        $ts = $row["today_sales"] ?? 0;
        $td = $row["today_discount"] ?? 0;
        $to = (int)$row["today_orders"] ?? 0;

        $Lts = $row["Ltoday_sales"] ?? 0;
        $Ltd = $row["Ltoday_discount"] ?? 0;
        $Lto = (int)$row["Ltoday_orders"] ?? 0;

        $salesmonth = $row['salesmonth'] ?? 0;
        $discountmonth = $row['discountmonth'] ?? 0;
        $ordersmonth = $row['ordersmonth'] ?? 0;

        $Lsalesmonth = $row['Lsalesmonth'] ?? 0;
        $Ldiscountmonth = $row['Ldiscountmonth'] ?? 0;
        $Lordersmonth = $row['Lordersmonth'] ?? 0;

        $salesweek = $row['salesweek'] ?? 0;
        $discountweek = $row['discountweek'] ?? 0;
        $ordersweek = $row['ordersweek'] ?? 0;

        $Lsalesweek = $row['Lsalesweek'] ?? 0;
        $Ldiscountweek = $row['Ldiscountweek'] ?? 0;
        $Lordersweek = $row['Lordersweek'] ?? 0;

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
        header("Content-Type: application/json");

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

        header("Content-Type: application/json");

        // echo json_encode(["name" => $name, "sold" => $countsold]);
        echo json_encode(["name" => $name, "sold" => $countsold, "conf" => $notempt]);
    }


    if (isset($_POST['transac']) && $_POST['transac'] === "getTWeekData") {
        $reportsOBJ = new ReportstController();

        $row = $reportsOBJ->twkData();

        $tsales = [
            (float)$row["tmonSales"] ?? 0,
            (float)$row["ttueSales"] ?? 0,
            (float)$row["twedSales"] ?? 0,
            (float)$row["tthuSales"] ?? 0,
            (float)$row["tfriSales"] ?? 0,
            (float)$row["tsatSales"] ?? 0,
            (float)$row["tsunSales"] ?? 0
        ];
        $torders = [
            (float)$row["tmonOrders"] ?? 0,
            (float)$row["ttueOrders"] ?? 0,
            (float)$row["twedOrders"] ?? 0,
            (float)$row["tthuOrders"] ?? 0,
            (float)$row["tfriOrders"] ?? 0,
            (float)$row["tsatOrders"] ?? 0,
            (float)$row["tsunOrders"] ?? 0
        ];
        $tdiscounts = [
            (float)$row["tmonDiscount"] ?? 0,
            (float)$row["ttueDiscount"] ?? 0,
            (float)$row["twedDiscount"] ?? 0,
            (float)$row["tthuDiscount"] ?? 0,
            (float)$row["tfriDiscount"] ?? 0,
            (float)$row["tsatDiscount"] ?? 0,
            (float)$row["tsunDiscount"] ?? 0
        ];



        $lsales = [
            $row["tlmonSales"] ?? 0,
            $row["tltueSales"] ?? 0,
            $row["tlwedSales"] ?? 0,
            $row["tlthuSales"] ?? 0,
            $row["tlfriSales"] ?? 0,
            $row["tlsatSales"] ?? 0,
            $row["tlsunSales"] ?? 0
        ];
        $lorders = [
            $row["tlmonOrders"] ?? 0,
            $row["tltueOrders"] ?? 0,
            $row["tlwedOrders"] ?? 0,
            $row["tlthuOrders"] ?? 0,
            $row["tlfriOrders"] ?? 0,
            $row["tlsatOrders"] ?? 0,
            $row["tlsunOrders"] ?? 0
        ];
        $ldiscounts = [
            $row["tlmonDiscount"] ?? 0,
            $row["tltueDiscount"] ?? 0,
            $row["tlwedDiscount"] ?? 0,
            $row["tlthuDiscount"] ?? 0,
            $row["tlfriDiscount"] ?? 0,
            $row["tlsatDiscount"] ?? 0,
            $row["tlsunDiscount"] ?? 0
        ];

        $torders = rmtrailingzero($torders);
        $tdiscounts = rmtrailingzero($tdiscounts);
        $tsales = rmtrailingzero($tsales);

        header("Content-Type: application/json");


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
        $from = ($_POST['from']) ? htmlspecialchars(trim($_POST['from'])) : "";
        $to =  (isset($_POST['to'])) ? htmlspecialchars(trim($_POST['to'])) : "";
        $Rtype =   htmlspecialchars(trim($_POST['dr']));

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
            $row["today_discount"] ?? 0,
            $row["yesterday_discount"] ?? 0
        ];

        $pmethod = [
            (int)$row["gcash_count"] ?? 0,
            (int)$row["cash_count"] ?? 0
        ];

        $ts = $row["today_sales"] ?? 0;
        $td = $row["today_discount"] ?? 0;
        $to = (int)$row["today_orders"] ?? 0;


        $sqaredata = [
            "discount" => $discount,
            "pMethod" => $pmethod,
            "todaySales" => $ts,
            "todayDiscount" => $td,
            "todayOrders" => $to,
        ];
        header("Content-Type: application/json");

        echo json_encode($sqaredata);
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "getCSCatData") {

        $reportsOBJ = new ReportstController();
        $from = ($_POST['from']) ? htmlspecialchars(trim($_POST['from'])) : "";
        $to =  (isset($_POST['to'])) ? htmlspecialchars(trim($_POST['to'])) : "";
        $Rtype =   htmlspecialchars(trim($_POST['dr']));

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
        header("Content-Type: application/json");

        // echo json_encode(["name" => $name, "sold" => $countsold]);
        echo json_encode(["name" => $name, "sold" => $countsold, "conf" => $notempt, "date" => $date]);
    }






    if (isset($_POST['transac']) && $_POST['transac'] === "getCSLineData") {
        $reportsOBJ = new ReportstController();
        $from = ($_POST['from']) ? htmlspecialchars(trim($_POST['from'])) : "";
        $Rtype =   htmlspecialchars(trim($_POST['rtype']));
        $type =   htmlspecialchars(trim($_POST['type']));

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

        $temptsales = $row["tsales"] ?? 0;
        $temptorders = $row["torders"] ?? 0;
        $temptdiscounts = $row["tdiscounts"] ?? 0;

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


        $lsales = $row['lsales'] ?? 0;
        $lorders = $row['lorders'] ?? 0;
        $ldiscounts = $row['ldiscounts'] ?? 0;
        header("Content-Type: application/json");
        http_response_code(200);
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



    // if (isset($_POST['transac']) && $_POST['transac'] === "getItemAnal") {
    //     $reportsOBJ = new ReportstController();

    //     $itemtype = htmlspecialchars(trim($_POST['itemtype']));
    //     $data = htmlspecialchars(trim($_POST['data']));
    //     $order = htmlspecialchars(trim($_POST['order']));
    //     $rtype = htmlspecialchars(trim($_POST['rTypeAnl']));
    //     $from = htmlspecialchars(trim($_POST['from']));
    //     $to = htmlspecialchars(trim($_POST['to']));

    //     $submitDate = [];

    //     if ($rtype === "singleAnl") {
    //         if (empty($from)) {
    //             http_response_code(400);
    //             echo json_encode(["error" => "Select a date."]);
    //             return;
    //         }
    //         $submitDate = [$from];
    //     } else if ($rtype === "doubleAnl") {
    //         if (empty($from) || empty($to)) {
    //             http_response_code(400);
    //             echo json_encode(["error" => "Select all date ranges."]);
    //             return;
    //         }
    //         $submitDate = [$from, $to];
    //     }
    // }



    if (isset($_POST['transac']) && $_POST['transac'] === "getItems") {
        $reportsOBJ = new ReportstController();

        $itemReqType = htmlspecialchars(trim($_POST['itemReqType']));
        $spec = isset($_POST['itemID']) ? htmlspecialchars(trim($_POST['itemID'])) : 0;
        $itemtype = htmlspecialchars(trim($_POST['itemtype']));
        $data = htmlspecialchars(trim($_POST['data']));
        $order = isset($_POST['order']) ? htmlspecialchars(trim($_POST['order'])) : 0;
        $page = isset($_POST['page']) ? htmlspecialchars(trim($_POST['page'])) : 0;
        $rtype = htmlspecialchars(trim($_POST['rTypeAnl']));
        $from = htmlspecialchars(trim($_POST['from']));
        $to = htmlspecialchars(trim($_POST['to']));

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
            $data = " oi.quantity";
        } else if ($data === "sales-data") {
            $data = " oi.unitPrice ";
        }

        if ($order === "highest") {
            $order = "DESC";
        } else if ($order === "lowest") {
            $order = "ASC";
        }

        if ($itemReqType === "itemAnal") {

            $rowData = $reportsOBJ->getDataItemAnalSpec($itemtype, $submitDate, $data, $spec);

            if ($rtype === "singleAnl") {
                // $rowData .= ["rangeType" => "single"]; 
                $tw = [
                    $rowData['mon'] ?? 0 ,
                    $rowData['tue'] ?? 0 ,
                    $rowData['wed'] ?? 0 ,
                    $rowData['thu'] ?? 0 ,
                    $rowData['fri'] ?? 0 ,
                    $rowData['sat'] ?? 0 ,
                    $rowData['sun'] ?? 0 
                ];

                $lw = [
                    $rowData['lmon'] ?? 0 ,
                    $rowData['ltue'] ?? 0 ,
                    $rowData['lwed'] ?? 0 ,
                    $rowData['lthu'] ?? 0 ,
                    $rowData['lfri'] ?? 0 ,
                    $rowData['lsat'] ?? 0 ,
                    $rowData['lsun'] ?? 0 
                ]; 

                $tm = [
                    $rowData['janT'] ?? 0 ,
                    $rowData['febT'] ?? 0 ,
                    $rowData['marT'] ?? 0 ,
                    $rowData['aprT'] ?? 0 ,
                    $rowData['mayT'] ?? 0 ,
                    $rowData['juneT'] ?? 0 ,
                    $rowData['julT'] ?? 0 ,
                    $rowData['augT'] ?? 0 ,
                    $rowData['septT'] ?? 0 ,
                    $rowData['octT'] ?? 0 ,
                    $rowData['novT'] ?? 0 ,
                    $rowData['decT'] ?? 0 
                ]; 

                $lm = [
                    $rowData['janL'] ?? 0 ,
                    $rowData['febL'] ?? 0 ,
                    $rowData['marL'] ?? 0 ,
                    $rowData['aprL'] ?? 0 ,
                    $rowData['mayL'] ?? 0 ,
                    $rowData['juneL'] ?? 0 ,
                    $rowData['julL'] ?? 0 ,
                    $rowData['augL'] ?? 0 ,
                    $rowData['septL'] ?? 0 ,
                    $rowData['octL'] ?? 0 ,
                    $rowData['novL'] ?? 0 ,
                    $rowData['decL'] ?? 0 
                ]; 
                $data = [
                    "tw" => $tw,
                    "lw" => $lw,
                    "tm" => $tm,
                    "lm" => $lm
                ];
                $rowData = $data;
                $rowData += ["rangeType" => "singleAnl"];


            } else if ($rtype === "doubleAnl") {
                $rowData = ["slsum" => $rowData['slsum'] ?? 0];
                $dataT = ($data === "oi.quantity") ? "Orders" : "Sales";
                $rowData += ["dataType" => $dataT];
                $rowData += ["rangeType" => "doubleAnl"];
                $rowData += ["range" => "From:<br>".$from."<br>To:<br>".$to];
                // array_push($rowData,["dataType" => $dataT]);
                // array_push($rowData,["rangeType" => "doubleAnl"]);
                // array_push($rowData,["range" => "From:<br>".$from."<br>To:<br>".$to]);

            }

            // $(".ddrit").html(response.dataType)

            // $(".daytd").html(response.days)
            // $(".datertd").html(response.range)
            // $(".datatd").html(response.dataVal)



            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($rowData);

        } else if ($itemReqType === "itemWdata") {

            $rows = $reportsOBJ->getDataItem($itemtype, $order, $submitDate, $data,$page);
            $rowdata = $rows['data'];
            $total_pages = (int)$rows['total_pages'];
            $current_page = (int)$rows['current_page'];
            $bulk = "";
            if ($rowdata !== null) {
                $cnt = '';
                if ($data !== "oi.quantity") {
                    $cnt = '₱';
                }
                foreach ($rowdata as $row) {

                    $rate = RP((int)$row['TW'], (int)$row['LW']);


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
                                    <p>' . $cnt . $row['selData'] . '</p>
                                    <p>Selected  day</p>
                                    </div>
                                    <div class="yd smm">
                                    <p>' . $cnt . $row['beforeData'] . '</p>
                                    <p>Last day</p>
                                </div>' . $rate . '
                            </div>
                        </section>
                    </ol>
                    ';
                }
                $bulk .= '<div class="main-dir-link">';
                    
                for ($i=1; $i <= $total_pages ; $i++) {

                    $g = ($i === $current_page) ? '<button type="button" id="pageON">' : '<button type="button" class="data-link" id="'.$i.'">' ;
                    $bulk .=  $g.$i;
                    $bulk .=  '</button>';

                }
                $bulk .=  '</div>
                ';
                header("Content-Type: application/json");
                http_response_code(200);
                echo json_encode(["item" => $bulk]);
            }
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
            $row["janTS"] ?? 0,
            $row["febTS"] ?? 0,
            $row["marTS"] ?? 0,
            $row["aprTS"] ?? 0,
            $row["mayTS"] ?? 0,
            $row["juneTS"] ?? 0,
            $row["julTS"] ?? 0,
            $row["augTS"] ?? 0,
            $row["septTS"] ?? 0,
            $row["octTS"] ?? 0,
            $row["novTS"] ?? 0,
            $row["decTS"] ?? 0
        ];
        $lsales = [
            $row["janLS"] ?? 0,
            $row["febLS"] ?? 0,
            $row["marLS"] ?? 0,
            $row["aprLS"] ?? 0,
            $row["mayLS"] ?? 0,
            $row["juneLS"] ?? 0,
            $row["julLS"] ?? 0,
            $row["augLS"] ?? 0,
            $row["septLS"] ?? 0,
            $row["octLS"] ?? 0,
            $row["novLS"] ?? 0,
            $row["decLS"] ?? 0
        ];






        $torders = [
            $row["janTO"] ?? 0,
            $row["febTO"] ?? 0,
            $row["marTO"] ?? 0,
            $row["aprTO"] ?? 0,
            $row["mayTO"] ?? 0,
            $row["juneTO"] ?? 0,
            $row["julTO"] ?? 0,
            $row["augTO"] ?? 0,
            $row["septTO"] ?? 0,
            $row["octTO"] ?? 0,
            $row["novTO"] ?? 0,
            $row["decTO"] ?? 0
        ];
        $lorders = [
            $row["janLO"] ?? 0,
            $row["febLO"] ?? 0,
            $row["marLO"] ?? 0,
            $row["aprLO"] ?? 0,
            $row["mayLO"] ?? 0,
            $row["juneLO"] ?? 0,
            $row["julLO"] ?? 0,
            $row["augLO"] ?? 0,
            $row["septLO"] ?? 0,
            $row["octLO"] ?? 0,
            $row["novLO"] ?? 0,
            $row["decLO"] ?? 0
        ];




        $tdiscounts = [
            $row["janTD"] ?? 0,
            $row["febTD"] ?? 0,
            $row["marTD"] ?? 0,
            $row["aprTD"] ?? 0,
            $row["mayTD"] ?? 0,
            $row["juneTD"] ?? 0,
            $row["julTD"] ?? 0,
            $row["augTD"] ?? 0,
            $row["septTD"] ?? 0,
            $row["octTD"] ?? 0,
            $row["novTD"] ?? 0,
            $row["decTD"] ?? 0
        ];

        $ldiscounts = [
            $row["janLD"] ?? 0,
            $row["febLD"] ?? 0,
            $row["marLD"] ?? 0,
            $row["aprLD"] ?? 0,
            $row["mayLD"] ?? 0,
            $row["juneLD"] ?? 0,
            $row["julLD"] ?? 0,
            $row["augLD"] ?? 0,
            $row["septLD"] ?? 0,
            $row["octLD"] ?? 0,
            $row["novLD"] ?? 0,
            $row["decLD"] ?? 0
        ];
    } else if ($type == "weekcs") {


        $tsales = [
            $row["tmonSales"] ?? 0,
            $row["ttueSales"] ?? 0,
            $row["twedSales"] ?? 0,
            $row["tthuSales"] ?? 0,
            $row["tfriSales"] ?? 0,
            $row["tsatSales"] ?? 0,
            $row["tsunSales"] ?? 0
        ];
        $lsales = [
            $row["tlmonSales"] ?? 0,
            $row["tltueSales"] ?? 0,
            $row["tlwedSales"] ?? 0,
            $row["tlthuSales"] ?? 0,
            $row["tlfriSales"] ?? 0,
            $row["tlsatSales"] ?? 0,
            $row["tlsunSales"] ?? 0
        ];






        $torders = [
            $row["tmonOrders"] ?? 0,
            $row["ttueOrders"] ?? 0,
            $row["twedOrders"] ?? 0,
            $row["tthuOrders"] ?? 0,
            $row["tfriOrders"] ?? 0,
            $row["tsatOrders"] ?? 0,
            $row["tsunOrders"] ?? 0
        ];
        $lorders = [
            $row["tlmonOrders"] ?? 0,
            $row["tltueOrders"] ?? 0,
            $row["tlwedOrders"] ?? 0,
            $row["tlthuOrders"] ?? 0,
            $row["tlfriOrders"] ?? 0,
            $row["tlsatOrders"] ?? 0,
            $row["tlsunOrders"] ?? 0
        ];




        $tdiscounts = [
            $row["tmonDiscount"] ?? 0,
            $row["ttueDiscount"] ?? 0,
            $row["twedDiscount"] ?? 0,
            $row["tthuDiscount"] ?? 0,
            $row["tfriDiscount"] ?? 0,
            $row["tsatDiscount"] ?? 0,
            $row["tsunDiscount"] ?? 0
        ];

        $ldiscounts = [
            $row["tlmonDiscount"] ?? 0,
            $row["tltueDiscount"] ?? 0,
            $row["tlwedDiscount"] ?? 0,
            $row["tlthuDiscount"] ?? 0,
            $row["tlfriDiscount"] ?? 0,
            $row["tlsatDiscount"] ?? 0,
            $row["tlsunDiscount"] ?? 0
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
        $ready = $s * 100;
    } else {
        $ready = (($s - $e) / $e) * 100;
    }
    $ready = number_format($ready, 1, '.');
    $rtt = "";

    if ($ready < 0) {
        $rtt = '<p class="rtmhen" style="color: rgb(215 0 0); white-space:nowrap;">' . $ready . '%</p>';
    } else if ($ready > 0) {
        $rtt = '<p class="rtmhen" style="white-space:nowrap;">+' . $ready . '%</p>';
    } else {
        $rtt = '<p class="rtmhen" style="white-space:nowrap;color: unset;"><b></b>0.0</p>';
    }


    return $rtt;
}
function RP($s, $e)
{

    $ready = "0";

    if ($e === 0) {
        $ready = $s * 100;
    } else {
        $ready = (($s - $e) / $e) * 100;
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
                    <p>0.0: '.$s.'-'.$e.'</p>
                    <p> From last week.</p>
                </div>';
    }


    return $rtt;
}
