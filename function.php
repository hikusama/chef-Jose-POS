<?php

session_start();






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

    if (isset($_SESSION["userID"])) {
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
    } else {
        header("Location: ../index.php");
    }
}


function checkRole($role, $uri)
{

    if ($role === "Admin" || $role === "Employee") {

        if ($role === "Employee") {
            $employee_routes = [
                '/chef-Jose-POS/pannel/cashier.php',

                '/chef-Jose-POS/pannel/history.php',

                '/chef-Jose-POS/pannel/settings.php',

            ];
            if (checkUri($uri, $employee_routes)) {
                return true;
            }
        } else if ($role === "Admin") {
            $admin_routes = [
                '/chef-Jose-POS/pannel/home.php',

                '/chef-Jose-POS/pannel/cashier.php',

                '/chef-Jose-POS/pannel/history.php',

                '/chef-Jose-POS/pannel/cashiers.php',

                '/chef-Jose-POS/pannel/overview.php',

                '/chef-Jose-POS/pannel/myproducts.php',

                '/chef-Jose-POS/pannel/reports.php',

                '/chef-Jose-POS/pannel/settings.php',

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