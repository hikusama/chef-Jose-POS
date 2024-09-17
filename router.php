<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

 $routes = [
    '/' => 'views/home.php',
    '/cashier' => 'views/cashier.php',
    '/history' => 'views/history.php',
    '/overview' => 'views/overview.php',
    '/myproducts' => 'views/myproducts.php',
    '/reports' => 'views/reports.php',
    '/settings' => 'views/settings.php',

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

    require "views/{$code}.php";

    die();
}

echo routeToController($uri, $routes);