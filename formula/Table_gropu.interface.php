<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2018/1/19
 * Time: 下午10:17
 */

/**
 * Class Table_group
 * 表格组接口
 */
interface Table_group
{
    static function group_update($mysqli, $param);

    static function group_update_date_in($mysqli, $date_arr);

    static function group_update_by_id($mysqli, $id);
}