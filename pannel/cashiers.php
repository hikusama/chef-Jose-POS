<?php
require_once "../function.php";
$isbaibing = validate($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time(); ?>">
    </script>
    <script src="../UX/script.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/cashiers.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/cashiers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css?v=<?php echo time(); ?>">
    <title>POS</title>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../image/logo.png" alt="logo" id="logo"></li>
                <li class="title_section">Cashiers</li>
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
                    <li id="cashiers" class="on_select">
                        <div class="bgsect"></div>

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
            <div class="cashiers_cont">
                <div class="addCashier">
                    <button id="addCs"><i class="fas fa-plus"></i> Add Cashier/s</button>
                </div>
                <div class="headSearch">
                    <div id="findUser">
                        <h3><i class="fas fa-search"></i> Find cashier</h3>
                        <div id="searchUser">
                            <input type="text" placeholder="Find cashier....">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
                <div id="users">
                    <ol>
                        <li class="picselp">
                            <div class="brd">
                                <div class="wrap_pic">
                                    <img src="../image/theme.png" alt="">
                                </div>
                            </div>
                        </li>

                        <li class="infoDD">
                            <data>
                                <p>First Name:</p>
                                <p>Hikusama</p>
                            </data>
                            <data>
                                <p>Middle Name:</p>
                                <p>Yukihiro</p>
                            </data>
                            <data>
                                <p>Last Name:</p>
                                <p>Matsumoto</p>
                            </data>
                            <data>
                                <p>Age:</p>
                                <p>67</p>
                            </data>
                            <data>
                                <p>Birthdate:</p>
                                <p>04-09-1999</p>
                            </data>
                            <data>
                                <p>Address:</p>
                                <p>Florida, San francisco</p>
                            </data>
                            <data>
                                <p>Contactno:</p>
                                <p>09856093241</p>
                            </data>
                            <data>
                                <p>Email:</p>
                                <p>ngiao14@gmail.com</p>
                            </data>
                            <data>
                                <p>Action:</p>
                                <p class="action" dt="12">
                                    <button id="editUs"><i class="fas fa-edit"></i> Edit</button>
                                    <button id="delUs"><i class="fas fa-trash"></i> Delete</button>
                                </p>
                            </data>

                            <div class="shw">
                                <button class="smcntrl"><i class="fas fa-arrow-down"></i> Show more.</button>
                            </div>
                        </li>
                    </ol>
                    <ol>
                        <li class="picselp">
                            <div class="brd">
                                <div class="wrap_pic">
                                    <img src="../image/theme.png" alt="">
                                </div>
                            </div>
                        </li>

                        <li class="infoDD">
                            <data>
                                <p>First Name:</p>
                                <p>Hikusama</p>
                            </data>
                            <data>
                                <p>Middle Name:</p>
                                <p>Yukihiro</p>
                            </data>
                            <data>
                                <p>Last Name:</p>
                                <p>Matsumoto</p>
                            </data>
                            <data>
                                <p>Age:</p>
                                <p>67</p>
                            </data>
                            <data>
                                <p>Birthdate:</p>
                                <p>04-09-1999</p>
                            </data>
                            <data>
                                <p>Address:</p>
                                <p>Florida, San francisco</p>
                            </data>
                            <data>
                                <p>Contactno:</p>
                                <p>09856093241</p>
                            </data>
                            <data>
                                <p>Email:</p>
                                <p>ngiao14@gmail.com</p>
                            </data>
                            <data>
                                <p>Action:</p>
                                <p class="action" dt="12">
                                    <button id="editUs"><i class="fas fa-edit"></i> Edit</button>
                                    <button id="delUs"><i class="fas fa-trash"></i> Delete</button>
                                </p>
                            </data>

                            <div class="shw">
                                <button class="smcntrl"><i class="fas fa-arrow-down"></i> Show more.</button>
                            </div>
                        </li>
                    </ol>

                </div>
                <div id="overlay"></div>
                <div class="addCSR">
                    <form id="addCashierFrm">
                        <div id="cancelAdd"><i style="transform: rotate(45deg);" class="fas fa-plus"></i></div>
                        <li class="psm">
                            <div class="picSend">
                                <div class="imgss">
                                    <img src="../image/dpTemplate.png" id="prPic" alt="">
                                </div>
                                <i class="fas fa-plus"></i>
                                <input type="file" id="picmhen" name="dp" style="visibility: hidden;">
                            </div>
                        </li>
                        <section class="fsec">
                            <h4>Form 1/3</h4>

                            <li>
                                <label for="fn">First name</label>
                                <input id="fn" type="text" placeholder="First name..." name="fn">
                            </li>
                            <li>
                                <label for="mn">Middle name</label>
                                <input id="mn" type="text" placeholder="Middle name..." name="mn">
                            </li>
                            <li>
                                <label for="ln">Last name</label>
                                <input id="ln" type="text" placeholder="Last name.." name="ln">
                            </li>
                            <li>
                                <label for="age">Age</label>
                                <input id="age" type="number" placeholder="Age.." name="age" min="0">
                            </li>
                            <div class="errtype"></div>

                            <div class="proceedAction">
                                <button id="nxt1" type="button">Next</button>
                            </div>
                        </section>
                        <section class="msec">
                            <h4>Form 2/3</h4>

                            <li>
                                <label for="cn">Contact no.</label>
                                <input id="cn" type="number" placeholder="Contact no.." min="0" name="cn">
                            </li>
                            <li>
                                <label for="bd">Birth date</label>
                                <input id="bd" type="date" placeholder="Birth date.." name="bd">
                            </li>
                            <li>
                                <label for="em">Email</label>
                                <input id="em" type="text" placeholder="Email.." name="em">
                            </li>
                            <li>
                                <label for="addr">Address</label>
                                <input id="addr" type="text" placeholder="Address.." name="addr">
                            </li>
                            <div class="errtype"></div>
                            <div class="proceedAction">
                                <button id="back1" type="button">Back</button>
                                <button id="nxt2" type="button">Next</button>
                            </div>
                        </section>
                        <section class="lsec">
                            <h4>Form 3/3</h4>

                            <li>
                                <label for="un">User name</label>
                                <input id="un" type="text" placeholder="User name.." name="un">
                            </li>
                            <li>
                                <label for="pw">Password</label>
                                <input id="pw" type="password" placeholder="Email.." name="pw">
                            </li>
                            <li>
                                <label for="cpw">Confirm password</label>
                                <input id="cpw" type="password" placeholder="Confirm password.." name="cpw">
                            </li>
                            <div class="errtype"></div>

                            <div class="proceedAction">
                                <button id="back2" type="button">Back</button>
                                <button id="submit" type="button">Submit</button>
                            </div>
                        </section>
                    </form>
                </div>





            </div>
        </div>

    </div>



</body>

</html>