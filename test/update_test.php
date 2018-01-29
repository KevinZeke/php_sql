<?php
require_once __DIR__ . "/../sql/Sql.class.php";
require_once __DIR__ . "/../formula/JSYS.php";
require_once __DIR__ . "/../formula/JDJC.php";
require_once __DIR__ . "/../formula/HZ.php";


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
$date_arr = ['2017-01-01', '2017-12-30'];

unlink("D:/php5.4.32/db/php_sql/log/loginfo/2018_01_29__test.sql");

if (false) {
    JSYS_group::jg_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::sh_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::ys_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::ba_sub_update_date_in($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_jg_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_sh_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_ba_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    JSYS_group::jianshen_update_ys_by_date($mysqli, ['2017-01-01', '2017-12-30']);
    HZ_group::update_jsys_by_date($mysqli, ['2017-01-01', '2017-12-30']);
}


if(false){
    JDJC_group::jcdw_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::dczg_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::fxhz_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::xfls_sub_update_date_in($mysqli, $date_arr);
    JDJC_group::jdjc_update_jcdw_by_date($mysqli, $date_arr);
    JDJC_group::jdjc_update_dczg_by_date($mysqli, $date_arr);
    JDJC_group::jdjc_update_fxhz_by_date($mysqli, $date_arr);
    JDJC_group::jdjc_update_xfls_by_date($mysqli, $date_arr);
    HZ_group::update_jdjc_by_date($mysqli, $date_arr);
}


if(true){

    

}

