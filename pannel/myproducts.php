<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="../resources/products.css">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css">
    <script src="../UX/jquery-3.5.1.min.js"></script>
    <script src="../UX/products.js"></script>
    <script src="../UX/script.js"></script>

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
                    <li id="overview">
                        <div class="textdp"><i class="fas fa-chart-pie"></i>Overview</div>
                    </li>
                    <li id="cashier">
                        <div class="textdp"><i class="fas fa-home"></i>Cashier</div>
                    </li>
                    <li id="reports">
                        <div class="textdp"><i class="fas fa-file-medical-alt"></i>Reports</div>
                    </li>
                    <li id="myproducts" class="on_select">
                        <div class="bgsect"></div>
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
            <div id="overlay_prod"></div>
            <div class="myproducts">

                <div class="myprod_container">
                    <div class="find_prod">
                        <div class="find">
                            <img src="../image/logo.png" id="logo_prod" alt="">
                        </div>
                        <div>
                            <i class="fas fa-search"></i>
                            <input type="search" placeholder="Seach for products..." name="" id="findExec">
                        </div>
                    </div>
                    <div class="myprod_inner">
                        <ol>
                            <h5>DP</h5>
                            <h5>Product</h5>
                            <h5>Category</h5>
                            <h5>Availability</h5>
                            <h5>Price</h5>
                        </ol>
                         <div id="content_products">
                            <li class="last" id="addProduct" title="Add Product"><i class="fas fa-plus"></i>Add Product</li>
                            
                            <!-- <li>
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
                <div class="Pnav_category">
                    <div id="body_Pnav_cat">
                        <li id="sample1" class="on_nav_select">All</li>
                        <li id="sample1">Snacks</li>
                        <li id="sample2">Latte & milktea</li>
                        <li id="sample3">Latte & milktea</li>
                        <li id="sample4">Latte & milktea</li>
                        <li id="sample5">Snacks</li>
                        <li id="sample6">Snacks</li>
                        <li id="sample7">Snacks</li>
                    </div>
                </div>
                <div id="addProductForm">
<<<<<<< HEAD
                    <form id="submit_form" method="post" action="../Views/productView.php" enctype="multipart/form-data">
=======
                    <form id="submit_form" method="post" action="../views/productView.php" enctype="multipart/form-data">
>>>>>>> group_work
                        <div class="label_style">
                            <p></p>
                            <h3>Add Products</h3>
                            <p></p>

                        </div>
                        <section>
                            <ol>
                                <li>
                                    <div>
                                        <img src="../image/sample.png" id="imgdisplay" alt="Display pic">
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
                                        <input type="number" placeholder="Stock" id="prod_stock" name="quantityInStock">
                                    </div>
                                    <p>Stock</p>
                                </li>
                                <li>
                                    <div>
                                        <i class="fas fa-book"></i>
                                        <select name="category" id="prod_category">
                                            <option value="">Category</option>
                                            <option value="snacks" name="category">Snacks</option>
                                        </select>
                                    </div>
                                    <p>Category</p>
                                </li>
                            </ol>
                            <div class="add_cont_button">
                                <button type="submit" id="submit_prod" name="submited"><i class="fas fa-plus"></i>Add product</button>
                            </div>
                        </section>
                        <button type="button" id="canc" title="Cancel">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="response">
                            <li>Please fill all fields</li>
                            <li>Please fill all fields</li>
                            <li>Please fill all fields</li>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>


</body>

</html>