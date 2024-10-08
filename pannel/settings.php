<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js">
    </script>
    <script src="../UX/script.js"></script>
    <script src="../UX/settings.js"></script>
    <link rel="stylesheet" href="../resources/style.css">
    <link rel="stylesheet" href="../resources/settings.css">
    <link rel="stylesheet" href="../resources/fontawesome-free-5.15.4-web/css/all.css">
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

                    <li id="history">
                        <div class="textdp"><i class="fas fa-history"></i>History</div>
                    </li>
                </div>
                <div class="inner_side_nav_settings">
                    <li id="settings" class="on_select">
                        <div class="bgsect"></div>
                        <div class="textdp"><i class="fas fa-cog"></i>Settings</div>
                    </li>
                </div>
            </div>
        </div>
        <div class="middle_side">
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
                        <p><i class="fas fa-pen"></i> Edit Cedentials</p>
                        <button type="button" id="edit_prof"><i class="fas fa-pen"></i>Edit</button>
                    </li>
                    <li>
                        <p><i class="fas fa-key"></i> Change password</p>
                        <button type="button" id="change_pw"><i class="fas fa-key"></i>Change password</button>
                    </li>
                </ol>
                <ol>
                    <h3><i class="fas fa-chart-pie"></i> Themes</h3>
                    <hr>
                        <div class="themes_select">
                            <label for="theme1" id="theme1_cont" >
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
        </div>

    </div>



</body>

</html>