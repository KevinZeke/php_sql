<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/17
 * Time: 13:21
 */

require_once __DIR__.'/../sql/Sql.class.php';

class Quantity_xzcf_gr_nbr_map {
    static $police_id = 'quantity_xzcf_gr_nbr.police_id' ;
    static $police_name = 'quantity_xzcf_gr_nbr.police_name' ;
    static $dd_name = 'quantity_xzcf_gr_nbr.dd_name' ;
    static $zhd_name = 'quantity_xzcf_gr_nbr.zhd_name' ;
    static $year_month_show = 'quantity_xzcf_gr_nbr.year_month_show' ;
    static $zlstdws_zddw_zhubr = 'quantity_xzcf_gr_nbr.zlstdws_zddw_zhubr' ;
    static $zlstdws_zddw_xiebr = 'quantity_xzcf_gr_nbr.zlstdws_zddw_xiebr' ;
    static $zlstdws_feizddw_zhubr = 'quantity_xzcf_gr_nbr.zlstdws_feizddw_zhubr' ;
    static $zlstdws_feizddw_xiebr = 'quantity_xzcf_gr_nbr.zlstdws_feizddw_xiebr' ;
    static $zlstdws_sub_total_nbr = 'quantity_xzcf_gr_nbr.zlstdws_sub_total_nbr' ;
    static $fks_zddw_zhubr = 'quantity_xzcf_gr_nbr.fks_zddw_zhubr' ;
    static $fks_zddw_xiebr = 'quantity_xzcf_gr_nbr.fks_zddw_xiebr' ;
    static $fks_feizddw_zhubr = 'quantity_xzcf_gr_nbr.fks_feizddw_zhubr' ;
    static $fks_feizddw_xiebr = 'quantity_xzcf_gr_nbr.fks_feizddw_xiebr' ;
    static $fks_sub_total_nbr = 'quantity_xzcf_gr_nbr.fks_sub_total_nbr' ;
    static $jls_zddw_zhubr = 'quantity_xzcf_gr_nbr.jls_zddw_zhubr' ;
    static $jls_zddw_xiebr = 'quantity_xzcf_gr_nbr.jls_zddw_xiebr' ;
    static $jls_feizddw_zhubr = 'quantity_xzcf_gr_nbr.jls_feizddw_zhubr' ;
    static $jls_feizddw_xiebr = 'quantity_xzcf_gr_nbr.jls_feizddw_xiebr' ;
    static $jls_sub_total_nbr = 'quantity_xzcf_gr_nbr.jls_sub_total_nbr' ;
    static $number_id = 'quantity_xzcf_gr_nbr.number_id' ;
    static function all(){
        $r = new ReflectionClass('Quantity_xzcf_gr_nbr_map');
        $sp = $r->getStaticProperties();
        return $sp;
//        $val = array();
//        foreach ($sp as $value){
//            array_push($val,$value);
//        }
//        return $val;
    }
}


class Table{
    var $tableName;
    private $sqlTool;
    public function __construct($tableName,$sqlTool = null)
    {
        $this->tableName = $tableName;
        $this->sqlTool = $sqlTool;
    }
    public function query($field, $param=''){
        $sql = "SELECT ".$this->formatField($field)." FROM $this->tableName $param";
        echo $sql;
        $res = null;
        if($this->sqlTool!=null){
             $res = $this->sqlTool->execute_dql($sql);
        }
        return $res;
    }
    public function insert($field, $value){

    }
    public function update($field, $newVal ,$param){

    }
    public function delete($param){

    }

    private function formatField($field){
        if(!is_array($field)){
            die("字段必须为数组");
        }
        $str = '';
        foreach ($field as $value){
            $str.=", $value 
            ";
        }
        $str[0] = '';
        return $str;
    }
}

$t = new Table('quantity_xzcf_gr_nbr',new SqlTool());
$t->query(
    Quantity_xzcf_gr_nbr_map::all(),
    SqlTool::WHERE([
        Quantity_xzcf_gr_nbr_map::$year_month_show => '%2017-05%'
    ])
);