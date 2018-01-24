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
require_once __DIR__ . '/formula/HZ.php';
require_once __DIR__ . '/formula/XZCF.php';
require_once __DIR__ . '/formula/HZDC.php';
require_once __DIR__ . '/formula/JSYS.php';
require_once __DIR__ . '/table/Table.class.php';
require_once __DIR__ . '/sql/Sql.class.php';
require_once __DIR__ . '/map/DB_map.class.php';

//使用默认参数生成sqlTool工具类
$sqlTool = SqlTool::build();
//可以使用mysqli实例构造sqlTool工具类，避免重复创建mysqli
//$sqlTool = SqlTool::build_by_mysqli( new mysqli(host,user,pwd,db) );

//创建一个行政处罚次数表的表格实例
$xzcf_table = new Table(Quantity_xzcf_gr_nbr_map::$table_name, $sqlTool);

/**
 * 案列：查询操作
 */

if (1) {
    $resList = $xzcf_table->query(
    //需要获得的列名，数组
        Quantity_xzcf_gr_nbr_map::all(),
        //查询的条件，字符串
        SqlTool::WHERE([
            Quantity_xzcf_gr_nbr_map::$year_month_show => '%2017-05%',
            Quantity_xzcf_gr_nbr_map::$dd_name => '水上'
        ])
    );

    //Table实例的query方法可以返回一个SqlResult实例
    //SqlResult实例提供对结果集的各种封装操作
    //to_json方法可以将结果集直接转换成json字符串
    //并且接受一个回调函数作为参数，该函数的参数为格式化的行对象，该函数返回值决定该行是否保留
//    $filter = function ($row) {
//        //do something to current row
//        return true;
//    };
//    $resList->to_json($filter);
    //SqlResult包装类对结果集实现的其他操作，to_json方法实际上是包装调用了to_objetc_list
    //以下方法也可接受回调函数作为筛选或者其他操作参数参数，并返回对应的数组
    //$resList->to_array_list();      return: array<array>
    //$resList->to_objetc_list();     return: array<object>



    //分组操作函数，简化查询配置 ,同样返回SqlResult类型
    (new Table(Quantity_xzcf_gr_sub_score_map::$table_name, $sqlTool))
        ->group_query(
        //需要获得的列名，可以设置别名
            [
                SqlTool::SUM(Quantity_xzcf_gr_sub_score_map::$xzcf_zdf, 's'),
                Quantity_xzcf_gr_sub_score_map::$police_name => 'n',
                Quantity_xzcf_gr_sub_score_map::$year_month_show => 'd'
            ],
            //此参数表示按该字段分组，若是键值对形式，则表示按该键值对的键值分组
            //并且限制改字段的值
            [
                //按year_month_show分组并且year_month_show = '2017-05-01'
                Quantity_xzcf_gr_sub_score_map::$year_month_show => '2017-05-01',
                Quantity_xzcf_gr_sub_score_map::$police_name
            ]
        );

    //echo JSYS_group::jg_sub_update_by_id($sqlTool->get_mysqli(),1);

    //echo JSYS_group::jianshen_insert_jg_item($sqlTool->get_mysqli(),'汤金保','2018-06-09');

    echo JSYS_group::jianshen_update_jg_item($sqlTool->get_mysqli(),'汤金保','2018-06-09');

//    echo HZ_group::update_hzdc_item($sqlTool->get_mysqli(),'汤金保','2017-05-01');
}

/**
 * 案例：插入操作
 */

if (false) {
    //单挑数据插入
    $xzcf_table->multi_insert(
        //字段数组
        [Quantity_xzcf_gr_nbr_map::$year_month_show],
        //插入值数组
        [10]
    );
    //多条数据插入
    $xzcf_table->multi_insert(
        [
            Quantity_xzcf_gr_nbr_map::$year_month_show,
            Quantity_xzcf_gr_nbr_map::$jls_feizddw_zhubr
        ],
        //插入值为二维数组，表示插入多条数据
        [
            ['2019-01-01', 11],
            ['1202-02-02', 11],
            ['1233-03-09', 10]
        ]
    );

}

/**
 * 更新操作
 */

if (false) {

    echo $xzcf_table->update(
        //更新的字段 => 更新的值
        [Quantity_xzcf_gr_nbr_map::$year_month_show => '1970-01-01'],
        //更新的查询条件值
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
        //删除查询条件
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
        ])
    );

    print_r($resList1[0]);

}

if (false) {
    //联合插入
    $xzcf_table->union_insert(
    //相关表格名
        ['a', 'b', 'c'],
        //插入字段的键值对/公式
        [
            'af' => 'aa * ca',
            'af2' => 'asa * csa',
            'af3' => 'aada * cada'
        ],
        //查询参数
        SqlTool::WHERE(
            [
                'af' => '1'
            ]
        )
    );
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
if (false) {

    //时间段分数重计算更新
    echo HZDC_group::group_update_date_in(
        $sqlTool->get_mysqli(), ['2017-05-01', '2017-05-20']
    );

    //根据id特定行更新
    echo HZDC_group::group_update_by_id(
        $sqlTool->get_mysqli(), 2
    );

}


//HZ_group::update_xzcf_item($sqlTool->get_mysqli(),'');
//HZ_group::update_hzdc_item($sqlTool->mysqli,'');

//HZ_group::insert_hzdc_item($sqlTool->get_mysqli());

/**
 * 汇总表的数据是否存在验证
 */

if (false) {
    echo HZ_group::is_row_ext($sqlTool, '汤金保', '2017-05-01') ? 'true' : 'false';
}


if (false) {
    HZ_group::insert_hzdc($sqlTool->get_mysqli());
}

/**
 * 汇总表的关联更新
 */
if (false) {
    echo HZ_group::update_xzcf_item($sqlTool->get_mysqli(), '汤金保', '2017-05-01', true);
    echo HZ_group::update_hzdc_item($sqlTool->get_mysqli(), '汤金保', '2017-05-01', true);
}


if (false) {
    echo HZ_group::insert_xzcf_item($sqlTool->get_mysqli(), '汤金保', '2017-05-01');
    echo HZ_group::insert_hzdc_item($sqlTool->get_mysqli(), '汤金保', '2017-05-01');
}

$sqlTool->close();


