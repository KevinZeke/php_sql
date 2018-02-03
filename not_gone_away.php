<?php
/**
 * @author:zhuangjiayu
 * Date: 2018/2/1
 * Time: 8:55
 * 临时更改mysql全局变量，避免插入过长sql语句时被mysql server拒绝
 */
require_once __DIR__ . "/sql/Sql.class.php";


$sqltool = Sql_tool::build();

$sqltool->do_not_gone_away();



