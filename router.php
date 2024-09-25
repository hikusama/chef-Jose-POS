<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

 $routes = [
    '/' => 'pannel/home.php',
    '/cashier' => 'pannel/cashier.php',
    '/history' => 'pannel/history.php',
    '/overview' => 'pannel/overview.php',
    '/myproducts' => 'pannel/myproducts.php',
    '/reports' => 'pannel/reports.php',
    '/settings' => 'pannel/settings.php',

];


function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort($code = 404) {
    http_response_code($code);

    require "pannel/{$code}.php";

    die();
}

echo routeToController($uri, $routes);