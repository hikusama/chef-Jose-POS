<?php
require_once "function.php";
start_secure_session();

if (isset($_SESSION["userID"])) {
    if ($_SESSION["userRole"] === "Admin") {
        header("Location: pannel/overview.php");
    }else if ($_SESSION["userRole"] === "Employee") {
        header("Location: pannel/cashier.php");
    }
}

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="resources/login.css?v="<?php echo time();?>>
    <link rel="stylesheet" href="resources/fontawesome-free-5.15.4-web/css/all.css?v=" <?php echo time(); ?>>
    <script src="UX/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            let pt = window.location.search
            let loc = [
                "?error=stmtfailed",
                "?error=usernotfound",
                "?error=wrongpassword"
            ]
            let param = new URLSearchParams(pt)            

            // if (loc.includes(pt)) {

            // }
            
            
            if (loc.includes(pt)) {
                $(".resp").html(param.get("error"));
                $(".main-loader").detach();
            }else{
                $(".resp").html("");
                animate()
            }






            function animate() {

                setTimeout(() => {
                    $(".center-things").css("transform", "translateY(-1rem) scale(1)");

                }, 2000);

                setTimeout(() => {
                    $(".loader-bar").css("visibility", "visible");
                }, 2500);

                setTimeout(() => {
                    $(".loader-bar").css("width", "16rem");
                    $(".loader-bar").css("visibility", "visible");
                }, 3000);
                setTimeout(() => {
                    $(".mubing").css("width", "3rem");
                    $(".icun").css("transform", "translateY(-1.5rem) translateX(.5rem)");
                }, 4500);
                setTimeout(() => {
                    $(".mubing").css("transition", "2s");
                    $(".mubing").css("width", "5rem");
                }, 4800);
                setTimeout(() => {
                    $(".mubing").css("transition", "1s");
                    $(".mubing").css("width", "8rem");
                }, 5200);
                setTimeout(() => {
                    $(".mubing").css("transition", "3.5s");
                    $(".mubing").css("width", "14rem");
                }, 7000);
                setTimeout(() => {
                    $(".mubing").css("transition", "1s");
                    $(".mubing").css("width", "16rem");
                }, 7500);
                setTimeout(() => {
                    $(".main-loader").detach();
                }, 8500);
            }
        });
    </script>
</head>

<body>
    <div class="main-loader">
        <div class="center-things">
            <img src="image/logo.png" id="logo-load" alt="">
            <div class="loader-bar">
                <div class="mubing">
                    <div class="icun">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        <section id="login-container">
            <div id="login">
                <div id="logo">
                    <img src="image/logo.png" alt="Logo">
                </div>
                <form action="Views/loginView.php" method="post" id="form">
                    <div class="form-group">
                        <input type="text" autocomplete="off" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" autocomplete="off" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="resp"></div>
                    <button type="submit" name="submit" id="btn">LOGIN</button>
                </form>
            </div>
        </section>
    </main>


</body>

</html>