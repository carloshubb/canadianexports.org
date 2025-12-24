<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

if (file_exists($down = __DIR__.'/../storage/framework/down')) {
    ?>
   <!doctype html>
<title>Site Maintenance</title>
<style>
  body {background-color:#cccccc;font: 20px Helvetica, sans-serif; text-align: center; padding: 20px; color: #106BC7; }
  @media (min-width: 768px){
    body{ padding-top: 150px; }
    h1 { font-size: 36px; color: #dc8100;}
  }
  article { display: block; text-align: left; max-width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #888888; text-decoration: none; }
</style>

<article>
<img src="/assets/images/logo.png">
    <h1>We will be back online momentarily.</h1>
    <div>
        <p>We apologize for any inconvenience caused as we are currently undergoing some technical maintenance. We will be back online momentarily. Thank you for your patience!</p>
        <p>&mdash; Canadian Export Team</p>
    </div>
</article>
   <?php
} else {

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
}