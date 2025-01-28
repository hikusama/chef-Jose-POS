<?php
require_once "../function.php";
$isbaibing = validate($_SERVER['REQUEST_URI']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/script.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/node_modules/chart.js/dist/chart.umd.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/overview.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/overview.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css?v=<?php echo time(); ?>">
    <title>POS</title>
</head>

<body>

    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../image/logo.png" alt="logo" id="logo"></li>
                <li class="title_section">Overview</li>
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
                        <li id="overview" class="on_select">
                            <div class="bgsect"></div>
                            <div class="textdp"><i class="fas fa-chart-pie"></i>Overview</div>
                        </li>
                    <?php } ?>
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

                    <li id="history">
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
            <div class="dashboard">
                <div class="summary_show">
                    <li>
                        <div class="summary_cont">
                            <i class="fas fa-calendar-day"></i>
                            <div class="innerD">
                                <p class="data-TD">---</p>
                                <h6>Todays Orders</h6>
                            </div>
                        </div>
                        <div class="frm">
                            <p class="data-FLD"><b><i class="fas fa-arrow-up"></i> ---</b> From Last Day</p>
                        </div>
                    </li>
                    <li>
                        <div class="summary_cont">
                            <i class="fas fa-calendar-week"></i>
                            <div class="innerD">
                                <p class="data-WK">---</p>
                                <h6>This week Orders</h6>
                            </div>
                        </div>
                        <div class="frm">
                            <p class="data-FLW"><b><i class="fas fa-arrow-up"></i> ---</b> From Last Week</p>
                        </div>

                    </li>
                    <li>
                        <div class="summary_cont">
                            <i class="fas fa-clipboard-list"></i>
                            <div class="innerD">
                                <p class="data-A">---</p>
                                <h6>Total Orders</h6>
                            </div>
                        </div>
                    </li>
                </div>
                <div class="dashboard_body">
                    <div class="wr">
                        <h2 class="mnt">Monthly sales </h2>
                        <h4 class="yryr"></h4>
                        <div>
                            <div class="brwrap">
                                <canvas id="myBarChart" style="height: 300px !important;width: 440px;"></canvas>
                            </div>

                            <div class="gp">
                                <ol class="cYY highCur">
                                    <p>₱0</p>
                                    <h3>Heighest</h3>
                                </ol>
                                <ol class="cYY lowCur">
                                    <p>₱0</p>
                                    <h3>Lowest</h3>
                                </ol>
                                <ol class="lastYY highLast">
                                    <p>₱0</p>
                                    <h3>Heighest</h3>
                                </ol>
                                <ol class="lastYY lowLast">
                                    <p>₱0</p>
                                    <h3>Lowest</h3>
                                </ol>
                            </div>

                            <!-- <div class="data_from_graphical">
                            <li>
                                <div class="summary_cont">
                                    <h6>Highest</h6>
                                    <p>₱80,000</p>
                                    <div class="date">Sep,9,2004</div>
                                </div>
                            </li>
                            <li>
                                <div class="summary_cont">
                                    <h6>Lowest</h6>
                                    <p>₱30,000</p>
                                    <div class="date">Sep,9,2004</div>
                                </div>
                            </li>
                            <li>
                                <div class="summary_cont">
                                    <a href="reports" title="Redirect to reports pane">
                                        <p>Show more...</p>
                                    </a>
                                </div>
                            </li>
                        </div> -->
                        </div>
                    </div>
                    <div class="pieSum">
                        <ol>
                            <h3>Week</h3>
                            <canvas id="pieChartWk" style="height: 300px !important;width: 440px;"></canvas>
                        </ol>
                        <ol>
                            <h3>Day</h3>

                            <canvas id="pieChartD" style="height: 300px !important;width: 440px;"></canvas>
                        </ol>
                        <div class="sales-sum">
                            <div class="sales-sum-inn">
                                <h3>Discount</h3>
                                <div class="data-sales">
                                    <section>
                                        <p>Today</p>
                                        <p class="dstSales">₱0</p>
                                    </section>
                                    <section>
                                        <p>This month</p>
                                        <p class="dstmSales">₱0</p>
                                    </section>
                                    <section>
                                        <p>Total</p>
                                        <p class="dsttlSales">₱0</p>
                                    </section>
                                </div>
                                <a href="reports.php" title="Redirect to reports" class="goto">See more <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="sales-sum">
                            <div class="sales-sum-inn">
                                <h3>Sales</h3>
                                <div class="data-sales">
                                    <section>
                                        <p>Today</p>
                                        <p class="tdSales">₱0</p>
                                    </section>
                                    <section>
                                        <p>This month</p>
                                        <p class="tmSales">₱0</p>
                                    </section>
                                    <section>
                                        <p>Total</p>
                                        <p class="ttlSales">₱0</p>
                                    </section>
                                </div>
                                <a href="reports.php" title="Redirect to reports" class="goto">See more <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="top-prod">
                            <div class="top-prod-inn">
                                <h3>10 popular products this week</h3>
                                <div class="data-prod">
                                    <div class="lab">
                                        <label for="">Product</label>
                                        <label for="">Orders</label>
                                    </div>
                                    <div class="data-top-products">


                                    </div>

                                </div>
                                <a href="reports.php" title="Redirect to reports" class="goto">See more <i class="fas fa-arrow-right"></i></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>



</body>

</html>