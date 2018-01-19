<?php
/**
 * User: zhuanhgjiayu
 * Date: 2018/1/17
 * Time: 18:51
 */

require_once __DIR__ . '/map/Quantity_xzcf_gr_nbr.map.php';
require_once __DIR__ . '/map/Quantity_xzcf_gr_sub_score.map.php';
require_once __DIR__ . '/map/Quantity_xzcf_gr_basic_coef.map.php';
require_once __DIR__ . '/map/Quantity_dczghzyhwf_gr_nbr.map.php';
require_once __DIR__ . '/map/Quantity_xzcf_gr_sub_coef.map.php';
require_once __DIR__ . '/formula/XZCF.php';
require_once __DIR__ . '/table/Table.class.php';
require_once __DIR__ . '/sql/Sql.class.php';
require_once __DIR__ . '/map/DB_map.class.php';

$sqlTool = SqlTool::build();
$xzcf_table = new Table(Quantity_xzcf_gr_nbr_map::$table_name, $sqlTool);


/**
 * 案列：查询操作
 */

if(false){
    $resList = $xzcf_table->query(
        Quantity_xzcf_gr_nbr_map::all(),
        SqlTool::WHERE([
            Quantity_xzcf_gr_nbr_map::$year_month_show => '%2017-05%',
            Quantity_xzcf_gr_nbr_map::$dd_name => '水上'
        ]),
        true
    );

    print_r($resList[0]);
}

/**
 * 案例：插入操作
 */

if(false){
    //单挑数据插入
    $xzcf_table->multi_insert(
        [Quantity_xzcf_gr_nbr_map::$year_month_show],
        [10]
    );
    //多条数据插入
    $xzcf_table->multi_insert(
        [
            Quantity_xzcf_gr_nbr_map::$year_month_show,
            Quantity_xzcf_gr_nbr_map::$jls_feizddw_zhubr
        ],
        [
            ['2019-01-01',11],
            ['1202-02-02',11],
            ['1233-03-09',10],
        ]
    );

}

/**
 * 案例：左联查询操作
 */

if(false){

    $resList1 = $xzcf_table->left_join(
        Quantity_dczghzyhwf_gr_nbr_map::$table_name,
        [
                Quantity_xzcf_gr_nbr_map::$year_month_show => 'a',
                Quantity_xzcf_gr_nbr_map::$dd_name => 'b',
                Quantity_dczghzyhwf_gr_nbr_map::$dadui_name,
                Quantity_dczghzyhwf_gr_nbr_map::$police_name
        ],
        SqlTool::ON([
            Quantity_xzcf_gr_nbr_map::$year_month_show => Quantity_dczghzyhwf_gr_nbr_map::$year_month_show,
            Quantity_xzcf_gr_nbr_map::$dd_name => Quantity_dczghzyhwf_gr_nbr_map::$dadui_name
        ])
        .SqlTool::WHERE([
            Quantity_xzcf_gr_nbr_map::$year_month_show => '%2017-05-01%'
        ]),
        true
    );

    print_r($resList1[0]);

}


if(1){
    $xzcf_sub_table = new Table(Quantity_xzcf_gr_sub_score_map::$table_name, $sqlTool);

//echo XZCF_trans_model::subscore_update_between(
//    $xzcf_sub_table, ['2017-05-01', '2017-05-20']
//);

    echo XZCF_group::subscore_update_by_id(
        $xzcf_sub_table, 1
    );
}


