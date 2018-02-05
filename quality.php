<?php
/**
 * @author: zhuangjiayu
 * Date: 2018/2/3
 * Time: 23:06
 */


require_once __DIR__ . '/Quality/XZCF.php';


$mysqli = new mysqli(
    'localhost', 'root', '123456', 'zxpg_gzpc_db'
);
$sqltool = Sql_tool::build_by_mysqli($mysqli);

//记录sql语句
Sql_tool::devopen();

Quantity_XZCF::insert_score($sqltool);

//关闭sql记录
Sql_tool::devclose();