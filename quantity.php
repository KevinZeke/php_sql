<?php
/**
 * Created by zhuangjiayu.
 * User: zhuangjiayu
 * Date: 2018/1/29
 * Time: 12:02
 */


require_once __DIR__ . "/sql/Sql.class.php";
require_once __DIR__ . "/formula/JSYS.php";
require_once __DIR__ . "/formula/JDJC.php";
require_once __DIR__ . "/formula/HZ.php";

quantity_main($argc, $argv);

function quantity_main($argc, $argv)
{
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

    echo ">>> jsys : inserting...\n";
    JSYS_group::group_insert($mysqli, $date);

    echo ">>> jdjc : inserting...\n";
    JDJC_group::group_insert($mysqli, $date);

    echo ">>> hz : inserting...\n";
    HZ_group::group_insert($mysqli, $date);

}


