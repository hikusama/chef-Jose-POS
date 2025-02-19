<?php
require_once "../function.php";
validateByLoc("in");
$isbaibing = validate($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/script.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/history.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/history.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css?v=<?php echo time(); ?>">
    <style>
        .middle_side {
            grid-template-columns: auto 20rem;
        }
    </style>
    <title>POS</title>
    <style>
        .middle_side{
            grid-template-columns: auto 20rem;
        }
    </style>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../image/logo.png" alt="logo" id="logo"></li>
                <li class="title_section">History</li>
            </section>
            <section>
                <li class="first" title="Refresh" id="refresh"><i class="fas fa-sync"></i></li>
                <li class="second" id="screencontroll" title="View full screen."><i class="fas fa-expand"></i></li>
                <li class="last"><i class="fas fa-user"></i></li>
            </section>
        </div>
    </div>
    <div class="outwrap">

        <div class="side_nav">
            <div class="side_nav2d">

                <div class="inner_side_nav">

                    <?php if ($isbaibing["ios"] === 485) { ?>
                        <li id="overview">
                            <div class="textdp"><i class="fas fa-chart-pie"></i>Overview</div>
                        <?php } ?>
                        </li>
                        <li id="cashier">
                            <div class="textdp"><i class="fas fa-home"></i>Cashier</div>
                        </li>
                        <?php if ($isbaibing["ios"] === 485) { ?>
                            <li id="reports">
                                <div class="textdp"><i class="fas fa-file-medical-alt"></i>Reports</div>
                            </li>
                            <li id="myproducts">
                                <div class="textdp"><i class="fas fa-hamburger"></i>Products</div>
                            </li>
                        <?php } ?>

                        <li id="history" class="on_select">
                            <div class="bgsect"></div>
                            <div class="textdp"><i class="fas fa-history"></i>History</div>
                        </li>
                        <?php if ($isbaibing["ios"] === 485) { ?>
                        <li id="cashiers">
                            <div class="textdp"><i class="fas fa-users"></i>Cashiers</div>
                        </li>

                    <?php } ?>
                </div>
                <div class="inner_side_nav_settings">
                    <li id="settings">
                        <div class="textdp"><i class="fas fa-cog"></i>Settings</div>
                    </li>
                    <li id="logoutMhen">
                        <div class="textdp"><i class="fas fa-external-link-alt"></i>Logout</div>
                    </li>
                </div>
            </div>

        </div>
        <div class="middle_side">
            <div class="history_cont">
                <div class="time_section">
                    <div class="findHistory">
                        <li>
                            <i class="fas fa-search"></i>
                            <input type="search" name="findOrder" id="findOrder" placeholder="Search for ref no.">
                        </li>
                        <div class="group_type">
                            <button type="button" id="" class="historyOn">All</button>
                            <button type="button" id="todayH" class="1">Today</button>
                            <button type="button" id="yesterdayH" class="1">Yesterday</button>
                            <button type="button" id="tweekH" class="1">This week</button>
                            <button type="button" id="weekH" class="1">This month</button>
                        </div>
                    </div>
                    <div class="data_history_cont">
                        <div class="data">
                        </div>
                    </div>

                </div>
            </div>
            <div class="history_pane">
                <div class="history_info">

                    <img src="../image/logo.png" id="dpLogo" class="lgu" alt="logo">
                </div>
            </div>

        </div>

    </div>



</body>

</html>