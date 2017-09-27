<?php
// Grabs the URI and breaks it apart in case we have querystring stuff
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$path = explode('/', $request_uri[0]);
array_shift($path);

// Route it up!
switch ($path[0]) {
    case 'api':
        api($path[1]);
        break;
    default:
        require 'Client/single_page.php';
        break;
}

function api($url)
{
    switch ($url) {
        case 'snippets':
            require 'Server/php/snippets.php';
            break;
        default:
            header('HTTP/1.0 404 Not Found');
            break;
    }
}
?>