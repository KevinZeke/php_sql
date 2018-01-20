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
require_once __DIR__ . './formula/HZ.php';
require_once __DIR__ . '/formula/XZCF.php';
require_once __DIR__ . '/formula/HZDC.php';
require_once __DIR__ . '/table/Table.class.php';
require_once __DIR__ . '/sql/Sql.class.php';
require_once __DIR__ . '/map/DB_map.class.php';

//使用默认参数生成sqlTool工具类
$sqlTool = SqlTool::build();
//使用mysqli实例构造sqlTool工具类
//$sqlTool = SqlTool::build_by_mysqli( new mysqli(host,user,pwd,db) );


$xzcf_table = new Table(Quantity_xzcf_gr_nbr_map::$table_name, $sqlTool);

/**
 * 案列：查询操作
 */

if (false) {
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

if (false) {
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
            ['2019-01-01', 11],
            ['1202-02-02', 11],
            ['1233-03-09', 10],
        ]
    );

}

/**
 * 更新操作
 */

if (false) {

    echo $xzcf_table->update(
        [Quantity_xzcf_gr_nbr_map::$year_month_show => '1970-01-01'],
        SqlTool::WHERE([
            Quantity_xzcf_gr_nbr_map::$number_id => 1
        ], false)
    );

}

/**
 * 删除操作
 */

if (false) {
    echo $xzcf_table->delete(
        SqlTool::WHERE([
            Quantity_xzcf_gr_nbr_map::$number_id => 14326
        ])
    );
}

/**
 * 案例：左联查询操作
 */

if (false) {

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
        . SqlTool::WHERE([
            Quantity_xzcf_gr_nbr_map::$year_month_show => '%2017-05-01%'
        ]),
        true
    );

    print_r($resList1[0]);

}

/**
 * 案例：行政处罚表格组关联操作
 */
if (false) {

    //时间段分数重计算更新
    echo XZCF_group::group_update_date_in(
        $sqlTool->get_mysqli(), ['2017-05-01', '2017-05-20']
    );

    //根据id特定行更新
    echo XZCF_group::group_update_by_id(
        $sqlTool->get_mysqli(), 2
    );
}

/**
 * 火灾调查表格组关联操作
 */
if(false){

    //时间段分数重计算更新
    echo HZDC_group::group_update_date_in(
        $sqlTool->get_mysqli(), ['2017-05-01', '2017-05-20']
    );

    //根据id特定行更新
    echo HZDC_group::group_update_by_id(
        $sqlTool->get_mysqli(), 2
    );

}

//$xzcf_table->union_insert(
//    ['a','b','c'],
//    [
//        'as'=>'aa*ca',
//        'aas'=>'asa*csa',
//        'asa'=>'aada*cada'
//    ],
//    SqlTool::WHERE(
//        [
//            'a'=>'ac'
//        ]
//    )
//);

//HZ_group::update_xzcf_item($sqlTool->get_mysqli(),'');
//HZ_group::update_hzdc_item($sqlTool->mysqli,'');

//HZ_group::insert_hzdc_item($sqlTool->get_mysqli());

echo HZ_group::update_xzcf_item($sqlTool->get_mysqli(),'汤金保','2017-05-01');
echo HZ_group::update_hzdc_item($sqlTool->get_mysqli(),'汤金保','2017-05-01');

$sqlTool->close();


