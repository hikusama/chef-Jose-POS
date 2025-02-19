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
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time(); ?>">
    </script>
    <script src="../UX/script.js?v=<?php echo time(); ?>"></script>
    <script src="../UX/settings.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/settings.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css?v=<?php echo time(); ?>">
    <title>POS</title>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../image/logo.png" alt="logo" id="logo"></li>
                <li class="title_section">Settings</li>
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
                        <li id="cashiers">
                            <div class="textdp"><i class="fas fa-users"></i>Cashiers</div>
                        </li>

                    <?php } ?>
                </div>
                <div class="inner_side_nav_settings">
                    <li id="settings" class="on_select">
                        <div class="bgsect"></div>
                        <div class="textdp"><i class="fas fa-cog"></i>Settings</div>
                    </li>
                    <li id="logoutMhen">
                        <div class="textdp"><i class="fas fa-external-link-alt"></i>Logout</div>
                    </li>
                </div>
            </div>
        </div>
        <div class="middle_side">
            <div id="overlay_prod"></div>

            <div class="settings_cont">
                <div class="overlay_settings"></div>
                <div class="notif_settings">
                    <i class="fas fa-check"></i>
                    <h5>Theme changed successfully...</h5>
                </div>
                <ol>
                    <h3><i class="fas fa-user-cog"></i>Profiles and Account</h3>
                    <hr>
                    <li>
                        <p><i class="fas fa-pen"></i> Personal info</p>
                        <button type="button" id="edit_prof"><i class="fas fa-pen"></i>Edit</button>
                    </li>
                    <li>
                        <p><i class="fas fa-key"></i> Login info</p>
                        <button type="button" id="change_pw"><i class="fas fa-key"></i>Change</button>
                    </li>
                    <?php if ($isbaibing["ios"] === 485) { ?>

                        <li class="addm">
                            <p><i class="fas fa-key"></i> Create Employee or Cashier account</p>
                            <button type="button" id="creatempacc"><i class="fas fa-key"></i>Create</button>
                        </li>
                    <?php } ?>

                </ol>
                <ol>
                    <h3><i class="fas fa-chart-pie"></i> Themes</h3>
                    <hr>
                    <div class="themes_select">
                        <label for="theme1" id="theme1_cont">
                            <div>
                                <input type="radio" value="light" name="tm" id="light">
                            </div>
                            <div class="sample_theme">
                                <img src="../image/theme.png" alt="">

                            </div>
                            <div class="theme_name">
                                <h4>Light</h4>
                            </div>
                        </label>
                        <label for="theme2" id="theme2_cont">
                            <div>
                                <input type="radio" value="monokai" name="tm" id="monokai">
                            </div>
                            <div class="sample_theme">
                                <img src="../image/theme.png" alt="">

                            </div>
                            <div class="theme_name">
                                <h4>Monokai</h4>
                            </div>
                        </label>
                        <label for="theme3" id="theme3_cont">
                            <div>
                                <input type="radio" value="dark_modern" name="tm" id="dark_modern">
                            </div>
                            <div class="sample_theme">
                                <img src="../image/theme.png" alt="">

                            </div>
                            <div class="theme_name">
                                <h4>Dark Modern</h4>
                            </div>
                        </label>
                    </div>
                    <div class="savetm">
                        <button type="button" id="save_theme"><i class="fas fa-save"></i> Save Theme</button>
                    </div>
                </ol>
                <div class="confirm_change">
                    <h5>Are you sure you want to change theme?</h5>
                    <div>
                        <section>
                            <button type="button" id="changetheme_yes"><i class="fas fa-check"></i>Yes</button>
                        </section>
                        <section>
                            <button type="button" id="changetheme_no"><i class="fas fa-plus"></i>No</button>
                        </section>
                    </div>

                </div>

            </div>

            <div class="cpw-outer">
                <div class="cpw-inner">
                    <div class="loadPa">
                    </div>
                </div>
            </div>

            <div class="pinfo-outer">
                <div class="pinfo-inner">
                    <div class="loadPa">
                    </div>
                </div>
            </div>
            <div id="loadNt" style="display: none;">
                    <div class="loader">
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
    </div>




</body>

</html>