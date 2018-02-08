<?php

require_once __DIR__ . '/../map/Dadui_huizong_query_day.map.php';
require_once __DIR__ . '/../map/Quantity_gr_score.map.php';
require_once __DIR__ . '/../Quantity/Table_gropu.php';
require_once __DIR__ . '/../table/Table.class.php';
require_once __DIR__ . '/../map/Zfzl_hz.map.php';
require_once __DIR__ . '/../efficiency.php';

class ALL extends Table_group
{
    public static $quantity_2_huizong;

    public static function insert_quantity($mysqli, $param)
    {
        return (new Table(Dadui_huizong_query_day_map::$table_name, Sql_tool::build_by_mysqli($mysqli)))->union_insert(
            [
                Quantity_gr_score_map::$table_name,
            ],
            self::$quantity_2_huizong,
            $param . Sql_tool::GROUP([
                Quantity_gr_score_map::$year_month_show,
                Quantity_gr_score_map::$police_name
            ])
        );
    }

    public static function insert_quality($huanzhd_db, $zxpg_db, $param)
    {
        $sqlTool_hazd = Sql_tool::build_by_mysqli($huanzhd_db);
        $sqlTool_zxpg = Sql_tool::build_by_mysqli($zxpg_db);
        $quality_table = (new Table(
            Zfzl_hz_map::$table_name, $sqlTool_zxpg
        ));

        $res = $quality_table
            ->group_query(
                [
                    Sql_tool::SUM(Zfzl_hz_map::$zfzl_hz) => 'h',
                    Zfzl_hz_map::$name => 'n',
                    Zfzl_hz_map::$SJ => 'y',
                    Zfzl_hz_map::$dd_name => 'd'
                ],
                [
                    Zfzl_hz_map::$name,
                    Zfzl_hz_map::$SJ,
                ],
                $param
            );

        $sql = '';

        $res->each_row(function ($row) use (&$sql) {
            $sql .= ',(' .
                $row['h'] . ',' .
                '1' . ',' .
                Sql_tool::QUOTE($row['n']) . ',' .
                Sql_tool::QUOTE($row['y']) . ',' .
                Sql_tool::QUOTE($row['d']) . ')';
        });

        if ($sql != '')
            return (new Table(Dadui_huizong_query_day_map::$table_name, $sqlTool_hazd))->multi_insert(
                [
                    Dadui_huizong_query_day_map::$quality_score,
                    Dadui_huizong_query_day_map::$quality_count,
                    Dadui_huizong_query_day_map::$police_name,
                    Dadui_huizong_query_day_map::$year_month_show,
                    Dadui_huizong_query_day_map::$dd_name
                ],
                substr($sql, 1)
            );

        return 0;

    }

    public static function group_insert($mysqli, $mysqli_zx, $date = null)
    {
        self::hz_clear($mysqli, $date);

        $afr = self::insert_quantity(
            $mysqli,
            parent::format_date(
                Quantity_gr_score_map::$year_month_show,
                $date
            )
        );

        echo "      *Quantity finished , affect rows : $afr | ";

        $afr = self::insert_quality(
            $mysqli,
            $mysqli_zx,
            parent::format_date(
                Zfzl_hz_map::$SJ,
                $date,
                true
            )
        );

        echo "      *Quality finished , affect rows : $afr | ";


        efficiency($mysqli_zx,$mysqli,$date);

        $sqlTool_hazd = Sql_tool::build_by_mysqli($mysqli);
//        $sqlTool_zxpg = Sql_tool::build_by_mysqli($mysqli_zx);
        $hz_table = (new Table(
            Dadui_huizong_query_day_map::$table_name, $sqlTool_hazd
        ));

        $res = $hz_table
            ->group_query(
                [
                    Sql_tool::SUM(Dadui_huizong_query_day_map::$quality_score) => 'z',
                    Sql_tool::SUM(Dadui_huizong_query_day_map::$quantity_score) => 's',
                    Sql_tool::SUM(Dadui_huizong_query_day_map::$efficiency_score) => 'e',
                    Sql_tool::SUM(Dadui_huizong_query_day_map::$effect_score) => 'et',
                    Sql_tool::SUM(Dadui_huizong_query_day_map::$capacity_score) => 'c',
                    Sql_tool::SUM(Dadui_huizong_query_day_map::$video_score) => 'v',
                    Sql_tool::SUM(Dadui_huizong_query_day_map::$quality_count) => 'qc',
                    Dadui_huizong_query_day_map::$police_name => 'n',
                    Dadui_huizong_query_day_map::$year_month_show => 'y',
                    Dadui_huizong_query_day_map::$dd_name => 'd'
                ],
                [
                    Dadui_huizong_query_day_map::$police_name,
                    Dadui_huizong_query_day_map::$year_month_show,
                ],
                parent::format_date(
                    Dadui_huizong_query_day_map::$year_month_show,
                    $date,
                    true
                )
            );

        $sql = '';

        self::hz_clear($mysqli, $date);

        $res->each_row(function ($row) use (&$sql) {
            $sql .= ',(' .
                $row['z'] . ',' .
                $row['s'] . ',' .
                $row['e'] . ',' .
                $row['et'] . ',' .
                $row['c'] . ',' .
                $row['v'] . ',' .

                ($row['s'] +
                    $row['z'] +
                    $row['e'] +
                    $row['et'] +
                    $row['c'] +
                    $row['v']) . ',' .
                //用来判断quality是满分（扣分为0）和 未审批（无扣分信息）
                ($row['qc'] > 1 ? 1 : $row['qc']) . ',' .
                Sql_tool::QUOTE($row['n']) . ',' .
                Sql_tool::QUOTE($row['y']) . ',' .
                Sql_tool::QUOTE($row['d']) . ')';
        });

        if ($sql != '')
            return $hz_table->multi_insert(
                [
                    Dadui_huizong_query_day_map::$quality_score,
                    Dadui_huizong_query_day_map::$quantity_score,
                    Dadui_huizong_query_day_map::$efficiency_score,
                    Dadui_huizong_query_day_map::$effect_score,
                    Dadui_huizong_query_day_map::$capacity_score,
                    Dadui_huizong_query_day_map::$video_score,
                    Dadui_huizong_query_day_map::$weighted_total_score,
                    Dadui_huizong_query_day_map::$quality_count,
                    Dadui_huizong_query_day_map::$police_name,
                    Dadui_huizong_query_day_map::$year_month_show,
                    Dadui_huizong_query_day_map::$dd_name
                ],
                substr($sql, 1)
            );

        echo "\n" . Dadui_huizong_query_day_map::$table_name . ' finished';

        return 0;
    }

    public static function hz_clear($db, $date = null)
    {
        $sqlTool = parent::sqlTool_build($db);
        $tables = [new Table(Dadui_huizong_query_day_map::$table_name, $sqlTool)];

        parent::group_clear(
            $tables,
            Dadui_huizong_query_day_map::$year_month_show,
            $date
        );
    }
}

ALL::$quantity_2_huizong = [
    Dadui_huizong_query_day_map::$police_name => Quantity_gr_score_map::$police_name,
    Dadui_huizong_query_day_map::$quantity_score
    => Quantity_gr_score_map::$zfsl_total_score,
    Dadui_huizong_query_day_map::$year_month_show
    => Quantity_gr_score_map::$year_month_show,
    Dadui_huizong_query_day_map::$dd_name
    => Quantity_gr_score_map::$dd_name
];