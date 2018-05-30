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

//xzcf
    XZCF_group::group_update_date_in($mysqli,$date);
//jsys
    JSYS_group::sh_sub_update_date_in($mysqli, $date);
    JSYS_group::jg_sub_update_date_in($mysqli, $date);
    JSYS_group::ba_sub_update_date_in($mysqli, $date);
    JSYS_group::ys_sub_update_date_in($mysqli, $date);
//xzqz
    JDJC_group::xfls_sub_update_date_in($mysqli, $date);
//hzdc
    HZDC_group::group_update_date_in($mysqli,$date);
//jdjc
    JDJC_group::jcdw_sub_update_date_in($mysqli,$date);
    JDJC_group::fxhz_sub_update_date_in($mysqli,$date);
    JDJC_group::dczg_sub_update_date_in($mysqli,$date);
    JDJC_group::xfls_sub_update_date_in($mysqli,$date);

    echo ">>> jsys : inserting...\n";
    JSYS_group::group_insert($mysqli, $date);

    echo ">>> jdjc : inserting...\n";
    JDJC_group::group_insert($mysqli, $date);

    echo ">>> hz : inserting...\n";
    HZ_group::group_insert($mysqli, $date);

}

