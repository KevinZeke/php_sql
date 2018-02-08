<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/17
 * Time: 12:30
 * function: 自动生成数据库下所有表的字段映射类 命令行传参，例：php /somepath/creator.php [database_name]
 */

require_once __DIR__ . '/../sql/Sql.class.php';
require_once __DIR__ . '/../table/Table.class.php';


$db = "zxpg_gzpc_db";

$sqlTool = Sql_tool::build("localhost", "root", "123456", $db);

$res = $sqlTool->execute_dql("select table_name from information_schema.TABLES where TABLE_SCHEMA='$db' ");

if (!!$res) {
    while (!!$row = $res->fetch_array()) {
        createClass($row['table_name'], $db, $sqlTool);
//        echo $row['table_name'];
//        (new Table($row['table_name'], $sqlTool))->truncate();
    }
}

function createClass($table, $db, $sqlTool)
{
    $sql = "select COLUMN_NAME from information_schema.COLUMNS 
        where table_name = '$table' and table_schema = '$db' ";
//echo $sql."\n";
    $res = $sqlTool->execute_dql($sql);

    $resstr = "<?php \r\n";

    if ($res) {
        $className = $table . "_map";
        $className[0] = strtoupper($className[0]);
        $resstr .= 'require_once __DIR__.\'/DB_map.class.php\';' . "\r\n";
        $resstr .= "class $className extends DB_map {\r\n";
        $resstr .= "  static \$table_name = '$table' ;\r\n";
        while (!!$row = $res->fetch_object()) {
            $resstr .= '  static ';
            $resstr .= '$' . $row->COLUMN_NAME . " = '$table.$row->COLUMN_NAME' ;";
            $resstr .= "\r\n";
        }
        $resstr .= "  static function all(){
            //return parent::all();
        }\r\n";
        $resstr .= "}\r\n";
    }
    $table[0] = strtoupper($table[0]);
    writeFile($table . '.map' . '.php', $resstr);
    return $resstr;
}

function writeFile($name, $content)
{
    $myfile = fopen(__DIR__ . "/../map/$name", "w");
    fwrite($myfile, $content);
    fclose($myfile);
}

//result example
//class huaianzhd_db_map {
//    static   $police_id = 'police_id' ;
//    static   $police_name = 'police_name' ;
//    static   $dd_name = 'dd_name' ;
//    static   $zhd_name = 'zhd_name' ;
//    static   $year_month_show = 'year_month_show' ;
//    static   $zlstdws_zddw_zhubr = 'zlstdws_zddw_zhubr' ;
//    static   $zlstdws_zddw_xiebr = 'zlstdws_zddw_xiebr' ;
//    static   $zlstdws_feizddw_zhubr = 'zlstdws_feizddw_zhubr' ;
//    static   $zlstdws_feizddw_xiebr = 'zlstdws_feizddw_xiebr' ;
//    static   $zlstdws_sub_total_nbr = 'zlstdws_sub_total_nbr' ;
//    static   $fks_zddw_zhubr = 'fks_zddw_zhubr' ;
//    static   $fks_zddw_xiebr = 'fks_zddw_xiebr' ;
//    static   $fks_feizddw_zhubr = 'fks_feizddw_zhubr' ;
//    static   $fks_feizddw_xiebr = 'fks_feizddw_xiebr' ;
//    static   $fks_sub_total_nbr = 'fks_sub_total_nbr' ;
//    static   $jls_zddw_zhubr = 'jls_zddw_zhubr' ;
//    static   $jls_zddw_xiebr = 'jls_zddw_xiebr' ;
//    static   $jls_feizddw_zhubr = 'jls_feizddw_zhubr' ;
//    static   $jls_feizddw_xiebr = 'jls_feizddw_xiebr' ;
//    static   $jls_sub_total_nbr = 'jls_sub_total_nbr' ;
//    static   $number_id = 'number_id' ;
//}







