<?php
require_once "../function.php";
$isbaibing = validate($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="../UX/node_modules/chart.js/dist/chart.umd.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/report_js.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/reportsChart.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/script.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/reports.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css?v=<?php echo time(); ?>">
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
                        </li>
                    <?php } ?>
                    <li id="cashier">
                        <div class="textdp"><i class="fas fa-home"></i>Cashier</div>
                    </li>
                    <?php if ($isbaibing["ios"] === 485) { ?>
                        <li id="reports" class="on_select">
                            <div class="bgsect"></div>
                            <div class="textdp"><i class="fas fa-file-medical-alt"></i>Reports</div>
                        </li>
                        <li id="myproducts">
                            <div class="textdp"><i class="fas fa-hamburger"></i>Products</div>
                        </li>
                    <?php } ?>

                    <li id="history">
                        <div class="textdp"><i class="fas fa-history"></i>History</div>
                    </li>
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

            <div class="todays-report">
                <div class="hdr">
                    <h3>Todays Report</h3>
                    <button id="todayRecordPDF" title="Download as PDF">
                        <i class="fas fa-book"></i>
                        Export PDF
                    </button>
                </div>
                <div class="squared-data">
                    <section class="discount_pie">
                        <h4>Discount</h4>
                        <canvas id="discount_pie_ChartD"></canvas>
                    </section>
                    <section class="pmethod_pie">
                        <h4>Payment Method</h4>
                        <canvas id="pmethod_pie_ChartD"></canvas>
                    </section>
                    <section class="todays_sum">
                        <div class="data-txt">

                            <ol>
                                <i class="fas fa-home"></i>
                                <li>
                                    <b class="orders_line"></b>
                                    <p>Today's Orders</p>
                                </li>
                            </ol>
                            <ol>
                                <i class="fas fa-home"></i>
                                <li>
                                    <b class="discount_line">₱0</b>
                                    <p>Today's Discount</p>
                                </li>
                            </ol>
                            <ol>
                                <i class="fas fa-home"></i>
                                <li>
                                    <b class="sales_line">₱0</b>
                                    <p>Today's Sales</p>
                                </li>
                            </ol>
                        </div>

                    </section>
                </div>
                <div class="major-chart">
                    <div class="catThings" style="border: none;">
                        <div class="category-bar-chart">
                            <h4>Category</h4>
                            <canvas id="todCatBarChart"></canvas>
                        </div>
                    </div>
                    <div class="sales-line-chart">
                        <h4>Sales</h4>
                        <canvas id="todSalesLineChart"></canvas>
                    </div>
                    <div class="orders-line-chart">
                        <h4>Orders</h4>
                        <canvas id="todOrdLineChart"></canvas>
                    </div>
                    <div class="discount-line-chart">
                        <h4>Discount</h4>
                        <canvas id="todDcLineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="cstmRp">
                <div class="hdr">
                    <h3>Find your reports</h3>
                    <p class="recordDate">----<b></b></p>
                    <button id="traceReport" title="Format">
                        <i class="fas fa-book"></i> Trace Report
                    </button>
                </div>
                <div class="trace_form">
                    <form id="tform">
                        <div id="eksmen">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                        <h4>Range</h4>
                        <ol class="rangeType">
                            <li>
                                <input type="radio" name="dr" class="ch" value="single" id="singleT">
                                <label for="singleT">Single</label>
                            </li>
                            <li>
                                <input type="radio" name="dr" value="double" id="doubleT">
                                <label for="doubleT">Double</label>
                            </li>
                        </ol>
                        <section class="dateRangeT">
                            <li class="start">
                                <input type="date" name="from" id="frD">
                                <p>Go to</p>
                            </li>
                            <li class="end">
                                <input type="date" name="to" id="toD">
                                <p>End</p>
                            </li>
                        </section>
                        <div class="sb">
                            <div class="er33"></div>
                            <button id="upTr" type="submit">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
                <div class="cs-squared-data">
                    <section class="discount_pie">
                        <h4>Discount</h4>
                        <canvas id="cs_discount_pie_ChartD"></canvas>
                    </section>
                    <section class="pmethod_pie">
                        <h4>Payment Method</h4>
                        <canvas id="cs_pmethod_pie_ChartD"></canvas>
                    </section>
                    <section class="todays_sum">
                        <div class="data-txt">
                            <ol>
                                <i class="fas fa-home"></i>
                                <li>
                                    <b class="cs_orders_line">----</b>
                                    <p>Orders</p>
                                </li>
                            </ol>
                            <ol>
                                <i class="fas fa-home"></i>
                                <li>
                                    <b class="cs_discount_line">----</b>
                                    <p>Discount</p>
                                </li>
                            </ol>
                            <ol>
                                <i class="fas fa-home"></i>
                                <li>
                                    <b class="cs_sales_line">----</b>
                                    <p>Sales</p>
                                </li>
                            </ol>
                        </div>
                    </section>
                </div>
                <div class="cs_major-chart">
                    <div class="catThings"  style="border: none;">
                        <div class="cs_category-bar-chart">
                            <h4>Category</h4>
                            <canvas id="csCatBarChart"></canvas>
                        </div>
                    </div>
                    <div class="sone">
                        <h3>Single Range</h3>
                    </div>
                    <div class="typer">

                        <div class="charthings">
                            <section class="findBy">
                                <li class="onSingleD" id="weekcs">Week</li>
                                <li id="monthcs">Month</li>
                            </section>
                            <div class="cs_sales-line-chart">
                                <h4>Sales</h4>
                                <canvas id="csSalesLineChart"></canvas>
                            </div>
                            <div class="cs_orders-line-chart">
                                <h4>Orders</h4>
                                <canvas id="csOrdLineChart"></canvas>

                            </div>
                            <div class="cs_discount-line-chart">
                                <h4>Discount</h4>
                                <canvas id="csDcLineChart"></canvas>
                            </div>
                        </div>
                        <div class="txtbaseddata">
                            <div class="table-mhen">

                                <table border="1">
                                    <thead>
                                        <th>
                                            <tr>
                                                <td>Day/s</td>
                                                <td>Date Ranged</td>
                                                <td>Orders</td>
                                                <td>Sales</td>
                                                <td>Discount</td>
                                            </tr>
                                        </th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="Rd">--</td>
                                            <td class="Rdr">-----</td>
                                            <td class="Ror">---</td>
                                            <td class="Rsl">---</td>
                                            <td class="Rdc">---</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <div class="ogCards">
                <section class="card1">
                    <h3>Sales</h3>
                    <ol>
                        <li>Today</li>
                        <p class="sttoday">₱1212</p>
                        <p class="sttrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                    <ol>
                        <li>This week</li>
                        <p class="swweek">₱1212</p>
                        <p class="swrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                    <ol>
                        <li>This month</li>
                        <p class="smmonth">₱1212</p>
                        <p class="smrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                </section>
                <section class="card2">
                    <h3>Discount</h3>
                    <ol>
                        <li>Today</li>
                        <p class="dttoday">₱1212</p>
                        <p class="dttrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                    <ol>
                        <li>This week</li>
                        <p class="dwweek">₱1212</p>
                        <p class="dwrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                    <ol>
                        <li>This month</li>
                        <p class="dmmonth">₱1212</p>
                        <p class="dmrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                </section>
                <section class="card3">
                    <h3>Orders</h3>
                    <ol>
                        <li>Today</li>
                        <p class="ottoday">₱1212</p>
                        <p class="ottrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                    <ol>
                        <li>This week</li>
                        <p class="owweek">₱1212</p>
                        <p class="owrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                    <ol>
                        <li>This month</li>
                        <p class="ommonth">₱1212</p>
                        <p class="omrate"><i class="fas fa-plus"></i>10%</p>
                    </ol>
                </section>
            </div>

            <div class="analytics">
                <div class="hdr">
                    <h3>Analytics</h3>
                    <div class="dateAnalytics"></div>
                    <div class="menu">
                        <i class="fas fa-th"></i>
                    </div>
                </div>
                <div class="menuBodyAsNgiao">


                    <div class="menuBody">
                        <div id="bkAnl">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                        <ol class="data-type">
                            <p>Type of Data:</p>
                            <li>
                                <button id="sales-data" class="onDataType">Sales</button>
                                <button id="orders-data">Orders</button>
                            </li>
                        </ol>
                        <ol class="rk">
                            <p>Items:</p>
                            <li>
                                <button id="proddR" class="onRank">Products</button>
                                <button id="combbR">Combo</button>
                            </li>
                        </ol>
                        <ol class="orb">
                            <p>Ordered by:</p>
                            <li>
                                <button id="highest" class="onOrdered">Highest</button>
                                <button id="lowest">Lowest</button>
                            </li>
                        </ol>
                        <ol class="rt">
                            <p>Range type:</p>
                            <li>
                                <div class="slideEme">
                                    <input type="radio" name="rTypeAnl" class="selAnl" value="singleAnl" id="singleAnl">
                                    <label for="singleAnl" class="selP">Single</label>
                                </div>
                                <div class="slideEme">
                                    <input type="radio" name="rTypeAnl" id="doubleAnl" value="doubleAnl">
                                    <label for="doubleAnl">Double</label>
                                </div>

                            </li>
                        </ol>
                        <section class="dateThings">
                            <li class="startAnl">
                                <input type="date" name="fromAnl" id="frAnl">
                                <p>Go to</p>
                            </li>
                            <li class="endAnl">
                                <input type="date" name="toR" id="toAnl">
                                <p>End</p>
                            </li>
                        </section>
                        <div class="uptAnl">
                            <div class="anlerr"></div>
                            <button id="updateAnl">Update</button>
                        </div>
                    </div>
                </div>
                <div id="itemAnalyticalData">
                    <!-- <ol>
                        <section class="ssum">
                            <div class="headAnl">

                                <li>
                                    <div class="picMhen"><img src="../image/sample.png" alt=""></div>
                                </li>
                                <li>
                                    <div class="contIn">
                                        <h4>Beef patty sdasdasd sda</h4>

                                    </div>
                                </li>
                            </div>
                            <div class="bdcontt">

                                <div class="tod smm">
                                    <p>500020</p>
                                    <p>Today</p>
                                </div>
                                <div class="yd smm">
                                    <p>505550</p>
                                    <p>Yesterday</p>
                                </div>
                                <p class="uiper"><i class="fas fa-plus"></i> 12.5%</p>
                            </div>
                        </section>
                    </ol> -->
                </div>
                <div class="data_presentation_wrap">

                    <div class="dataPrTypes">

                        <section class="graphNgiao">
                            <p class="singleRGRP">Single range</p>
                            <div class="btt">
                                <button id="week" class="onSt">Week</button>
                                <button id="month">Month</button>
                                <div id="rmX"><i class="fas fa-plus"></i></div>
                            </div>
                            <div class="dataChartEach">
                            </div>
                        </section>

                        <section class="table-data" >
                            <p class="singleRGRP">Double range</p>
                            <table border="1">
                                <thead>
                                    <tr>
                                        <td class="ddit">Day/s</td>
                                        <td class="ddrit">Date Ranged</td>
                                        <td class="ddtit">Orders</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <th>
                                        <tr>
                                            <td class="daytd"></td>
                                            <td class="datertd"></td>
                                            <td class="datatd"></td>
                                        </tr>
                                    </th>
                                </tbody>
                            </table>
                        </section>

                    </div>
                </div>

            </div>
            <div class="loader" style="display: none;">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
                <div class="bar4"></div>
                <div class="bar5"></div>
                <div class="bar6"></div>
                <div class="bar7"></div>
                <div class="bar8"></div>
                <div class="bar9"></div>
                <div class="bar10"></div>
                <div class="bar11"></div>
                <div class="bar12"></div>
            </div>

        </div>

    </div>



</body>

</html>