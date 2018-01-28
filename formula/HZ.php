<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/19
 * Time: 下午6:43
 */

require_once __DIR__ . '/Formula.class.php';
require_once __DIR__ . '/Table_gropu.interface.php';
require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../map/Quantity_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_gr_score.map.php';
require_once __DIR__ . '/../map/Quantity_gr_coef.map.php';
require_once __DIR__ . '/../map/Quantity_xzcf_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Quantity_hzdc_gr_sub_score.map.php';
require_once __DIR__ . '/../map/Jianshenyanshou_gr_score.map.php';
require_once __DIR__ . '/../map/Jiancha_and_jiangduo_gr_score.map.php';


class HZ_formula extends Formula
{
//    static $xzcf_2_gr;

    static $hzdc_2_sub;

    static $xzcf_2_sub;

    static $jsys_2_sub;

    static $jdjc_2_sub;

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
    Quantity_sub_score_map::$jsys_zdf =>
        'SUM(' . Jiancha_and_jiangduo_gr_score_map::$jcjd_zdf . ')',
    Quantity_sub_score_map::$dd_name => Jiancha_and_jiangduo_gr_score_map::$dd_name

];


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
     * @param mysqli|SqlTool $db
     * @param string $name
     * @param string $date
     * @return bool
     */
    public static function is_row_ext($db, $name, $date)
    {
        return parent::is_row_ext(
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

    static public function update_xzcf_by_date($db, $date)
    {
        return self::update_xzcf(
            $db,
            parent::format_date(
                Quantity_xzcf_gr_sub_score_map::$year_month_show,
                $date
            ) .
            SqlTool::GROUP([
                Quantity_xzcf_gr_sub_score_map::$year_month_show,
                Quantity_xzcf_gr_sub_score_map::$police_name
            ]),
            SqlTool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ])
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
            SqlTool::GROUP([
                Quantity_hzdc_gr_sub_score_map::$year_month_show,
                Quantity_hzdc_gr_sub_score_map::$police_name
            ]),
            SqlTool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ])
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
            SqlTool::GROUP([
                Jiancha_and_jiangduo_gr_score_map::$year_month_show,
                Jiancha_and_jiangduo_gr_score_map::$police_name
            ]),
            SqlTool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ])
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
            SqlTool::GROUP([
                Jianshenyanshou_gr_score_map::$year_month_show,
                Jianshenyanshou_gr_score_map::$police_name
            ]),
            SqlTool::WHERE([
                Quantity_sub_score_map::$year_month_show => 'A.year_month_show',
                Quantity_sub_score_map::$police_name => 'A.police_name',
            ])
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

        $db = SqlTool::build_by_mysqli($mysqli);

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
                    SqlTool::WHERE([
                        Quantity_xzcf_gr_sub_score_map::$year_month_show => $date,
                        Quantity_xzcf_gr_sub_score_map::$police_name => $police_name
                    ]) . ') A'
                ],
                [
                    Quantity_sub_score_map::$xzcf_zdf => 'A.res'
                ],
                SqlTool::WHERE([
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
        $db = SqlTool::build_by_mysqli($mysqli);

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
                    SqlTool::WHERE([
                        Quantity_hzdc_gr_sub_score_map::$police_name => $police_name,
                        Quantity_hzdc_gr_sub_score_map::$year_month_show => $date
                    ]) . ' ) A '
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                SqlTool::WHERE([
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
        $db = SqlTool::build_by_mysqli($mysqli);

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
                    SqlTool::WHERE([
                        Jiancha_and_jiangduo_gr_score_map::$police_name => $police_name,
                        Jiancha_and_jiangduo_gr_score_map::$year_month_show => $date
                    ]) . ' ) A '
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                SqlTool::WHERE([
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
        $db = SqlTool::build_by_mysqli($mysqli);

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
                    SqlTool::WHERE([
                        Jianshenyanshou_gr_score_map::$police_name => $police_name,
                        Jianshenyanshou_gr_score_map::$year_month_show => $date
                    ]) . ' ) A '
                ],
                [
                    Quantity_sub_score_map::$hzdc_zdf => 'A.res'
                ],
                SqlTool::WHERE([
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
        return (new Table(Quantity_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))->union_insert(
            [
                Quantity_hzdc_gr_sub_score_map::$table_name,
            ],
            HZ_formula::$hzdc_2_sub,
            $param . SqlTool::GROUP([
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
        return (new Table(Quantity_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Quantity_xzcf_gr_sub_score_map::$table_name
                ],
                HZ_formula::$xzcf_2_sub,
                $param . SqlTool::GROUP([
                    Quantity_xzcf_gr_sub_score_map::$year_month_show,
                    Quantity_xzcf_gr_sub_score_map::$police_name
                ])
            );
    }

    static function insert_xzcf_by_date($mysqli, $date)
    {
        return self::insert_hzdc(
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
        return (new Table(Quantity_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Jianshenyanshou_gr_score_map::$table_name
                ],
                HZ_formula::$jsys_2_sub,
                $param . SqlTool::GROUP([
                    Jianshenyanshou_gr_score_map::$year_month_show,
                    Jianshenyanshou_gr_score_map::$police_name
                ])
            );
    }

    static function insert_jsys_by_date($mysqli, $date)
    {
        return self::insert_hzdc(
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
        return (new Table(Quantity_sub_score_map::$table_name, SqlTool::build_by_mysqli($mysqli)))
            ->union_insert(
                [
                    Jiancha_and_jiangduo_gr_score_map::$table_name
                ],
                HZ_formula::$jdjc_2_sub,
                $param . SqlTool::GROUP([
                    Jiancha_and_jiangduo_gr_score_map::$year_month_show,
                    Jiancha_and_jiangduo_gr_score_map::$police_name
                ])
            );
    }

    static function insert_jdjc_by_date($mysqli, $date)
    {
        return self::insert_hzdc(
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
            . SqlTool::ANDC([Quantity_hzdc_gr_sub_score_map::$police_name => $police_name])
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
            . SqlTool::ANDC([Quantity_xzcf_gr_sub_score_map::$police_name => $police_name])
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
            . SqlTool::ANDC([Jiancha_and_jiangduo_gr_score_map::$police_name => $police_name])
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
            . SqlTool::ANDC([Jianshenyanshou_gr_score_map::$police_name => $police_name])
        );
    }


    /**
     * @param mysqli|SqlTool $db
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
            Jiancha_and_jiangduo_gr_nbr_map::$year_month_show,
            $date
        );
    }


    /**
     * @param mysqli $mysqli
     * @param null|string|array $date
     */
    public static function group_insert($mysqli, $date = null)
    {

        $sqlTool = SqlTool::build_by_mysqli($mysqli);
        self::hz_clear($sqlTool, $date);
        self::insert_hzdc(
            $mysqli,
            parent::format_date(
                Quantity_hzdc_gr_sub_score_map::$year_month_show,
                $date
            )
        );

        $jsys = new Table(Jianshenyanshou_gr_score_map::$table_name, $sqlTool);
        $jcdw = new Table(Jiancha_and_jiangduo_gr_score_map::$table_name, $sqlTool);
        $xzcf = new Table(Quantity_xzcf_gr_sub_score_map::$table_name, $sqlTool);

        $res = $jsys->group_query(
            [
                Jianshenyanshou_gr_score_map::$police_name => 'n',
                Jianshenyanshou_gr_score_map::$year_month_show => 'd',
            ],
            [
                Jianshenyanshou_gr_score_map::$year_month_show,
                Jianshenyanshou_gr_score_map::$police_name
            ],
            parent::format_date(Jianshenyanshou_gr_score_map::$year_month_show, $date)
        );

        $res->each_row(function ($row) use ($mysqli) {
            self::update_jsys_item($mysqli, $row['n'], $row['d'], true);
        });


        $res = $xzcf->group_query(
            [
                Quantity_xzcf_gr_sub_score_map::$police_name => 'n',
                Quantity_xzcf_gr_sub_score_map::$year_month_show => 'd',
            ],
            [
                Quantity_xzcf_gr_sub_score_map::$year_month_show,
                Quantity_xzcf_gr_sub_score_map::$police_name
            ],
            parent::format_date(Quantity_xzcf_gr_sub_score_map::$year_month_show, $date)
        );

        $res->each_row(function ($row) use ($mysqli) {
            self::update_xzcf_item($mysqli, $row['n'], $row['d'], true);
        });

        $res = $jcdw->group_query(
            [
                Jiancha_and_jiangduo_gr_score_map::$police_name => 'n',
                Jiancha_and_jiangduo_gr_score_map::$year_month_show => 'd',
            ],
            [
                Jiancha_and_jiangduo_gr_score_map::$year_month_show,
                Jiancha_and_jiangduo_gr_score_map::$police_name
            ],
            parent::format_date(Jiancha_and_jiangduo_gr_score_map::$year_month_show, $date)
        );

        $res->each_row(function ($row) use ($mysqli) {
            self::update_jdjc_item($mysqli, $row['n'], $row['d'], true);
        });

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