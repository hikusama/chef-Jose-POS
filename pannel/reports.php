<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time();?>"></script>
    <script src="../UX/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" href="../resources/reports.css?v=<?php echo time();?>">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css?v=<?php echo time();?>">
    <title>POS</title>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../image/logo.png" alt="logo" id="logo"></li>
                <li class="title_section">Reports</li>
            </section>
            <section>
                <li class="first">r</li>
                <li class="second">f</li>
                <li class="last">s</li>
            </section>
        </div>
    </div>
    <div class="outwrap">

        <div class="side_nav">
            <div class="side_nav2d">
                <div class="inner_side_nav">
                    <li id="overview"  >
                        <div class="textdp"><i class="fas fa-chart-pie"></i>Overview</div>
                    </li>
                    <li id="cashier">
                        <div class="textdp"><i class="fas fa-home"></i>Cashier</div>
                    </li>
                    <li id="reports" class="on_select">
                        <div class="bgsect"></div>
                        <div class="textdp"><i class="fas fa-file-medical-alt"></i>Reports</div>
                    </li>
                    <li id="myproducts">
                        <div class="textdp"><i class="fas fa-hamburger"></i>Products</div>
                    </li>

                    <li id="history">
                        <div class="textdp"><i class="fas fa-history"></i>History</div>
                    </li>
                </div>
                <div class="inner_side_nav_settings">
                    <li id="settings">
                        <div class="textdp"><i class="fas fa-cog"></i>Settings</div>
                    </li>
                </div>
            </div>

        </div>
        <div class="middle_side">


        </div>

    </div>



</body>

</html>