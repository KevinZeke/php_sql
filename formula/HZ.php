<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午6:43
 */

require_once __DIR__ . '/Formula.class.php';

require_once __DIR__ . '/../map/Quantity_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_sub_score.map.php';


class HZ_formula extends Formula
{
    static $xzcf_2_huizong;
}

HZ_formula::$xzcf_2_huizong = [

    Quantity_sub_score_map::$xzcf_zdf => Quantity_xzcf_gr_sub_score_map::$xzcf_zdf

];