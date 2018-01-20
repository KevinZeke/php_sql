<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午6:43
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/Table_gropu.interface.php';
require_once __DIR__ . '/../map/Quantity_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_gr_score.map.php';
require_once __DIR__ . '/../map/Quantity_gr_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_sub_score.map.php';


class HZ_formula extends Formula
{
    static $xzcf_2_gr;

    static $hzdc_2_sub;

    static $hzdc_2_gr;
}

HZ_formula::$hzdc_2_sub = [
    Quantity_sub_score_map::$police_name => Quantity_hzdc_gr_sub_score_map::$police_name,
    Quantity_sub_score_map::$dd_name => Quantity_hzdc_gr_sub_score_map::$dadui_name,
    Quantity_sub_score_map::$year_month_show => Quantity_hzdc_gr_sub_score_map::$year_month_show,
    Quantity_sub_score_map::$hzdc_zdf =>
        'SUM(' . Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score . ')'
];

HZ_formula::$xzcf_2_gr = [

    Quantity_sub_score_map::$xzcf_zdf =>
        'SUM(' . Quantity_xzcf_gr_sub_score_map::$xzcf_zdf . ')',
    Quantity_gr_score_map::$xzcf_zdf_weighed => Formula::mul(
        [
            Quantity_xzcf_gr_sub_score_map::$xzcf_zdf,
            Quantity_gr_coef_map::$xzcf_coef
        ]
    )

];

HZ_formula::$hzdc_2_gr = [

    Quantity_sub_score_map::$hzdc_zdf =>
        'SUM(' . Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score . ')',
    Quantity_gr_score_map::$hzdc_zdf_weighed => Formula::mul(
        [
            Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score,
            Quantity_gr_coef_map::$hzdc_coef
        ]
    )
];


class HZ_group implements Table_group
{

    /**
     * 判断当前数据表是否存在符合日期和警员名的数据
     * @param SqlTool|mysqli $db
     * @param string $name 警员名
     * @param string $date 日期
     * @return bool    返回布尔值
     */
    public static function is_row_ext($db, $name, $date)
    {
        $sql = "SELECT COUNT(police_name) AS num
	        FROM " . Quantity_sub_score_map::$table_name . "
	        WHERE year_month_show = '$date'
	        AND police_name = '$name' LIMIT 1";
        if ($db instanceof SqlTool)
            $res = $db->execute_dql($sql)->fetch_array();
        else if ($db instanceof mysqli)
            $res = SqlTool::build_by_mysqli($db)->execute_dql($sql)->fetch_array();
        else
            die("the first argument must be instanceof SqlTool or mysqli");
        if ($res[0] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 此函数用于更新quantity_sub_table以及quantity_gr_table的xzcf项（非更新xzcf相关的子表）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param  string $date
     * @return mixed
     * @internal param quantity_gr_table的Table实例 $sub_table
     */
    static public function update_xzcf_item($mysqli, $police_name, $date)
    {
        //改成sub表更新，gr表依靠触发器
//        return (new Table(Quantity_gr_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))->union_update(
//            [
//                Quantity_xzcf_gr_sub_score_map::$table_name,
//                Quantity_gr_coef_map::$table_name,
//                Quantity_sub_score_map::$table_name
//            ],
//            HZ_formula::$xzcf_2_gr,
//            $param.SqlTool::GROUP([Quantity_xzcf_gr_sub_score_map::$year_month_show])
//        );

        return (new Table(Quantity_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    "(SELECT SUM(" . Quantity_xzcf_gr_sub_score_map::$xzcf_zdf . ") AS res , police_name,year_month_show FROM " . Quantity_xzcf_gr_sub_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_xzcf_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xzcf_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Quantity_sub_score_map::$xzcf_zdf => 'A.res'
                ],
                SqlTool::WHERE([
                    Quantity_sub_score_map::$year_month_show => 'A.res',
                    Quantity_sub_score_map::$police_name => 'A.police_name'
                ], false)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return mixed
     */
    static public function update_hzdc_item($mysqli, $police_name, $date)
    {
        //改成sub表更新，gr表依靠触发器
//        return (new Table(Quantity_gr_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))->union_update(
//            [
//                Quantity_hzdc_gr_sub_score_map::$table_name,
//                Quantity_gr_coef_map::$table_name,
//                Quantity_sub_score_map::$table_name
//            ],
//            HZ_formula::$hzdc_2_gr,
//            $param . SqlTool::GROUP([Quantity_hzdc_gr_sub_score_map::$year_month_show])
//        );
        return (new Table(Quantity_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_update(
                [
                    "(SELECT SUM(" . Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score . ") 
                    AS res , police_name, year_month_show FROM 
                    " . Quantity_hzdc_gr_sub_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_hzdc_gr_sub_score_map::$police_name => $police_name,
                        Quantity_hzdc_gr_sub_score_map::$year_month_show => $date
                    ]) . ' ) A '
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                SqlTool::WHERE([
                    Quantity_sub_score_map::$year_month_show => 'A.res',
                    Quantity_sub_score_map::$police_name => 'A.police_name'
                ], false)
            );
    }


    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_hzdc_item($mysqli, $param = '')
    {
        return (new Table(Quantity_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))->union_insert(
            [
                Quantity_hzdc_gr_sub_score_map::$table_name,
            ],
            HZ_formula::$hzdc_2_sub,
            $param . SqlTool::GROUP([Quantity_hzdc_gr_sub_score_map::$year_month_show, Quantity_hzdc_gr_sub_score_map::$police_name])
        );
    }


    static function group_update($mysqli, $param)
    {
        // TODO: Implement group_update() method.
    }

    static function group_update_date_in($mysqli, $date_arr)
    {
        // TODO: Implement group_update_date_in() method.
    }

    static function group_update_by_id($mysqli, $id)
    {
        // TODO: Implement group_update_by_id() method.
    }
}