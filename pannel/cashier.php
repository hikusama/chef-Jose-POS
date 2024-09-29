<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js"></script>
    <script src="../UX/cashier.js"></script>
    <script src="../UX/script.js"></script>
    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="../resources/cashier.css">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css">

    <title>POS</title>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../image/logo.png" alt="logo" id="logo"></li>
                <li class="search"><input type="search" name="search" placeholder="Seach products..." id="search"
                       ><label for="search"><i class="fas fa-search"></i></label>
                </li>
            </section>
            <section>
                <li class="first" id="refresh"><img src="../image/refresh.png" alt="refresh"></li>
                <li class="second" id="screencontroll"><img src="../image/fullscreen.png" alt="refresh"></li>
                <li class="last">s</li>
            </section>
        </div>
    </div>
    <div class="outwrap">

        <div class="side_nav">
            <div class="side_nav2d">
                <div class="inner_side_nav">
                    <li id="overview" >
                        <div class="textdp"><i class="fas fa-chart-pie"></i>Overview</div>
                    </li>
                    <li id="cashier" class="on_select">
                        <div class="bgsect"></div>
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

            <div class="products">
                <div class="category_cont">


                    <div class="category_nav">
                        <div class="category_nav_inner">

                            <li class="prod_nav">All</li>
 
                        </div>
                        <button id="allcategory_open"><img src="../image/seemore.png" alt=""></button>
                    </div>
                </div>
                <div class="products_content">
                    <!-- <ol>
                        <li><img src="../image/sample.png" alt="item"></li>
                        <li>
                            <h5>Beef patty asfasdewsd sad</h5>
                            <h4><b>₱4544</b></h4>
                        </li>
                    </ol> -->

                </div>
            </div>
            <div class="counting">
                <!-- <div class="counting_header"></div> -->
                 <div class="counter-header">
                    <li><div></div>Cart</li>
                    <li><i id="refreshCart" class="fas fa-sync-alt"></i></li>
                 </div>
                <div id="counter_body">

    
 
                    
                </div>
                <div class="totaling">
                    <section>
                        <!-- <li>Payment Method</li>
                        <li>
                            <select name="paymentmethod" id="pm">
                                <option value="Cash">Cash</option>
                                <option value="Digital_Payment">Digital Payment</option>
                            </select> -->
                        </li>
                    </section>
                    <section>
                        <li>Subtotal</li>
                        <li>₱1,900</li>
                    </section>
                    <section>
                        <li>Discount (%)</li>
                        <li>10</li>
                    </section>
                    <section>
                        <li>Total Amount</li>
                        <li>₱1,700</li>
                    </section>
                    <section>
                        <button id="discount">Discount</button>
                        <button id="proceed">Proceed</button>
                    </section>
                </div>
            </div>
        </div>

    </div>



</body>

</html>