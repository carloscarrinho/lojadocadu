<?php

use Hcode\DB\Sql;
use Slim\Slim;

require __DIR__ . "/vendor/autoload.php";

$app = new Slim();
$app->config('debug', true);

$app->get('/', function () {
    $sql = new Sql();
    $result = $sql->select("SELECT * FROM tb_users");
    echo json_encode($result);
});

$app->run();
