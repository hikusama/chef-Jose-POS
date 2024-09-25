<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../resources/forntpage.css">
    <link rel="stylesheet" href="../resources/login.css">
</head>
<body>
    <main>
        <section id="login-container">
            <div id="login">
                <div id="logo">
                    <img src="../image/logo.png" alt="Logo">
                </div>
                <form action="../views/loginView.php"  method="post" id="form">
                    <div class="form-group">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="submit" id="btn">LOGIN</button>
                </form>
            </div>
        </section>
    </main>


</body>
</html>
