<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19
 * Time: 23:23
 */
require_once __DIR__ . '/Effect/Effect.php';
require_once __DIR__ . '/common/common.php';

/**
 * @param Sql_tool $sql_tool
 * @param array|string $data_arr
 * @return int
 */
function effect($db, $data_arr)
{
    $sql_tool = Sql_tool::mysqli_resolve($db);
    return Effect::insert_score($sql_tool, $data_arr);
}