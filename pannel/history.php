<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js"></script>
    <script src="../UX/script.js"></script>
    <script src="../UX/history.js"></script>
    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="../resources/history.css">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css">
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
                    <li id="overview">
                        <div class="textdp"><i class="fas fa-chart-pie"></i>Overview</div>
                    </li>
                    <li id="cashier">
                        <div class="textdp"><i class="fas fa-home"></i>Cashier</div>
                    </li>
                    <li id="reports">
                        <div class="textdp"><i class="fas fa-file-medical-alt"></i>Reports</div>
                    </li>
                    <li id="myproducts">
                        <div class="textdp"><i class="fas fa-hamburger"></i>Products</div>
                    </li>

                    <li id="history" class="on_select">
                        <div class="bgsect"></div>
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