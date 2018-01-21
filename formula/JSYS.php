<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/21
 * Time: 17:14
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/Table_gropu.interface.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../map/Jianshenyanshou_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfjgys_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfyss_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjbas_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_xfsjshs_gr_sub_score.map.php';


class JSYS_formula extends Formula
{
    /**
     * @var 对照：竣工 => sub
     */
    static $jg_2_sub;
    /**
     * @var 对照：备案 => sub
     */
    static $ba_2_sub;
    /**
     * @var 对照：验收 => sub
     */
    static $ys_2_sub;
    /**
     * @var 对照：审核 => sub
     */
    static $sh_2_sub;
}

//竣工 => sub
JSYS_formula::$jg_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfjgys_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfjgys_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfjgys_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$jgysbas_score => Quantity_xfjgys_gr_sub_score_map::$jgysbacc_total_score

];

//备案 => sub
JSYS_formula::$ba_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfsjbas_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfsjbas_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$sjbas_score => Quantity_xfsjbas_gr_sub_score_map::$sjbabacc_total_score
];

//验收 => sub
JSYS_formula::$ys_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfyss_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfyss_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfyss_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$xfyss_score => Quantity_xfyss_gr_sub_score_map::$gcys_total_score
];

//审核 => sub
JSYS_formula::$sh_2_sub = [
    Jianshenyanshou_sub_score_map::$police_name => Quantity_xfsjshs_gr_sub_score_map::$police_name,
    Jianshenyanshou_sub_score_map::$year_month_show => Quantity_xfsjshs_gr_sub_score_map::$year_month_show,
    Jianshenyanshou_sub_score_map::$dd_name => Quantity_xfsjshs_gr_sub_score_map::$dadui_name,
    Jianshenyanshou_sub_score_map::$sjshs_score => Quantity_xfsjshs_gr_sub_score_map::$sjshs_total_score
];



/**
 * Class JSYS_group 建审验收相关表格组类
 */
class JSYS_group extends Table_group
{
    //TODO:代码重构 ，DRY

    /**
     * @param mysqli|SqlTool $db
     * @param string $name
     * @param string $date
     * @return bool
     */
    public static function is_row_ext($db, $name, $date)
    {
        return parent::is_row_ext(
            $db, Jianshenyanshou_sub_score_map::$table_name, $name, $date
        );
    }

    /**
     * @param $mysqli
     * @param string $param
     * @return int
     */
    static function insert_sh($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfsjshs_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$sh_2_sub,
                $param . SqlTool::GROUP([
                    Quantity_xfsjshs_gr_sub_score_map::$year_month_show,
                    Quantity_xfsjshs_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * @param $mysqli
     * @param string $param
     * @return int
     */
    static function insert_jg($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfjgys_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$jg_2_sub,
                $param . SqlTool::GROUP([
                    Quantity_xfjgys_gr_sub_score_map::$year_month_show,
                    Quantity_xfjgys_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * @param $mysqli
     * @param string $param
     * @return int
     */
    static function insert_ba($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfsjbas_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$ba_2_sub,
                $param . SqlTool::GROUP([
                    Quantity_xfsjbas_gr_sub_score_map::$year_month_show,
                    Quantity_xfsjbas_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return int
     */
    static function insert_ys($mysqli, $param = '')
    {
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xfyss_gr_sub_score_map::$table_name
                ],
                JSYS_formula::$ba_2_sub,
                $param . SqlTool::GROUP([
                    Quantity_xfyss_gr_sub_score_map::$year_month_show,
                    Quantity_xfyss_gr_sub_score_map::$police_name
                ])
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function insert_sh_item($mysqli, $police_name, $date)
    {
        return self::insert_sh(
            $mysqli, SqlTool::WHERE([
            Quantity_xfsjshs_gr_sub_score_map::$police_name => $police_name,
            Quantity_xfsjshs_gr_sub_score_map::$year_month_show => $date
        ])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function insert_ba_item($mysqli, $police_name, $date)
    {
        return self::insert_ba(
            $mysqli, SqlTool::WHERE([
            Quantity_xfsjbas_gr_sub_score_map::$police_name => $police_name,
            Quantity_xfsjbas_gr_sub_score_map::$year_month_show => $date
        ])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function insert_jg_item($mysqli, $police_name, $date)
    {
        return self::insert_jg(
            $mysqli, SqlTool::WHERE([
            Quantity_xfjgys_gr_sub_score_map::$police_name => $police_name,
            Quantity_xfjgys_gr_sub_score_map::$year_month_show => $date
        ])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @return int
     */
    static function insert_ys_item($mysqli, $police_name, $date)
    {
        return self::insert_ys(
            $mysqli, SqlTool::WHERE([
            Quantity_xfyss_gr_sub_score_map::$police_name => $police_name,
            Quantity_xfyss_gr_sub_score_map::$year_month_show => $date
        ])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function update_sh_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::insert_sh_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT SUM(" . Quantity_xfsjshs_gr_sub_score_map::$sjshs_total_score . ") AS res , police_name,year_month_show FROM " . Quantity_xfsjshs_gr_sub_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_xfsjshs_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfsjshs_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$sjshs_score => 'A.res'
                ],
                SqlTool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                    Jianshenyanshou_sub_score_map::$police_name => 'A.police_name'
                ], false)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function update_ys_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::insert_ys_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT SUM(" . Quantity_xfyss_gr_sub_score_map::$gcys_total_score . ") AS res , police_name,year_month_show FROM " . Quantity_xfyss_gr_sub_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_xfyss_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfyss_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$xfyss_score => 'A.res'
                ],
                SqlTool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                    Jianshenyanshou_sub_score_map::$police_name => 'A.police_name'
                ], false)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function update_jg_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::insert_jg_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT SUM(" . Quantity_xfjgys_gr_sub_score_map::$jgysbacc_total_score . ") AS res , police_name,year_month_show FROM " . Quantity_xfjgys_gr_sub_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_xfjgys_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfjgys_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$jgysbas_score => 'A.res'
                ],
                SqlTool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                    Jianshenyanshou_sub_score_map::$police_name => 'A.police_name'
                ], false)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static function update_ba_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = SqlTool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::insert_ba_item($db, $police_name, $date);
            }
        }
        return (new Table(Jianshenyanshou_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT SUM(" . Quantity_xfsjbas_gr_sub_score_map::$sjbabacc_total_score . ") AS res , police_name,year_month_show FROM " . Quantity_xfsjbas_gr_sub_score_map::$table_name .
                    SqlTool::WHERE([
                        Quantity_xfsjbas_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xfsjbas_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Jianshenyanshou_sub_score_map::$sjbas_score => 'A.res'
                ],
                SqlTool::WHERE([
                    Jianshenyanshou_sub_score_map::$year_month_show => 'A.year_month_show',
                    Jianshenyanshou_sub_score_map::$police_name => 'A.police_name'
                ], false)
            );
    }

    /**
     * @param mysqli $mysqli
     */
    static function group_update($mysqli)
    {
        self::insert_sh($mysqli,'');
        $sqlTool = SqlTool::build_by_mysqli($mysqli);
        $sub_table = new Table(Jianshenyanshou_sub_score_map::$table_name,$sqlTool);
        $jg_table = new Table(Quantity_xfjgys_gr_sub_score_map::$table_name,$sqlTool);
//        $sh_table = new Table(Quantity_xfsjshs_gr_sub_score_map::$table_name,$sqlTool);
        $ba_table = new Table(Quantity_xfsjbas_gr_sub_score_map::$table_name,$sqlTool);
        $ys_table = new Table(Quantity_xfyss_gr_sub_score_map::$table_name,$sqlTool);

        //TODO
        $res = $jg_table->group_query(
            [
                Quantity_xfjgys_gr_sub_score_map::$police_name => 'n',
                Quantity_xfjgys_gr_sub_score_map::$year_month_show => 'd',
                Quantity_xfjgys_gr_sub_score_map::$jgysbacc_total_score => 's'
            ],
            [
                Quantity_xfjgys_gr_sub_score_map::$year_month_show,
                Quantity_xfjgys_gr_sub_score_map::$police_name
            ]
        );
    }
}