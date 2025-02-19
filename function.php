<?php

if ($_SERVER['REQUEST_URI'] == "/function.php") {
    header("Location: index.php");
}




// Start a secure session with proper configurations
if (!function_exists('start_secure_session')) {
    function start_secure_session()
    {
        // Start session only if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => 0,           // Session ends when browser closes
                'cookie_secure'   => false,        // Cookies sent only over HTTP
                'cookie_httponly' => true,        // Prevent JavaScript from accessing cookies
                'use_strict_mode' => true,        // Reject invalid session IDs
                'use_only_cookies' => true,       // Disallow session ID in URLs
                'sid_length'      => 64,          // Long session IDs
                'sid_bits_per_character' => 6     // Stronger session IDs
            ]);
        }

        // Regenerate session ID periodically
        if (!isset($_SESSION['initialized'])) {
            session_regenerate_id(true); // Regenerate and delete old session
            $_SESSION['initialized'] = true;
        }

        // Implement session timeout (e.g., 15 minutes inactivity)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1500)) {
            session_unset(); // Clear session variables
            session_destroy(); // Destroy session
            header("Location: ../../index.php");
        }
        $_SESSION['last_activity'] = time(); // Update last activity time

        // Validate session integrity
        if (!isset($_SESSION['ip_address'])) {
            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR']; // Store IP address
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; // Store user agent
        } elseif (
            $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] ||
            $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']
        ) {
            session_unset();
            session_destroy();
            header("Location: ../../index.php");
        }
    }
}

start_secure_session();








function validateByLoc($part)
{

    $userID = $_SESSION["userID"] ?? null;
    $session_token = $_SESSION["session_token"] ?? null;

    // if (isset($_SESSION["userID"], $_SESSION["session_token"])) {

    //     if ($_SESSION["userRole"] === "Admin") {
    //         header("Location: pannel/overview.php");
    //     } else if ($_SESSION["userRole"] === "Employee") {
    //         header("Location: pannel/cashier.php");
    //     }
    // }

    $obj = null;

    if (isset($_SESSION["userID"]) && isset($_SESSION["session_token"])) {

        require_once 'Controller/sessionController.php';
        $obj = new SessionController($userID, $session_token);

        if ($obj->getSessionGate()) {
            $newToken = bin2hex(random_bytes(32));
            $hashedNew = hash("sha256", $newToken);
            $role = $obj->setSession($userID, $hashedNew);
            $obj = null;
            $_SESSION["session_token"] = $hashedNew;
            $_SESSION["userID"] = $userID;
            $_SESSION["userRole"] = $role;

            if ($part === "endex") {
                if ($_SESSION["userRole"] === "Admin") {
                    header("Location: pannel/overview.php");
                } else if ($_SESSION["userRole"] === "Employee") {
                    header("Location: pannel/cashier.php");
                } else {
                    header("Location: logout.php");
                }
            }
        } else {
            session_unset();
            session_destroy();
            if ($part === "in") {
                header("Location: ../index.php");
            } else if ($part === "endex") {
            } else {
                header("Location: index.php");
            }
        }
    } else {
        session_unset();
        session_destroy();
        if ($part === "in") {
            header("Location: ../index.php");
        } else if ($part === "endex") {
        } else {
            header("Location: index.php");
        }
    }
}


function getRole()
{
    if (isset($_SESSION["userID"])) {
        return $_SESSION["userRole"];
    } else {
        return NULL;
    }
}

function isAdminRole()
{
    if (isset($_SESSION["userID"])) {
        if ($_SESSION["userRole"] === "Admin") {
            return true;
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Cant access."]);
        }
    }
}


function validate($uri)
{

    // checkUri();
    $role = $_SESSION["userRole"];
    if (checkRole($role, $uri)) {
        $sideOg = getSideNav($role);

        return [
            "ios" => $sideOg
        ];
    } else {
        // header("Location: 404.php?popo=1" . $_SESSION["userRole"] . "45");
    }
}


function checkRole($role, $uri)
{

    if ($role === "Admin" || $role === "Employee") {

        if ($role === "Employee") {
            $employee_routes = [
                '/pannel/cashier.php',

                '/pannel/history.php',

                '/pannel/settings.php',

            ];
            if (checkUri($uri, $employee_routes)) {
                return true;
            }
        } else if ($role === "Admin") {
            $admin_routes = [
                '/pannel/home.php',

                '/pannel/cashier.php',

                '/pannel/history.php',

                '/pannel/cashiers.php',

                '/pannel/overview.php',

                '/pannel/myproducts.php',

                '/pannel/reports.php',

                '/pannel/settings.php',

            ];
            if (checkUri($uri, $admin_routes)) {
                return true;
            } else {
                header("Location: 404.php?popo=3");
            }
        }
    } else {
        header("Location: ../index.php");
    }
}



function getSideNav($role)
{
    if ($role === "Admin") {
        return 485;
    } else if ($role === "Employee") {
        return null;
    }
}

function checkUri($uri, $routes)
{

    if (in_array($uri, $routes)) {
        return true;
    } else {
        header("Location: 404.php?route=denied");
    }
}

/*

    $val = 0;
    foreach ($routes as $route) {
        if ($route === $uri) {
            $val += 1;
        }
    }
    if ($val > 0) {
        return true;
    } else {
        header("Location: 404.php?route=denied");
    }
*/