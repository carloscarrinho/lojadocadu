<?php
require __DIR__ . "/vendor/autoload.php";

use Hcode\Page;
use Slim\Slim;

$app = new Slim();
$app->config('debug', true);

### Routes ###
$app->get('/', function () {
    $page = new Page();
    $page->setTpl("index");
});

$app->run();
