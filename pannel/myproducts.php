<?php
require_once "../function.php";
$isbaibing = validate($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/products.css?v=<?php echo time(); ?>">
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/products.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/script.js?v=<?php echo time(); ?>"></script>

    <title>POS</title>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../image/logo.png" alt="logo" id="logo"></li>
                <li class="title_section">My Products</li>

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
                    <?php if ($isbaibing["ios"] === 485) { ?>
                        <li id="overview">
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
                        <li id="myproducts" class="on_select">
                            <div class="bgsect"></div>
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
                </div>
            </div>

        </div>
        <div class="middle_side">
            <div id="overlay_prod"></div>
            <div class="myproducts">
                <!-- <div class="notification">
                    <i class="fas fa-check"></i>
                    <h5>Theme changed successfully...</h5>
                </div> -->
                <div class="myprod_container">
                    <div class="find_prod">
                        <div class="find">
                            <img src="../image/logo.png" id="logo_prod" alt="">
                        </div>
                        <div>
                            <i class="fas fa-search"></i>
                            <input type="search" placeholder="Search for products or category..." name="" id="findExec">
                        </div>
                    </div>
                    <div class="myprod_inner">
                        <li class="last">
                            <button type="button" id="addProduct" title="Add Product">
                                <i class="fas fa-plus"></i>Add Product
                            </button>
                            <button type="button" id="addCombo" title="Add Combo">
                                <i class="fas fa-plus"></i>Add Combo
                            </button>
                            <button type="button" id="addCategory" title="Add Category">
                                <i class="fas fa-plus"></i>Add Category
                            </button>
                        </li>
                        <div id="content_products-cont">
                            <section>
                                <ol>
                                    <h5>DP</h5>
                                    <h5>Product</h5>
                                    <h5>Category</h5>
                                    <h5>Availability</h5>
                                    <h5>Price</h5>
                                    <h5></h5>
                                    <div class="showType">
                                        <button type="button" id="prdType" class="state">Products</button>
                                        <button type="button" id="catType">Categories</button>
                                        <button type="button" id="cmboType">Combo's</button>
                                    </div>
                                </ol>
                            </section>
                            <div id="content_products">
                                <div class="loading_sc">

                                    <div>
                                        <p class="dp"></p>
                                        <div class="desc"></div>


                                    </div>
                                    <div>
                                        <p class="dp"></p>
                                        <div class="desc"></div>


                                    </div>
                                    <div>
                                        <p class="dp"></p>
                                        <div class="desc"></div>
                                    </div>

                                </div>
                            </div>


                            <!-- <li>
                                <div class="dp">
                                    <img src="../image/sample.png" alt="">
                                </div>
                                <p>Beef Patty</p>
                                <p>Snacks</p>
                                <p>available</p>
                                <p>₱5000</p>
                                <p>
                                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>

                                <div class="action_select">
                                    <p><i class="fas fa-edit"></i> Edit</p>
                                    <p><i class="fas fa-trash"></i> Delete</p>
                                    <p><i class="fas fa-eye"></i> View</p>
                                </div>
                                </p>
                            </li>
                            <li>
                                <div class="dp">
                                    <img src="../image/sample.png" alt="">
                                </div>
                                <p>Beef Patty</p>
                                <p>Snacks</p>
                                <p>available</p>
                                <p>₱50</p>
                                <p>
                                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>

                                <div class="action_select">
                                    <p><i class="fas fa-edit"></i> Edit</p>
                                    <p><i class="fas fa-trash"></i> Delete</p>
                                    <p><i class="fas fa-eye"></i> View</p>
                                </div>
                                </p>
                            </li>
                            <li>
                                <div class="dp">
                                    <img src="../image/sample.png" alt="">
                                </div>
                                <p>Beef Patty</p>
                                <p>Snacks</p>
                                <p>available</p>
                                <p>₱5000</p>
                                <p>
                                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>

                                <div class="action_select">
                                    <p><i class="fas fa-edit"></i> Edit</p>
                                    <p><i class="fas fa-trash"></i> Delete</p>
                                    <p><i class="fas fa-eye"></i> View</p>
                                </div>
                                </p>
                            </li>
                            <li>
                                <div class="dp">
                                    <img src="../image/sample.png" alt="">
                                </div>
                                <p>Beef Patty jasjdjad asdafjjasdo</p>
                                <p>Snacks</p>
                                <p>available</p>
                                <p>₱50</p>
                                <p>
                                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>

                                <div class="action_select">
                                    <p><i class="fas fa-edit"></i> Edit</p>
                                    <p><i class="fas fa-trash"></i> Delete</p>
                                    <p><i class="fas fa-eye"></i> View</p>
                                </div>
                                </p>
                            </li>
                            <li>
                                <div class="dp">
                                    <img src="../image/sample.png" alt="">
                                </div>
                                <p>Beef Patty</p>
                                <p>Snacks</p>
                                <p>available</p>
                                <p>₱5000</p>
                                <p>
                                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>

                                <div class="action_select">
                                    <p><i class="fas fa-edit"></i> Edit</p>
                                    <p><i class="fas fa-trash"></i> Delete</p>
                                    <p><i class="fas fa-eye"></i> View</p>
                                </div>
                                </p>
                            </li>
                            <li>
                                <div class="dp">
                                    <img src="../image/sample.png" alt="">
                                </div>
                                <p>Beef Patty</p>
                                <p>Snacks</p>
                                <p>available</p>
                                <p>₱50</p>
                                <p>
                                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>

                                <div class="action_select">
                                    <p><i class="fas fa-edit"></i> Edit</p>
                                    <p><i class="fas fa-trash"></i> Delete</p>
                                    <p><i class="fas fa-eye"></i> View</p>
                                </div>
                                </p>
                            </li>
                            <li>
                                <div class="dp">
                                    <img src="../image/sample.png" alt="">
                                </div>
                                <p>Beef Patty</p>
                                <p>Snacks</p>
                                <p>available</p>
                                <p>₱5000</p>
                                <p>
                                    <i class="fas fa-ellipsis-v more_showPane" title="See More"></i>

                                <div class="action_select">
                                    <p><i class="fas fa-edit"></i> Edit</p>
                                    <p><i class="fas fa-trash"></i> Delete</p>
                                    <p><i class="fas fa-eye"></i> View</p>
                                </div>
                                </p>
                            </li>-->
                        </div>
                    </div>
                </div>
                <div class="comboAdd-form-cont">
                    <div class="comboAdd-form-inner">
                        <div class="exit">
                            <i class="fas fa-plus"></i>
                        </div>
                        <form id="addComboForm" enctype="multipart/form-data">
                            <section>
                                <div class="img-wrap-out">

                                    <div class="image-wrap">
                                        <img src="../image/dpTemplate.png" id="comboDP" alt="">
                                        <input type="file" style="visibility: hidden;" id="selectComboPic" name="comboPic">
                                    </div>
                                    <label for="selectComboPic">
                                        <i class="fas fa-plus"></i>
                                    </label>
                                </div>
                            </section>
                            <section>
                                <ol>
                                    <li>
                                        <i class="fas fa-book"></i>
                                        <input type="text" name="comboName" placeholder="Combo name..." id="comboName">
                                        <p>Combo name</p>
                                    </li>
                                    <li>
                                        <i class="fas fa-book"></i>
                                        <input type="text" name="comboCode" placeholder="Combo code..." id="comboCode">
                                        <p>Combo code</p>
                                    </li>
                                </ol>
                                <ol>
                                    <li>
                                        <i class="fas fa-book"></i>
                                        <input type="number" name="comboPrice" placeholder="Price..." id="comboPrice">
                                        <p>Price</p>
                                    </li>
                                    <div class="data_summary_combo">
                                        <li>
                                            <h3>₱0</h3>
                                            <p>Products in Total</p>
                                        </li>
                                        <li>
                                            <h3>0</h3>
                                            <p>Item/s</p>
                                        </li>
                                    </div>
                                </ol>
                                <ol>
                                    <li>
                                        <i class="fas fa-book"></i>
                                        <select name="availability" id="avail">
                                            <option value="">Availability</option>
                                            <option value="available">Available</option>
                                            <option value="not-available">Not-available</option>
                                        </select>
                                    </li>
                                </ol>
                                <button id="tg" type="submit"></button>
                            </section>
                        </form>
                        <div class="outer-response">
                            <section>
                                <div class="action-products-outer">

                                    <div class="action-products">
                                        <div id="viewSel">

                                            <h3>Products selected</h3>
                                            <div class="data-products-selected">
                                                <div class="loadingScComboForm-outer">

                                                    <div class="loadingScComboForm">
                                                        <ol>
                                                            <li>
                                                                <div>

                                                                </div>
                                                            </li>
                                                            <li>

                                                            </li>
                                                        </ol>
                                                        <ol>
                                                            <li>
                                                                <div>

                                                                </div>
                                                            </li>
                                                            <li>

                                                            </li>
                                                        </ol>
                                                        <ol>
                                                            <li>
                                                                <div>

                                                                </div>
                                                            </li>
                                                            <li>

                                                            </li>
                                                        </ol>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div id="findProdController">

                                            <h3>Find to add</h3>
                                            <div class="find-prod">
                                                <li>
                                                    <i class="fas fa-search"></i>
                                                    <input type="search" id="findProdInput" autocomplete="off"
                                                        placeholder="Search for products or category..">
                                                </li>
                                            </div>
                                            <div class="data-products">
                                                <div class="loadingScComboForm-outer">

                                                    <div class="loadingScComboForm">
                                                        <ol>
                                                            <li>
                                                                <div>

                                                                </div>
                                                            </li>
                                                            <li>

                                                            </li>
                                                        </ol>
                                                        <ol>
                                                            <li>
                                                                <div>

                                                                </div>
                                                            </li>
                                                            <li>

                                                            </li>
                                                        </ol>
                                                        <ol>
                                                            <li>
                                                                <div>

                                                                </div>
                                                            </li>
                                                            <li>

                                                            </li>
                                                        </ol>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="combo-main-action">
                                    <button id="addRm-combo" type="button"> <i class="fas fa-search"></i>Find producs</button>
                                    <button id="submit-combo_form" type="submit"><i class="fas fa-plus"></i>Submit</button>
                                </div>
                                <div class="combo-response">
                                    <div class="waiting">
                                        <p></p>
                                        <p></p>
                                        <p></p>
                                        <p></p>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div id="addProductForm">
                    <form id="submit_form" enctype="multipart/form-data">
                        <div class="label_style">
                            <p></p>
                            <h3>Add Products</h3>
                            <p></p>

                        </div>
                        <section>
                            <ol>
                                <li>
                                    <div>
                                        <img src="../image/dpTemplate.png" id="imgdisplay" alt="Display pic">
                                    </div>
                                    <label for="addpic">
                                        <i class="fas fa-plus"></i>
                                    </label>
                                    <input type="file" id="addpic" style="visibility: hidden; position: absolute; height: 0; width: 0; " name="displayPic">
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <div>
                                        <i class="fas fa-book"></i>
                                        <input placeholder="Price" type="number" name="price" id="prod_price">
                                    </div>
                                    <p>Price</p>
                                </li>
                            </ol>
                        </section>
                        <section>
                            <ol>
                                <li>
                                    <div>
                                        <i class="fas fa-book"></i>
                                        <input type="text" placeholder="Product" id="prod_name" name="name">
                                    </div>
                                    <p>Product</p>
                                </li>
                            </ol>
                            <ol>
                                <li>
                                    <div>
                                        <i class="fas fa-book"></i>
                                        <select name="availability" id="availability">
                                            <option value="">Availability</option>
                                            <option value="available">Available</option>
                                            <option value="not-available">Not-available</option>
                                        </select>
                                    </div>
                                    <p>Availability</p>
                                </li>
                                <li>
                                    <div>
                                        <i class="fas fa-book"></i>
                                        <select name="category" id="prod_category">

                                        </select>
                                    </div>
                                    <p>Category</p>
                                </li>
                            </ol>
                            <div class="add_cont_button">
                                <button type="submit" id="submit_prod"><i class="fas fa-plus"></i>Add product</button>
                                <p>Need to remove BG? <a style="color: #00c4ff;" href="https://www.remove.bg/upload" target="blank">Click here..</a></p>
                            </div>
                        </section>
                        <button type="button" id="canc" title="Cancel">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="response">
                        </div>
                    </form>
                </div>
                <div class="categoryForm-outer">

                    <div id="categoryForm">
                        <div class="uiInfo">
                            <p></p>
                            <h3>Add Category</h3>
                            <p></p>
                        </div>
                        <button id="cancelAddCat"><i class="fas fa-plus" style="transform: rotate(45deg);"></i></button>
                        <form id="category">
                            <li>
                                <i class="fas fa-book"></i>
                                <input type="text" placeholder="Category" name="category">
                                <p>Category</p>
                            </li>
                            <button id="submitCategory" type="submit"><i class="fas fa-plus"></i>Add Category</button>
                        </form>
                        <div class="category-response">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>


</body>

</html>