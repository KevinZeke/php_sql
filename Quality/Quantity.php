<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/2
 * Time: 15:31
 */

require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../common/common.php';
require_once __DIR__ . '/../Quantity/Table_gropu.php';
require_once __DIR__ . '/../map/Zfzl_hz.map.php';
require_once __DIR__ . '/../map/Zfzl_hzdc_score.map.php';
require_once __DIR__ . '/../map/Zfzl_jdjc_score.map.php';
require_once __DIR__ . '/../map/Zfzl_xzcf_score.map.php';
require_once __DIR__ . '/../map/Zfzl_bacc_score.map.php';
require_once __DIR__ . '/../map/Zfzl_jsys_score.map.php';


class Quantity extends Table_group
{

    public static $hzdc_2_quantity;

    public static $xzcf_2_quantity;

    public static $jsys_2_quantity;

    public static $jdjc_2_quantity;

    public static $bacc_2_quantity;


    public static $coef = null;

    /**
     * @var string
     */
    public static $kpld_prefix = '\'kpdf_\'';

    public static $police_dd_map = null;

    public function format_hzdc_flws_func(&$result_array, $row)
    {
        if (!array_key_exists($row[Q_field::$director], $result_array)) {
            $result_array[$row[Q_field::$director]] = [];
        }
        //判断该人的项目列表中是否存在该项目，无则创建该项目键值对，并将结束时间加入该数组
        if (!array_key_exists(
            $row[Q_field::$taskId],
            $result_array[$row[Q_field::$director]]
        )) {
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]] = [];
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_type]
                = $row[Q_field::$hz_type];
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score]
                = 0;
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$flwses] = [];
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$count_flwses] = 0;
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_now_status]
                = $row[Q_field::$hz_now_status];

            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_fire_object]
                = $row[Q_field::$hz_fire_object];

            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_fire_addr]
                = $row[Q_field::$hz_fire_addr];

            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_call_time]
                = $row[Q_field::$hz_call_time];

            if (array_key_exists(Q_field::$hz_end_date, $row))
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_end_date]
                    = $row[Q_field::$hz_end_date];

            if (array_key_exists(Q_field::$old_taskId, $row)) {
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$old_taskId]
                    = $row[Q_field::$old_taskId];
            }

            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_handel_date]
                = $row[Q_field::$hz_handel_date];

            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$hz_complete_date]
                = $row[Q_field::$hz_complete_date];

        }
        //将当前行的法律文书添加进入该结果
        $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score]
            += $row[Q_field::$ws_total_score];
//        $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$real_item_total_score] =
//            Quantity::coef_count(
//                'hzdc',
//                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score],
//                $row[Q_field::$hz_type]
//            );
        array_push(
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$flwses],
            new Flws(
                $row[Q_field::$flws_id],
                $row[Q_field::$ws_total_score],
                $row[Q_field::$kpld_table]
            )
        );

        $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$count_flwses]++;

        return true;
    }

    /**
     * @param array $result_array
     * @param $item_type
     * @param $xzcf_coef
     * @return Closure
     */
    public static function format_item_flws_func(&$result_array, $item_type)
    {
        return function ($row) use (&$result_array, $item_type) {
//            if (!$row[Q_field::$kpld]) return;

            //可能存在的项目类型变量，用于权重计算
            $pro_type = '';

            //判断结果数组是否存在该（主办人协办人），无则创建该人键值对
            if ($item_type == 'hzdc') return self::format_hzdc_flws_func($result_array, $row);
            if (!array_key_exists($row[Q_field::$director], $result_array)) {
                $result_array[$row[Q_field::$director]] = [];
            }
            //判断该人的项目列表中是否存在该项目，无则创建该项目键值对，并将结束时间加入该数组
            if (!array_key_exists(
                $row[Q_field::$taskId],
                $result_array[$row[Q_field::$director]]
            )) {
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]] = [];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$over_time]
                    = $row[Q_field::$over_time];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score]
                    = 0;
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$flwses] = [];
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$count_flwses] = 0;
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$status]
                    = $row[Q_field::$status];

                //cj_time
                if (array_key_exists(Q_field::$cj_time, $row))
                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$cj_time]
                        = $row[Q_field::$cj_time];

                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$unit_name]
                    = $row[Q_field::$unit_name];

                //timeLimit
                if (array_key_exists(Q_field::$time_limit, $row))
                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$time_limit]
                        = $row[Q_field::$time_limit];

                //project_name
                if (array_key_exists(Q_field::$task_name, $row)) {
                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$task_name]
                        = $row[Q_field::$task_name];
                }

                //xm_result
                if (array_key_exists(Q_field::$xm_result, $row)) {
                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$xm_result]
                        = $row[Q_field::$xm_result];
                }

                //project_type
                if (array_key_exists(Q_field::$proeject_type, $row)) {
                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$proeject_type]
                        = $row[Q_field::$proeject_type];
                    $pro_type = $row[Q_field::$proeject_type];
                }
            }
            //将当前行的法律文书添加进入该结果
            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score]
                += $row[Q_field::$ws_total_score];
//            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$real_item_total_score] =
//                Quantity::coef_count(
//                    $item_type,
//                    $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$item_total_score],
//                    $pro_type
//                );
            array_push(
                $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$flwses],
                new Flws(
                    $row[Q_field::$flws_id],
                    $row[Q_field::$ws_total_score],
                    $row[Q_field::$kpld_table]
                )
            );

            $result_array[$row[Q_field::$director]][$row[Q_field::$taskId]][Q_field::$count_flwses]++;

            return true;
        };

    }

    /**
     * @param Sql_tool $sqltool
     * @param string $item_name
     * @return bool
     */
    public static function get_coef($sqltool, $item_name = '')
    {
        $sql = null;
//        switch ($item_name) {
//            case 'xzcf':
//                $sql = "SELECT xzcf,zbr,xbr FROM qz_zfzl";
//                break;
//            case 'jdjc':
//                $sql = "SELECT jdjc,zbr,xbr FROM qz_zfzl";
//                break;
//            default:
//                return false;
//                break;
//        }
        $sql = "SELECT * FROM qz_zfzl";
        $res = $sqltool->execute_dql_res($sql)->fetch();
        Quantity::$coef = $res;
        return $res;
    }

    public static function get_jdjc_xx_coef($project_type)
    {
        $xx_coef = 1;
        if ($project_type == '消防监督抽查') {
            $xx_coef = (double)self::$coef['rcjdjc'];
        } elseif ($project_type == '对举报、投诉的检查') {
            $xx_coef = (double)self::$coef['jbts'];
        } elseif ($project_type == '大型群众性活动举办前的检查') {
            $xx_coef = (double)self::$coef['jbq'];
        } elseif ($project_type == '建设工程施工工地检查') {
            $xx_coef = (double)self::$coef['sggd'];
        } elseif ($project_type == '派出所日常监督检查') {
            $xx_coef = (double)self::$coef['rcjdjc'];
        } elseif ($project_type == '其他检查') {
            $xx_coef = (double)self::$coef['other'];
        } elseif (
            $project_type == '责令限期改正复查' ||
            $project_type == '申请恢复施工、使用、生产、经营的检查' ||
            $project_type == '申请解除临时查封的检查' ||
            $project_type == '其他检查(复查)') {
            $xx_coef = (double)self::$coef['fc'];
        } elseif ($project_type == '公众聚集场所投入使用、营业前消防安全检查') {
            $xx_coef = (double)self::$coef['trsy'];
        }
        return $xx_coef;
    }

    /**
     * @param string $project_type
     * @return double
     */
    public static function get_hzdc_xx_coef($project_type)
    {
        if ($project_type == '一般' || $project_type == '一般调查') {
            return Quantity::$coef['ybdc'];
        } elseif ($project_type == '认定复核' || $project_type == '复核')
            return Quantity::$coef['rdfh'];
        return Quantity::$coef['jydc'];
    }

    /**
     * @param string $item_name
     * @param double $total_score
     * @param string $project_type
     * @return array|bool
     * @internal param float $coef
     */
    public static function coef_count($item_name, $total_score, $project_type = '')
    {
        switch ($item_name) {
            case 'xzcf':
//                $res = get_coef($sqltool, $item_name);
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'],
//                  'zhu' => $total_score * (double)$coef['xzcf'] * (double)$coef['zbr'],
                    'xie' => $total_score * (double)self::$coef['xbr']
//                  'xie' => $total_score * (double)$coef['xzcf'] * (double)$coef['xbr']
                ];
                return $score;
                break;
            case 'jdjc':
                $xx_coef = self::get_jdjc_xx_coef($project_type);
//                cmd_iconv($project_type);
                echo $xx_coef;
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'] * $xx_coef,
                    'xie' => $total_score * (double)self::$coef['xbr'] * $xx_coef
                ];
//                print_r($score);
                return $score;
                break;
            case 'hzdc':
                $xx_coef = self::get_hzdc_xx_coef($project_type);
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'] * $xx_coef,
                    'xie' => $total_score * (double)self::$coef['xbr'] * $xx_coef
                ];
                return $score;
            default:
                $score = [
                    'zhu' => $total_score * (double)self::$coef['zbr'],
                    'xie' => $total_score * (double)self::$coef['xbr']
                ];
                return $score;
                break;
        }
    }


    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_hzdc($mysqli, $param = '')
    {
        return (new Table(Zfzl_hz_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))->union_insert(
            [
                Zfzl_hzdc_score_map::$table_name,
            ],
            self::$hzdc_2_quantity,
            $param . Sql_tool::GROUP([
                Zfzl_hzdc_score_map::$OVERTIME,
                Zfzl_hzdc_score_map::$name
            ])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_xzcf($mysqli, $param = '')
    {
        return (new Table(Zfzl_hz_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))->union_insert(
            [
                Zfzl_xzcf_score_map::$table_name,
            ],
            self::$xzcf_2_quantity,
            $param . Sql_tool::GROUP([
                Zfzl_xzcf_score_map::$OVERTIME,
                Zfzl_xzcf_score_map::$name
            ])
        );
    }

    /**
     * @param mysqli $mysqli
     * @param string $param
     * @return mixed
     */
    static function insert_bacc($mysqli, $param = '')
    {
        return (new Table(Zfzl_hz_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))->union_insert(
            [
                Zfzl_bacc_score_map::$table_name,
            ],
            self::$bacc_2_quantity,
            $param . Sql_tool::GROUP([
                Zfzl_bacc_score_map::$overtime,
                Zfzl_bacc_score_map::$name
            ])
        );
    }

    public static function insert_jdjc($mysqli, $param)
    {
        return (new Table(Zfzl_hz_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))->union_insert(
            [
                Zfzl_jdjc_score_map::$table_name,
            ],
            self::$jdjc_2_quantity,
            $param . Sql_tool::GROUP([
                Zfzl_jdjc_score_map::$OVERTIME,
                Zfzl_jdjc_score_map::$name
            ])
        );
    }

    public static function insert_jsys($mysqli, $param)
    {
        return (new Table(Zfzl_hz_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))->union_insert(
            [
                Zfzl_jsys_score_map::$table_name,
            ],
            self::$jsys_2_quantity,
            $param . Sql_tool::GROUP([
                Zfzl_jsys_score_map::$OVERTIME,
                Zfzl_jsys_score_map::$name
            ])
        );
    }

    /**
     * @param mysqli|Sql_tool $db
     * @param null|string|array $date
     */
    public static function hz_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [new Table(Zfzl_hz_map::$table_name, $sqlTool)];

        parent::group_clear(
            $tables,
            Zfzl_hz_map::$SJ,
            $date
        );
    }

    public static function group_insert($mysqli, $date = null)
    {

        self::hz_clear($mysqli, $date);

        $afr = self::insert_hzdc(
            $mysqli,
            parent::format_date(
                Zfzl_hzdc_score_map::$OVERTIME,
                $date
            )
        );

        echo "      *hzdc finished , affect rows : $afr | ";

        $afr = self::insert_xzcf(
            $mysqli,
            parent::format_date(
                Zfzl_xzcf_score_map::$OVERTIME,
                $date
            )
        );

        echo "      *xzcf finished , affect rows : $afr | ";

        $afr = self::insert_jdjc(
            $mysqli,
            parent::format_date(
                Zfzl_jdjc_score_map::$OVERTIME,
                $date
            )
        );

        echo "      *jdjc finished , affect rows : $afr | ";

        $afr = self::insert_bacc(
            $mysqli,
            parent::format_date(
                Zfzl_bacc_score_map::$overtime,
                $date
            )
        );

        echo "      *bacc finished , affect rows : $afr | ";

        $afr = self::insert_jsys(
            $mysqli,
            parent::format_date(
                Zfzl_jsys_score_map::$OVERTIME,
                $date
            )
        );

        echo "      *jsys finished , affect rows : $afr | ";

        $sqlTool = Sql_tool::build_by_mysqli($mysqli);

        $coef = $sqlTool->execute_dql_res(
            'SELECT xzcf,jdjc,hzdc,bacc,jsys FROM `qz_zfzl`'
        )->fetch();

        $hz_table = (new Table(Zfzl_hz_map::$table_name, $sqlTool));

        $res = $hz_table
            ->group_query(
                [
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_jdjc) => 'jdjc_',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_jsys) => 'jsys_',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_hzdcc) => 'hzdc_',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_bacc) => 'bacc_',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_xzcf) => 'xzcf_',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_jdjc_truescore) => 'jdjc',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_jsys_truescore) => 'jsys',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_hzdc_truescore) => 'hzdc',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_bacc_truescore) => 'bacc',
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_xzcf_truescore) => 'xzcf',
                    Zfzl_hz_map::$name => 'n',
                    Zfzl_hz_map::$SJ => 'y',
                    Zfzl_hz_map::$dd_name => 'd'
                ],
                [
                    Zfzl_hz_map::$name,
                    Zfzl_hz_map::$SJ,
                ],
                parent::format_date(
                    Zfzl_hz_map::$SJ,
                    $date,
                    true
                )
            );


//        $sqlTool::$isDev = false;

        self::hz_clear($sqlTool, $date);


        echo "\nzfzl_hz : insert finished \n";

        $sql = '';

        $res->each_row(function ($row) use (&$sql, $coef) {
            $sql .= ',(' .
                $row['jdjc_'] . ',' .
                $row['jsys_'] . ',' .
                $row['hzdc_'] . ',' .
                $row['bacc_'] . ',' .
                $row['xzcf_'] . ',' .
                ($row['jdjc'] * $coef['jdjc']) . ',' .
                ($row['jsys'] * $coef['jsys']) . ',' .
                ($row['hzdc'] * $coef['hzdc']) . ',' .
                ($row['bacc'] * $coef['bacc']) . ',' .
                ($row['xzcf'] * $coef['xzcf']) . ',' .
                (
                    ($row['jdjc'] * $coef['jdjc']) +
                    ($row['jsys'] * $coef['jsys']) +
                    ($row['hzdc'] * $coef['hzdc']) +
                    ($row['bacc'] * $coef['bacc']) +
                    ($row['xzcf'] * $coef['xzcf'])
                ) . ',' .
                Sql_tool::QUOTE($row['n']) . ',' .
                Sql_tool::QUOTE($row['y']) . ',' .
                Sql_tool::QUOTE($row['d']) . ')';
        });

        if ($sql != '')
            $hz_table->multi_insert(
                [
                    Zfzl_hz_map::$zfzl_jdjc,
                    Zfzl_hz_map::$zfzl_jsys,
                    Zfzl_hz_map::$zfzl_hzdcc,
                    Zfzl_hz_map::$zfzl_bacc,
                    Zfzl_hz_map::$zfzl_xzcf,
                    Zfzl_hz_map::$zfzl_jdjc_truescore,
                    Zfzl_hz_map::$zfzl_jsys_truescore,
                    Zfzl_hz_map::$zfzl_hzdc_truescore,
                    Zfzl_hz_map::$zfzl_bacc_truescore,
                    Zfzl_hz_map::$zfzl_xzcf_truescore,
                    Zfzl_hz_map::$zfzl_hz,
                    Zfzl_hz_map::$name,
                    Zfzl_hz_map::$SJ,
                    Zfzl_hz_map::$dd_name
                ],
                substr($sql, 1)
            );

        return;

    }
}

Quantity::$police_dd_map = get_police_dadui_map();
Quantity::$hzdc_2_quantity = [
    Zfzl_hz_map::$name => Zfzl_hzdc_score_map::$name,
    Zfzl_hz_map::$dd_name => Zfzl_hzdc_score_map::$dadui,
    Zfzl_hz_map::$SJ => Zfzl_hzdc_score_map::$OVERTIME,
    Zfzl_hz_map::$zfzl_hzdcc => Zfzl_hzdc_score_map::$KP_SCORE,
    Zfzl_hz_map::$zfzl_hzdc_truescore => Zfzl_hzdc_score_map::$KP_TRUE_SCORE
];
Quantity::$xzcf_2_quantity = [
    Zfzl_hz_map::$name => Zfzl_xzcf_score_map::$name,
    Zfzl_hz_map::$dd_name => Zfzl_xzcf_score_map::$dadui,
    Zfzl_hz_map::$SJ => Zfzl_xzcf_score_map::$OVERTIME,
    Zfzl_hz_map::$zfzl_xzcf => Zfzl_xzcf_score_map::$KP_SCORE,
    Zfzl_hz_map::$zfzl_xzcf_truescore => Zfzl_xzcf_score_map::$KP_TRUE_SCORE
];
Quantity::$jdjc_2_quantity = [
    Zfzl_hz_map::$name => Zfzl_jdjc_score_map::$name,
    Zfzl_hz_map::$dd_name => Zfzl_jdjc_score_map::$dadui,
    Zfzl_hz_map::$SJ => Zfzl_jdjc_score_map::$OVERTIME,
    Zfzl_hz_map::$zfzl_jdjc => Zfzl_jdjc_score_map::$KP_SCORE,
    Zfzl_hz_map::$zfzl_jdjc_truescore => Zfzl_jdjc_score_map::$KP_TRUE_SCORE
];
Quantity::$bacc_2_quantity = [
    Zfzl_hz_map::$name => Zfzl_bacc_score_map::$name,
    Zfzl_hz_map::$dd_name => Zfzl_bacc_score_map::$dadui,
    Zfzl_hz_map::$SJ => Zfzl_bacc_score_map::$overtime,
    Zfzl_hz_map::$zfzl_bacc => Zfzl_bacc_score_map::$kp_score,
    Zfzl_hz_map::$zfzl_bacc_truescore => Zfzl_bacc_score_map::$kp_true_score
];
Quantity::$jsys_2_quantity = [
    Zfzl_hz_map::$name => Zfzl_jsys_score_map::$name,
    Zfzl_hz_map::$dd_name => Zfzl_jsys_score_map::$dadui,
    Zfzl_hz_map::$SJ => Zfzl_jsys_score_map::$OVERTIME,
    Zfzl_hz_map::$zfzl_jsys => Zfzl_jsys_score_map::$KP_SCORE,
    Zfzl_hz_map::$zfzl_jsys_truescore => Zfzl_jsys_score_map::$KP_TRUE_SCORE
];


/**
 * 定义常用字段的别名，规避各个表名称不统一的问题
 * Class Q_field
 */
class Q_field
{
    public static $kpld_table = 'ws_table';
    public static $kpld = 'ws_kplb';
    public static $director = 'directors';
    public static $taskId = 'task_id';
    public static $old_taskId = 'old_task_id';
    public static $task_name = 'task_name';
    public static $proeject_type = 'project_type';
    public static $time_limit = 'time_limit';
    public static $itemId = 'item_id';
    public static $over_time = 'over_time';
    public static $ws_total_score = 'ws_total_score';
    public static $flws_id = 'flws_id';
    public static $flwses = 'flwses';
    public static $count_flwses = 'count_flwses';
    public static $unit_name = 'unit_name';
    public static $cj_time = 'cj_time';
    public static $status = 'status';
    public static $xm_result = 'xm_result';
    public static $item_total_score = 'item_score';
    public static $real_item_total_score = 'real_item_score';
    public static $hz_type = 'HzdcType';
    public static $hz_fire_object = 'FirePart';
    public static $hz_fire_addr = 'FireAddress';
    public static $hz_call_time = 'FireTime';
    public static $hz_end_date = 'EndDate';
    public static $hz_handel_date = 'HandleDate';
    public static $hz_now_status = 'NowStatus';
    public static $hz_complete_date = 'CompleteDate';
    public static $hz_record_time = 'RecordTime';
    public static $hz_update_date = 'UpdateTime';
}

class Flws
{
    public $ws_id;
    public $ws_total_score;
    public $from_table;

    public function __construct($ws_id, $ws_total_score, $from_table)
    {
        $this->ws_id = $ws_id;
        $this->ws_total_score = $ws_total_score;
        $this->from_table = $from_table;
    }
}

class Item
{
    public $flwses = [];
    public $over_time;
    public $item_id;

    public function __construct($item_id, $over_time)
    {
        $this->over_time = $over_time;
        $this->item_id = $item_id;
    }

    public function ws_push($ws)
    {
        array_push($this->flwses, $ws);
    }
}