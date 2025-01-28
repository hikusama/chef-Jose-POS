<?php

require_once '../Controller/overviewController.php';
require_once "../function.php";
isAdminRole();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['transac']) && $_POST['transac'] === 'countOrders') {
        $ovContrGatewayRes = new OverviewController();
        $rows = $ovContrGatewayRes->countOrdersGateWay();
        $ld = ($rows['lastday'] === 0) ? 1 : $rows['lastday'];
        $lk = ($rows['lastweek'] === 0) ? 1 : $rows['lastweek'];

        $lastDayPerCent = number_format((($rows['today'] - $ld) / $ld) * 100, 1, ".");
        $lastWeekPerCent = number_format((($rows['thisweek'] - $lk) / $lk) * 100, 1, ".");
        $dayPr = "";
        if ($lastDayPerCent < 0) {
            $dayPr = '<b style="color: rgb(215 0 0);"><i class="fas fa-minus" ></i> ' . abs($lastDayPerCent) . '%</b> From last day.</p>';
        } else if ($lastDayPerCent > 0) {
            $dayPr = '<b style="color: rgb(0, 156, 0);"><i class="fas fa-plus"></i> ' . abs($lastDayPerCent) . '%</b> From last day.</p>';
        } else {
            $dayPr = '<b style=""></b> Same as the Last Day</p>';
        }

        $wkPr = "";
        if ($lastWeekPerCent < 0) {
            $wkPr = '<b style="color: rgb(215 0 0);"><i class="fas fa-minus" ></i> ' . abs($lastWeekPerCent) . '%</b> From last week.</p>';
        } else if ($lastWeekPerCent > 0) {
            $wkPr = '<b style="color: rgb(0, 156, 0);"><i class="fas fa-plus"></i> ' . abs($lastWeekPerCent) . '%</b> From last week.</p>';
        } else {
            $wkPr = '<b style=""></b> Same as the Last Day</p>';
        }

        $rows += ["fromlastday" => $dayPr];
        $rows += ["fromlastweek" => $wkPr];

        header("Content-Type: application/json");
        echo json_encode($rows);
    }



    if (isset($_POST['transac']) && $_POST['transac'] === 'piesData') {

        $ovContrGatewayRes = new OverviewController();
        $pieDatas = $ovContrGatewayRes->pieDataGateWay();

        header("Content-Type: application/json");
        echo json_encode($pieDatas);
    }



    if (isset($_POST['transac']) && $_POST['transac'] === 'graphMonthData') {
        $ovContrGatewayRes = new OverviewController();
        $rows = $ovContrGatewayRes->graphData();

        $graphData = [];
        $thisYear = [];
        $lastYear = [];

        $i = 0;
        foreach ($rows as $key => $value) {
            if ($i < 12) {
                array_push($thisYear,$value);
            }else{
                array_push($lastYear,$value);
            }
            $i++;
        }
        $filteringTY = array_filter($thisYear,
        function ($val){
            return $val != 0;
        });

        $filteringLY = array_filter($lastYear,
        function ($val){
            return $val != 0;
        });
        
        
        $maxTY = max($thisYear);
        $maxLY = max($lastYear);
        
        
        $minTY = (count($filteringTY) <= 1) ?  "----" : min($filteringTY);
        $minLY = (count($filteringLY) <= 1) ? "----" : min($filteringLY) ;





        $graphData += ["thisYear" => $thisYear];
        $graphData += ["lastYear" => $lastYear];

        $graphData += ["maxThisYear" => $maxTY];
        $graphData += ["maxLastYear" => $maxLY];

        $graphData += ["minThisYear" => $minTY];
        $graphData += ["minLastYear" => $minLY];
        $graphData += ["545" => count($filteringTY)];

        header("Content-Type: application/json");
        echo json_encode($graphData);

 
 
    }

    if (isset($_POST['transac']) && $_POST['transac'] === 'salesData') {

        $ovContrGatewayRes = new OverviewController();
        $sales = $ovContrGatewayRes->salesGateWay();

 

        header("Content-Type: application/json");
        echo json_encode($sales);
    }

    if (isset($_POST['transac']) && $_POST['transac'] === 'discountData') {

        $ovContrGatewayRes = new OverviewController();
        $sales = $ovContrGatewayRes->discountGateWay();

 

        header("Content-Type: application/json");
        echo json_encode($sales);
    }



    if (isset($_POST['transac']) && $_POST['transac'] === 'getTopProd') {

        $ovContrGatewayRes = new OverviewController();
        $topProducts_raw = $ovContrGatewayRes->topProdGateWay();

        $top_products = "";

        if ($top_products) {
            
            foreach ($topProducts_raw as $row) {
                $top_products .= '
                <section>
                <div class="description-topProd">
                <div class="dpPr">
                <img src="data:image/jpeg;base64, '.base64_encode($row['displayPic']).'" alt="">
                </div>
                <p>'.$row['name'].'</p>
                </div>
                <p>
                '.$row['total_order'].'
                </p>
                </section>';
            }
            
        }else{
            $top_products .= '
            <section>
            <div class="description-topProd">
                <p>No orders..</p>
            </div>
            <p>0</p>
            </section>';
        }
        
 

        header("Content-Type: application/json");
        echo json_encode(["prod" => $top_products,"overview"]);
    }



 
}
