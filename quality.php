<?php
/**
 * @author: zhuangjiayu
 * Date: 2018/2/3
 * Time: 23:06
 */


require_once __DIR__ . '/Quality/XZCF.php';
require_once __DIR__ . '/Quality/JDJC.php';
require_once __DIR__ . '/Quality/HZDC.php';
require_once __DIR__ . '/Quality/HZDC_FH.php';
require_once __DIR__ . '/Quality/BACC.php';
require_once __DIR__ . '/Quality/JSYS.php';
require_once __DIR__ . '/Quality/XZQZ.php';


/**
 * @param Sql_tool $sqltool
 * @param null $date_arr
 */
function quality($sqltool, $date_arr = null)
{
    //记录sql语句
    $mysqli = $sqltool->get_mysqli();
    Sql_tool::devopen();
    Quantity::get_coef($sqltool);

    /*echo "\n";
    echo Quantity_XZCF::insert_flws($sqltool);
    echo Quantity_XZCF::insert_score($sqltool);
    echo "\n";
    echo Quantity_JDJC::insert_flws($sqltool);
    echo Quantity_JDJC::insert_score($sqltool);
    echo "\n";
    echo Quantity_HZDC::insert_score($sqltool);
    echo Quantity_HZDC::insert_flws($sqltool);
    echo "\n";
    echo Quantity_BACC::insert_flws($sqltool);
    echo Quantity_BACC::insert_score($sqltool);*/
//echo "\n";
//echo Quantity_SHYS::insert_flws($sqltool);
//echo Quantity_SHYS::insert_score($sqltool);
//echo Quantity_AQJC::insert_flws($sqltool);
//echo Quantity_AQJC::insert_score($sqltool);


//print_r(explode('$', '2017$2018'));

//echo implode('$',['2017','2019']);
//Quantity_JSYS::insert_flws($sqltool);
//
//Quantity_JSYS::insert_score($sqltool);
//Quantity_JDJC::insert_score($sqltool);
//Quantity_HZDC::insert_score($sqltool);
//Quantity_BACC::insert_score($sqltool);
//
//Quantity_AQJC::insert_flws($sqltool);
//关闭sql记录

    Quantity_JDJC::insert_score($sqltool);
    Quantity_XZQZ::insert_score($sqltool);
    Quantity_JDJC::insert_flws($sqltool);
    echo "\n";
    Quantity_XZCF::insert_score($sqltool);
    Quantity_XZCF::insert_flws($sqltool);
    echo "\n";
    Quantity_JSYS::insert_score($sqltool);
    Quantity_JSYS::insert_flws($sqltool);
    echo "\n";
    Quantity_BACC::insert_score($sqltool);
    Quantity_BACC::insert_flws($sqltool);
    echo "\n";
    Quantity_HZDC::insert_score($sqltool);
    Quantity_HZDC::insert_flws($sqltool);
    echo "\n";
    Quantity_HZDC_FH::insert_score($sqltool);
    Quantity_HZDC_FH::insert_flws($sqltool);
    echo "\n";
    Quantity::group_insert($mysqli, $date_arr);

    Sql_tool::devclose();
}