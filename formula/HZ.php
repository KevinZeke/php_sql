<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午6:43
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/../map/Quantity_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_gr_score.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_sub_score.map.php';


class HZ_formula extends Formula
{
    static $xzcf_2_sub;

    static $sub_2_gr_xzcf;
}

HZ_formula::$xzcf_2_huizong = [

    Quantity_sub_score_map::$xzcf_zdf => Quantity_xzcf_gr_sub_score_map::$xzcf_zdf

];


class HZ_group implements Table_group
{
    /**
     * 此函数用于更新quantity_sub_table的xzcf项（非更新xzcf相关的子表）
     * @param $sub_table quantity_sub_table的Table实例
     * @param $param 查询参数
     * @return mixed
     */
    static public function sub_update_xzcf_item($sub_table, $param)
    {
        return $sub_table->union_update(
            [
                Quantity_xzcf_gr_sub_score_map::$table_name
            ],
            HZ_formula::$xzcf_2_sub,
            $param
        );
    }


}