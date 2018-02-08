<?php
/**
 * Created by zhuangjiayu.
 * User: zhuangjiayu
 * Date: 2018/1/29
 * Time: 12:02
 */


require_once __DIR__ . "/sql/Sql.class.php";
require_once __DIR__ . "/Quantity/JSYS.php";
require_once __DIR__ . "/Quantity/JDJC.php";
require_once __DIR__ . "/Quantity/HZ.php";


//quantity_main($date);

function quantity($date)
{
    $sqltool = Sql_tool::build();
    $mysqli = $sqltool->get_mysqli();

    //    $sqltool->do_not_gone_away();

    echo ">>> jsys : inserting...\n";
    JSYS_group::group_insert($mysqli, $date);

    echo ">>> jdjc : inserting...\n";
    JDJC_group::group_insert($mysqli, $date);

    echo ">>> hz : inserting...\n";
    HZ_group::group_insert($mysqli, $date);

}

