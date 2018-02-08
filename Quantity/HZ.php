<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午6:43
 */

require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/Table_gropu.php';
require_once __DIR__ . '/JDJC.php';
require_once __DIR__ . '/XZCF.php';
require_once __DIR__ . '/JSYS.php';
require_once __DIR__ . '/HZDC.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../map/Quantity_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_gr_score.map.php';
require_once __DIR__ . '/../map/Quantity_gr_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Jianshenyanshou_gr_score.map.php';
require_once __DIR__ . '/../map/Jiancha_and_jiangduo_gr_score.map.php';
require_once __DIR__ . '/../map/Dadui_huizong_query_day.map.php';


class HZ_formula extends Formula
{
//    static $xzcf_2_gr;

    static $hzdc_2_sub;

    static $xzcf_2_sub;

    static $jsys_2_sub;

    static $jdjc_2_sub;

    static $hz_sub_2_gr;

//    static $hzdc_2_gr;
}

HZ_formula::$hzdc_2_sub = [
    Quantity_sub_score_map::$police_name => Quantity_hzdc_gr_sub_score_map::$police_name,
    Quantity_sub_score_map::$dd_name => Quantity_hzdc_gr_sub_score_map::$dadui_name,
    Quantity_sub_score_map::$year_month_show => Quantity_hzdc_gr_sub_score_map::$year_month_show,
    Quantity_sub_score_map::$hzdc_zdf =>
        'SUM(' . Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score . ')'
];

HZ_formula::$xzcf_2_sub = [
    Quantity_sub_score_map::$police_name => Quantity_xzcf_gr_sub_score_map::$police_name,
    Quantity_sub_score_map::$year_month_show => Quantity_xzcf_gr_sub_score_map::$year_month_show,
    Quantity_sub_score_map::$xzcf_zdf =>
        'SUM(' . Quantity_xzcf_gr_sub_score_map::$xzcf_zdf . ')',
    Quantity_sub_score_map::$dd_name => Quantity_xzcf_gr_sub_score_map::$dd_name
];

HZ_formula::$jsys_2_sub = [

    Quantity_sub_score_map::$police_name => Jianshenyanshou_gr_score_map::$police_name,
    Quantity_sub_score_map::$year_month_show => Jianshenyanshou_gr_score_map::$year_month_show,
    Quantity_sub_score_map::$jsys_zdf =>
        'SUM(' . Jianshenyanshou_gr_score_map::$jsys_zdf . ')',
    Quantity_sub_score_map::$dd_name => Jianshenyanshou_gr_score_map::$dd_name

];

HZ_formula::$jdjc_2_sub = [

    Quantity_sub_score_map::$police_name => Jiancha_and_jiangduo_gr_score_map::$police_name,
    Quantity_sub_score_map::$year_month_show => Jiancha_and_jiangduo_gr_score_map::$year_month_show,
    Quantity_sub_score_map::$jdjc_zdf =>
        'SUM(' . Jiancha_and_jiangduo_gr_score_map::$jcjd_zdf . ')',
    Quantity_sub_score_map::$dd_name => Jiancha_and_jiangduo_gr_score_map::$dd_name

];

HZ_formula::$hz_sub_2_gr = [
    Quantity_gr_score_map::$hzdc_zdf_weighed => Formula::mul([
        Quantity_sub_score_map::$hzdc_zdf,
        Quantity_gr_coef_map::$hzdc_coef
    ]),
    Quantity_gr_score_map::$xzcf_zdf_weighed => Formula::mul([
        Quantity_sub_score_map::$xzcf_zdf,
        Quantity_gr_coef_map::$xzcf_coef
    ]),
    Quantity_gr_score_map::$jdjc_zdf_weighed => Formula::mul([
        Quantity_sub_score_map::$jdjc_zdf,
        Quantity_gr_coef_map::$jdjc_coef
    ]),
    Quantity_gr_score_map::$jsys_zdf_weighed => Formula::mul([
        Quantity_sub_score_map::$jsys_zdf,
        Quantity_gr_coef_map::$jsys_coef
    ])
];

HZ_formula::$hz_sub_2_gr[Quantity_gr_score_map::$zfsl_total_score] = Formula::plus([
    HZ_formula::$hz_sub_2_gr[Quantity_gr_score_map::$hzdc_zdf_weighed],
    HZ_formula::$hz_sub_2_gr[Quantity_gr_score_map::$jsys_zdf_weighed],
    HZ_formula::$hz_sub_2_gr[Quantity_gr_score_map::$jdjc_zdf_weighed],
    HZ_formula::$hz_sub_2_gr[Quantity_gr_score_map::$xzcf_zdf_weighed]
]);


/*HZ_formula::$xzcf_2_gr = [

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
];*/


class HZ_group extends Table_group
{
    /**
     * @param mysqli|Sql_tool $db
     * @param string $name
     * @param string $date
     * @return bool
     */
    public static function is_row_ext($db, $name, $date)
    {
        return parent::_is_row_ext(
            $db, Quantity_sub_score_map::$table_name, $name, $date
        );
    }

    static public function update_xzcf($db, $xzcf_table_param, $hz_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Quantity_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Quantity_xzcf_gr_sub_score_map::$xzcf_zdf . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Quantity_xzcf_gr_sub_score_map::$table_name
                    . $xzcf_table_param . ') A'
                ],
                [
                    Quantity_sub_score_map::$xzcf_zdf => 'A.res'
                ],
                $hz_table_param
            );
    }

    static public function update_hzdc($db, $hzdc_table_param, $hz_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Quantity_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Quantity_hzdc_gr_sub_score_map::$table_name
                    . $hzdc_table_param . ') A'
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                $hz_table_param
            );
    }

    static public function update_jsys($db, $jsys_table_param, $hz_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Quantity_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Jianshenyanshou_gr_score_map::$jsys_zdf . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Jianshenyanshou_gr_score_map::$table_name
                    . $jsys_table_param . ') A'
                ],
                [
                    Quantity_sub_score_map::$jsys_zdf => 'A.res'
                ],
                $hz_table_param
            );
    }

    static public function update_jdjc($db, $jdjc_table_param, $hz_table_param)
    {
        $sqlTool = parent::sqlTool_build($db);

        return (new Table(Quantity_sub_score_map::$table_name, $sqlTool))
            ->union_update(
                [
                    "(SELECT 
                    ifnull(SUM(" . Jiancha_and_jiangduo_gr_score_map::$jcjd_zdf . "),0) 
                    AS res , police_name,year_month_show FROM " .
                    Jiancha_and_jiangduo_gr_score_map::$table_name
                    . $jdjc_table_param . ') A'
                ],
                [
                    Quantity_sub_score_map::$jdjc_zdf => 'A.res'
                ],
                $hz_table_param
            );
    }

    static public function update_xzcf_by_date($db, $date = null)
    {
        return self::update_xzcf(
            $db,
            parent::format_date(
                Quantity_xzcf_gr_sub_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Quantity_xzcf_gr_sub_score_map::$year_month_show,
                Quantity_xzcf_gr_sub_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    static public function update_hzdc_by_date($db, $date)
    {
        return self::update_hzdc(
            $db,
            parent::format_date(
                Quantity_hzdc_gr_sub_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Quantity_hzdc_gr_sub_score_map::$year_month_show,
                Quantity_hzdc_gr_sub_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    static public function update_jdjc_by_date($db, $date)
    {
        return self::update_jdjc(
            $db,
            parent::format_date(
                Jiancha_and_jiangduo_gr_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Jiancha_and_jiangduo_gr_score_map::$year_month_show,
                Jiancha_and_jiangduo_gr_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    static public function update_jsys_by_date($db, $date)
    {
        return self::update_jsys(
            $db,
            parent::format_date(
                Jianshenyanshou_gr_score_map::$year_month_show,
                $date
            ) .
            Sql_tool::GROUP([
                Jianshenyanshou_gr_score_map::$year_month_show,
                Jianshenyanshou_gr_score_map::$police_name
            ]),
            Sql_tool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ], false)
        );
    }

    /**
     * 此函数用于更新quantity_sub_table以及quantity_gr_table的xzcf项（非更新xzcf相关的子表）
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     * @internal param quantity_gr_table的Table实例 $sub_table
     */
    static public function update_xzcf_item($mysqli, $police_name, $date, $row_check = false)
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

        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::update_xzcf_item($db, $police_name, $date);
            }
        }
        return (new Table(Quantity_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_xzcf_gr_sub_score_map::$xzcf_zdf . "),0) AS res ,
                     police_name,year_month_show FROM " . Quantity_xzcf_gr_sub_score_map::$table_name .
                    Sql_tool::WHERE([
                        Quantity_xzcf_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xzcf_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Quantity_sub_score_map::$xzcf_zdf => 'A.res'
                ],
                Sql_tool::WHERE([
                    Quantity_sub_score_map::$year_month_show => $date,
                    Quantity_sub_score_map::$police_name => $police_name
                ], true)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static public function update_hzdc_item($mysqli, $police_name, $date, $row_check = false)
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
        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::insert_hzdc_item($db, $police_name, $date);
            }
        }
        return (new Table(Quantity_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Quantity_hzdc_gr_sub_score_map::$hzdcs_sub_score . "),0)  
                    AS res , police_name, year_month_show FROM 
                    " . Quantity_hzdc_gr_sub_score_map::$table_name .
                    Sql_tool::WHERE([
                        Quantity_hzdc_gr_sub_score_map::$police_name => $police_name,
                        Quantity_hzdc_gr_sub_score_map::$year_month_show => $date
                    ]) . ' ) A '
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                Sql_tool::WHERE([
                    Quantity_sub_score_map::$year_month_show => $date,
                    Quantity_sub_score_map::$police_name => $police_name
                ], true)
            );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static public function update_jdjc_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::insert_jdjc_item($db, $police_name, $date);
            }
        }
        return (new Table(Quantity_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Jiancha_and_jiangduo_gr_score_map::$jcjd_zdf . "),0) 
                    AS res , police_name, year_month_show FROM 
                    " . Jiancha_and_jiangduo_gr_score_map::$table_name .
                    Sql_tool::WHERE([
                        Jiancha_and_jiangduo_gr_score_map::$police_name => $police_name,
                        Jiancha_and_jiangduo_gr_score_map::$year_month_show => $date
                    ]) . ' ) A '
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                Sql_tool::WHERE([
                    Quantity_sub_score_map::$year_month_show => $date,
                    Quantity_sub_score_map::$police_name => $police_name
                ], true)
            );
    }


    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string $date
     * @param bool $row_check
     * @return int
     */
    static public function update_jsys_item($mysqli, $police_name, $date, $row_check = false)
    {
        $db = Sql_tool::build_by_mysqli($mysqli);

        if ($row_check) {
            if (!self::is_row_ext($db, $police_name, $date)) {
                return self::insert_jsys_item($db, $police_name, $date);
            }
        }
        return (new Table(Quantity_sub_score_map::$table_name, $db))
            ->union_update(
                [
                    "(SELECT ifnull(SUM(" . Jianshenyanshou_gr_score_map::$jsys_zdf . "),0) 
                    AS res , police_name, year_month_show FROM 
                    " . Jianshenyanshou_gr_score_map::$table_name .
                    Sql_tool::WHERE([
                        Jianshenyanshou_gr_score_map::$police_name => $police_name,
                        Jianshenyanshou_gr_score_map::$year_month_show => $date
                    ]) . ' ) A '
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                Sql_tool::WHERE([
                    Quantity_sub_score_map::$year_month_show => $date,
                    Quantity_sub_score_map::$police_name => $police_name
                ], true)
            );
    }


    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_hzdc($mysqli, $param = '')
    {
        return (new Table(Quantity_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))->union_insert(
            [
                Quantity_hzdc_gr_sub_score_map::$table_name,
            ],
            HZ_formula::$hzdc_2_sub,
            $param . Sql_tool::GROUP([
                Quantity_hzdc_gr_sub_score_map::$year_month_show,
                Quantity_hzdc_gr_sub_score_map::$police_name
            ])
        );
    }

    static function insert_hzdc_by_date($mysqli, $date)
    {
        return self::insert_hzdc(
            $mysqli,
            parent::format_date(Quantity_hzdc_gr_sub_score_map::$year_month_show, $date)
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_xzcf($mysqli, $param = '')
    {
        return (new Table(Quantity_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xzcf_gr_sub_score_map::$table_name
                ],
                HZ_formula::$xzcf_2_sub,
                $param . Sql_tool::GROUP([
                    Quantity_xzcf_gr_sub_score_map::$year_month_show,
                    Quantity_xzcf_gr_sub_score_map::$police_name
                ])
            );
    }

    static function insert_xzcf_by_date($mysqli, $date)
    {
        return self::insert_xzcf(
            $mysqli,
            parent::format_date(Quantity_xzcf_gr_sub_score_map::$year_month_show, $date)
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_jsys($mysqli, $param = '')
    {
        return (new Table(Quantity_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Jianshenyanshou_gr_score_map::$table_name
                ],
                HZ_formula::$jsys_2_sub,
                $param . Sql_tool::GROUP([
                    Jianshenyanshou_gr_score_map::$year_month_show,
                    Jianshenyanshou_gr_score_map::$police_name
                ])
            );
    }

    static function insert_jsys_by_date($mysqli, $date)
    {
        return self::insert_jsys(
            $mysqli,
            parent::format_date(Jianshenyanshou_gr_score_map::$year_month_show, $date)
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_jdjc($mysqli, $param = '')
    {
        return (new Table(Quantity_sub_score_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Jiancha_and_jiangduo_gr_score_map::$table_name
                ],
                HZ_formula::$jdjc_2_sub,
                $param . Sql_tool::GROUP([
                    Jiancha_and_jiangduo_gr_score_map::$year_month_show,
                    Jiancha_and_jiangduo_gr_score_map::$police_name
                ])
            );
    }

    static function insert_jdjc_by_date($mysqli, $date)
    {
        return self::insert_jdjc(
            $mysqli,
            parent::format_date(Jiancha_and_jiangduo_gr_score_map::$year_month_show, $date)
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string|array $date
     * @return mixed
     */
    static function insert_hzdc_item($mysqli, $police_name, $date)
    {

        return self::insert_hzdc($mysqli,
//            SqlTool::WHERE(
//                [
//                    Quantity_hzdc_gr_sub_score_map::$police_name => $police_name,
//                    Quantity_hzdc_gr_sub_score_map::$year_month_show => $date
//                ]
//            )
            parent::format_date(Quantity_hzdc_gr_sub_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Quantity_hzdc_gr_sub_score_map::$police_name => $police_name])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string|array $date
     * @return int
     */
    static function insert_xzcf_item($mysqli, $police_name, $date)
    {
        return self::insert_xzcf(
            $mysqli,
//            SqlTool::WHERE([
//                Quantity_xzcf_gr_sub_score_map::$police_name => $police_name,
//                Quantity_xzcf_gr_sub_score_map::$year_month_show => $date
//            ])
            parent::format_date(Quantity_xzcf_gr_sub_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Quantity_xzcf_gr_sub_score_map::$police_name => $police_name])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string|array $date
     * @return int
     */
    static function insert_jdjc_item($mysqli, $police_name, $date)
    {
        return self::insert_jdjc(
            $mysqli,
//            SqlTool::WHERE([
//                Jiancha_and_jiangduo_gr_score_map::$police_name => $police_name,
//                Jiancha_and_jiangduo_gr_score_map::$year_month_show => $date
//            ])
            parent::format_date(Jiancha_and_jiangduo_gr_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Jiancha_and_jiangduo_gr_score_map::$police_name => $police_name])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $police_name
     * @param string|array $date
     * @return int
     */
    static function insert_jsys_item($mysqli, $police_name, $date)
    {
        return self::insert_jsys(
            $mysqli,
//            SqlTool::WHERE([
//                Jianshenyanshou_gr_score_map::$police_name => $police_name,
//                Jianshenyanshou_gr_score_map::$year_month_show => $date
//            ])
            parent::format_date(Jianshenyanshou_gr_score_map::$year_month_show, $date)
            . Sql_tool::ANDC([Jianshenyanshou_gr_score_map::$police_name => $police_name])
        );
    }


    /**
     * @param mysqli|Sql_tool $db
     * @param null|string|array $date
     */
    public static function hz_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [new Table(Quantity_sub_score_map::$table_name, $sqlTool)];

        if (!$date) {
            array_push(
                $tables,
                new Table(Quantity_gr_score_map::$table_name, $sqlTool)
            );
        }

        parent::group_clear(
            $tables,
            'year_month_show',
            $date
        );
    }

    public static function hz_update_sub_2_gr_by_date($db, $date = null)
    {
        $sqltool = parent::sqlTool_build($db);
        return (new Table(Quantity_gr_score_map::$table_name, $sqltool))
            ->union_update(
                [
                    Quantity_sub_score_map::$table_name,
                    Quantity_gr_coef_map::$table_name
                ],
                HZ_formula::$hz_sub_2_gr,
                Sql_tool::WHERE([
                    Quantity_gr_score_map::$number_id => Quantity_sub_score_map::$number_id
                ], false) .
                parent::format_date(
                    Quantity_sub_score_map::$year_month_show,
                    $date,
                    true
                )
            );
    }

    /**
     * @param mysqli $mysqli
     * @param null|string|array $date
     * @param $task
     */
    public static function group_insert($mysqli, $date = null)
    {

        $sqlTool = Sql_tool::build_by_mysqli($mysqli);

        $sqlTool->do_not_gone_away();

        Sql_tool::devopen();

        self::hz_clear($sqlTool, $date);

        $afr = self::insert_hzdc(
            $mysqli,
            parent::format_date(
                Quantity_hzdc_gr_sub_score_map::$year_month_show,
                $date
            )
        );

        echo "      *hzdc finished , affect rows : $afr | ";


        $afr = self::insert_xzcf(
            $mysqli,
            parent::format_date(
                Quantity_xzcf_gr_sub_score_map::$year_month_show,
                $date
            )
        );

        echo "*xzcf finished , affect rows : $afr | ";


        $afr = self::insert_jsys(
            $mysqli,
            parent::format_date(
                Jianshenyanshou_gr_score_map::$year_month_show,
                $date
            )
        );

        echo "*jsys finished , affect rows : $afr | ";


        $afr = self::insert_jdjc(
            $mysqli,
            parent::format_date(
                Jiancha_and_jiangduo_gr_score_map::$year_month_show,
                $date
            )
        );

        echo "*jdjc finished , affect rows : $afr\n";


        $hz_table = (new Table(Quantity_sub_score_map::$table_name, $sqlTool));

        $res = $hz_table
            ->group_query(
                [
                    Sql_tool::SUM(Quantity_sub_score_map::$jdjc_zdf) => 'jdjc',
                    Sql_tool::SUM(Quantity_sub_score_map::$jsys_zdf) => 'jsys',
                    Sql_tool::SUM(Quantity_sub_score_map::$hzdc_zdf) => 'hzdc',
                    Sql_tool::SUM(Quantity_sub_score_map::$xzcf_zdf) => 'xzcf',
                    Quantity_sub_score_map::$police_name => 'n',
                    Quantity_sub_score_map::$year_month_show => 'y',
                    Quantity_sub_score_map::$dd_name => 'd'
                ],
                [
                    Quantity_sub_score_map::$police_name,
                    Quantity_sub_score_map::$year_month_show,
                ],
                parent::format_date(
                    Quantity_sub_score_map::$year_month_show,
                    $date,
                    true
                )
            );


//        $sqlTool::$isDev = false;

        self::hz_clear($sqlTool, $date);

        Sql_tool::devclose();

        echo 'HZ : insert finished' . "\n";

        $sql = '';

        $res->each_row(function ($row) use (&$sql) {
            $sql .= ',(' . $row['jdjc'] . ',' .
                $row['jsys'] . ',' .
                $row['hzdc'] . ',' .
                $row['xzcf'] . ',' .
                Sql_tool::QUOTE($row['n']) . ',' .
                Sql_tool::QUOTE($row['y']) . ',' .
                Sql_tool::QUOTE($row['d']) . ')';
        });

        if ($sql != '')
            $hz_table->multi_insert(
                [
                    Quantity_sub_score_map::$jdjc_zdf,
                    Quantity_sub_score_map::$jsys_zdf,
                    Quantity_sub_score_map::$hzdc_zdf,
                    Quantity_sub_score_map::$xzcf_zdf,
                    Quantity_sub_score_map::$police_name,
                    Quantity_sub_score_map::$year_month_show,
                    Quantity_sub_score_map::$dd_name,
                ],
                substr($sql, 1)
            );

        return;

//        echo 'insert_hzdc finished';
//
//        $jsys = new Table(Jianshenyanshou_gr_score_map::$table_name, $sqlTool);
//        $jcdw = new Table(Jiancha_and_jiangduo_gr_score_map::$table_name, $sqlTool);
//        $xzcf = new Table(Quantity_xzcf_gr_sub_score_map::$table_name, $sqlTool);
//
//        $res = $jsys->group_query(
//            [
//                Jianshenyanshou_gr_score_map::$police_name => 'n',
//                Jianshenyanshou_gr_score_map::$year_month_show => 'd',
//            ],
//            [
//                Jianshenyanshou_gr_score_map::$year_month_show,
//                Jianshenyanshou_gr_score_map::$police_name
//            ],
//            parent::format_date(Jianshenyanshou_gr_score_map::$year_month_show, $date)
//        );
//
//        $res->each_row(function ($row) use ($mysqli) {
//            self::update_jsys_item($mysqli, $row['n'], $row['d'], true);
//        });
//
//        echo 'insert_jsys finished';
//
//
//        $res = $xzcf->group_query(
//            [
//                Quantity_xzcf_gr_sub_score_map::$police_name => 'n',
//                Quantity_xzcf_gr_sub_score_map::$year_month_show => 'd',
//            ],
//            [
//                Quantity_xzcf_gr_sub_score_map::$year_month_show,
//                Quantity_xzcf_gr_sub_score_map::$police_name
//            ],
//            parent::format_date(Quantity_xzcf_gr_sub_score_map::$year_month_show, $date)
//        );
//
//        $res->each_row(function ($row) use ($mysqli) {
//            self::update_xzcf_item($mysqli, $row['n'], $row['d'], true);
//        });
//
//        echo 'insert_xzcf finished';
//
//
//        $res = $jcdw->group_query(
//            [
//                Jiancha_and_jiangduo_gr_score_map::$police_name => 'n',
//                Jiancha_and_jiangduo_gr_score_map::$year_month_show => 'd',
//            ],
//            [
//                Jiancha_and_jiangduo_gr_score_map::$year_month_show,
//                Jiancha_and_jiangduo_gr_score_map::$police_name
//            ],
//            parent::format_date(Jiancha_and_jiangduo_gr_score_map::$year_month_show, $date)
//        );
//
//        $res->each_row(function ($row) use ($mysqli) {
//            self::update_jdjc_item($mysqli, $row['n'], $row['d'], true);
//        });
//
//        echo 'insert_jcdw finished';


    }


    /**
     * 汇总表的行政处罚分项更新
     * @param mysqli $mysqli
     * @param null|string|array $date
     * @param bool $update_dd
     * @return int
     */
    public static function xzcf_group_update($mysqli, $date = null, $update_dd = true)
    {
        XZCF_group::group_update_date_in($mysqli, $date);
        HZ_group::update_xzcf_by_date($mysqli, $date);
        if ($update_dd) HZ_group::dd_huizong_query_update($mysqli, $date);
        return 1;
    }


    //TODO:性能出现问题，目前3万数据需要8分钟时间更新，暂时使用手动sql进行查询，速度需要优化
    public static function dd_huizong_query_update($mysqli, $date = null)
    {
        return (new Table(Dadui_huizong_query_day_map::$table_name, Table_group::sqlTool_build($mysqli)))->dml(

            "UPDATE dadui_huizong_query_day
                  LEFT JOIN quantity_gr_score ON
                  dadui_huizong_query_day.year_month_show = quantity_gr_score.year_month_show 
                  AND
                  dadui_huizong_query_day.police_name = quantity_gr_score.police_name
SET dadui_huizong_query_day.quantity_score  = quantity_gr_score.zfsl_total_score,
  dadui_huizong_query_day.weighted_total_score = (
    dadui_huizong_query_day.capacity_score + 
    dadui_huizong_query_day.quality_score +
    quantity_gr_score.zfsl_total_score + 
    dadui_huizong_query_day.efficiency_score +
    dadui_huizong_query_day.effect_score)
WHERE 1 = 1  " . Table_group::format_date(
                Quantity_gr_score_map::$year_month_show,
                $date,
                true
            )

        );
//            ->union_update(
//                [Quantity_gr_score_map::$table_name],
//                [
//                    Dadui_huizong_query_day_map::$quantity_score
//                    =>
//                        Quantity_gr_score_map::$zfsl_total_score,
//                    Dadui_huizong_query_day_map::$weighted_total_score
//                    =>
//                        Formula::plus([
//                            Dadui_huizong_query_day_map::$capacity_score,
//                            Dadui_huizong_query_day_map::$quantity_score,
////                            Dadui_huizong_query_day_map::$quality_score,
//                            Quantity_gr_score_map::$zfsl_total_score,
//                            Dadui_huizong_query_day_map::$efficiency_score,
//                            Dadui_huizong_query_day_map::$effect_score
//                        ])
//                ],
//                Sql_tool::WHERE([
//                    Dadui_huizong_query_day_map::$year_month_show
//                    =>
//                        Quantity_gr_score_map::$year_month_show,
//                    Dadui_huizong_query_day_map::$police_name
//                    =>
//                        Quantity_gr_score_map::$police_name
//                ], false) . Table_group::format_date(
//                    Quantity_gr_score_map::$year_month_show,
//                    $date,
//                    true
//                )
//            );
    }

    /**
     * 汇总表的行政处罚分项更新
     * @param mysqli $mysqli
     * @param null|string|array $date
     * @param bool $update_dd
     * @return int
     */
    public static function hzdc_group_update($mysqli, $date = null, $update_dd = true)
    {
        HZDC_group::group_update_date_in($mysqli, $date);
        HZ_group::update_hzdc_by_date($mysqli, $date);
        if ($update_dd) HZ_group::dd_huizong_query_update($mysqli, $date);
        return 1;
    }

    /**
     * 汇总表的监督检查分项更新
     * @param mysqli $mysqli
     * @param null|string|array $date
     * @param bool $update_dd
     * @return int
     */
    public static function jdjc_group_update($mysqli, $date = null, $update_dd = true)
    {
        JDJC_group::group_update($mysqli, $date);
        HZ_group::update_jdjc_by_date($mysqli, $date);
        if ($update_dd) HZ_group::dd_huizong_query_update($mysqli, $date);
        return 1;
    }

    /**
     * 汇总表的建审验收分项更新
     * @param mysqli $mysqli
     * @param null|string|array $date
     * @param bool $update_dd
     * @return int
     */
    public static function jsys_group_update($mysqli, $date = null, $update_dd = true)
    {
        JSYS_group::group_update($mysqli, $date);
        HZ_group::update_jsys_by_date($mysqli, $date);
        if ($update_dd) HZ_group::dd_huizong_query_update($mysqli, $date);
        return 1;
    }

    /**
     * 汇总表全部分项更新
     * @param mysqli $mysqli
     * @param null|string|array $date
     * @return int|void
     */
    public static function group_update($mysqli, $date = null)
    {
        self::jdjc_group_update($mysqli, $date, false);
        self::jsys_group_update($mysqli, $date, false);
        self::hzdc_group_update($mysqli, $date, false);
        self::xzcf_group_update($mysqli, $date, false);
        self::hz_update_sub_2_gr_by_date($mysqli, $date);
        self::dd_huizong_query_update($mysqli, $date);
        return 1;
    }


}