<?php
// web/app.php
require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';
require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;

// Force to use HTTPS
if($_SERVER['HTTPS'] != 'on') {
    $goto = '';
    if($_SERVER['REQUEST_URI'] != '') {
        $goTo = $_SERVER['REQUEST_URI'];
    }
    header("Location: https://thalamus.io".$goTo);
}

$kernel = new AppKernel('prod', true);
$kernel->loadClassCache();
// wrap the default AppKernel with the AppCache one
$kernel = new AppCache($kernel);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
