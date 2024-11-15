<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js"></script>
    <script src="../UX/script.js"></script>
    <script src="../UX/overview.js"></script>
    <script src="../UX/node_modules/chart.js/dist/chart.umd.js"></script>
    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="../resources/overview.css">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css">
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
                    <li id="overview" class="on_select">
                        <div class="bgsect"></div>
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
            <div class="dashboard">
                <div class="summary_show">
                    <li>
                        <div class="summary_cont">
                            <i class="fas fa-user"></i>
                            <div class="innerD">
                                <p>1500</p>
                                <h6>Todays Orders</h6>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="summary_cont">
                            <i class="fas fa-user"></i>
                            <div class="innerD">
                                <p>500</p>
                                <h6>This week Orders</h6>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="summary_cont">
                            <i class="fas fa-user"></i>
                            <div class="innerD">
                                <p>2000</p>
                                <h6>Total Orders</h6>
                            </div>
                        </div>
                    </li>
                </div>
                <div class="dashboard_body">
                    <div class="wr">
                        <h2>Monthly sales</h2>
                        <div>
                            <div class="brwrap">
                                <canvas id="myBarChart" style="height: 300px !important;width: 440px;"></canvas>
                            </div>

                            <div class="gp">
                                <ol>
                                    <p>₱20,000</p>
                                    <h3>Heighest</h3>
                                </ol>
                                <ol>
                                    <p>₱20,000</p>
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
                                <h3>Sales</h3>
                                <div class="data-sales">
                                    <section>
                                        <p>Today</p>
                                        <p>₱5000</p>
                                    </section>
                                    <section>
                                        <p>This month</p>
                                        <p>₱5000</p>
                                    </section>
                                    <section>
                                        <p>Total</p>
                                        <p>₱5000</p>
                                    </section>
                                </div>
                                <a href="reports.php" title="Redirect to reports" class="goto">See more <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="top-prod">
                            <div class="top-prod-inn">
                                <h3>Top products</h3>
                                <div class="data-prod">
                                    <div class="lab">
                                        <label for="">Product</label>
                                        <label for="">Orders</label>
                                    </div>
                                    <section>
                                        <div class="description-topProd">
                                            <div class="dpPr">
                                                <img src="../image/sample.png" alt="">
                                            </div>
                                            <p>Beef Patty</p>
                                        </div>
                                        <p>
                                            150
                                        </p>
                                    </section>

                                    <section>
                                        <div class="description-topProd">

                                            <div class="dpPr">
                                                <img src="../image/sample.png" alt="">
                                            </div>
                                            <p>Beef Patty</p>
                                        </div>
                                        <p>
                                            150
                                        </p>
                                    </section>

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