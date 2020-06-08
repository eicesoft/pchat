<?php

use PHPChat\Server;

include 'vendor/autoload.php';

$config = yaml_parse_file('pchat.yaml');
var_dump($config);
$server = new Server('127.0.0.1', 8899);

//$a = [
//    "command" => 12,
//    "data" => [
//        'msg' => 'asasgsgsgsgasgsg',
//        'code' => 30,
//        'cod2e' => 50,
//    ]
//];
//
//$start = microtime(true);
//for($i = 0; $i < 10000; $i++) {
//    (strlen(igbinary_serialize($a)));
//}
//echo sprintf("%0.4f ms", (microtime(true) - $start));
//
//$start = microtime(true);
//(strlen(json_encode($a)));
//echo sprintf("%0.4f ms", (microtime(true) - $start));
