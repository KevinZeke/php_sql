<?php
require_once __DIR__ . "/sql/Sql.class.php";
require_once __DIR__ . "/formula/JSYS.php";
require_once __DIR__ . "/formula/JDJC.php";
require_once __DIR__ . "/formula/HZ.php";


$date = null;
if ($argc == 2) {
    $date = $argv[1];
} else if ($argc == 3) {
    $date = [$argv[1], $argv[2]];
}

if ($date)
    var_dump($date);
else
    echo 'attention : no date(s) provided, the program will reinsert all the data' . "\n";

$sqltool = SqlTool::build();
$mysqli = $sqltool->get_mysqli();
SqlTool::$isDev = true;
JSYS_group::jg_sub_update_date_in($mysqli, ['2017-01-01','2017-12-30']);
JSYS_group::jianshen_update_jg_by_date($mysqli, ['2017-01-01','2017-12-30']);
HZ_group::update_jsys_by_date($mysqli, ['2017-01-01','2017-12-30']);