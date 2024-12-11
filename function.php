<?php

session_start();






function getRole(){
    if (isset($_SESSION["userID"])) {
        return $_SESSION["userRole"];
    }else{
        return NULL;
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
