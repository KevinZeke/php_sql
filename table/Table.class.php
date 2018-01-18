<?php
/**
 * User: zhuangjiayu
 * Date: 2018/1/17
 * Time: 18:49
 */


require_once __DIR__.'/../formula/Formula.class.php';

class Table{
    var $tableName;
    private $sqlTool = null;

    static function formatField($field){
        $res = array();
        foreach ($field as $k=>$v){
            if(is_numeric($k))
                array_push($res,$v);
            else
                array_push($res," $k AS $v ");
        }
//        print_r($res);
        return implode(',',$res);
    }

    public function __construct($tableName,$sqlTool)
    {
        $this->tableName = $tableName;
        $this->sqlTool = $sqlTool;
    }
    public function dql($sqlstr){
        return $this->sqlTool->execute_dql($sqlstr);
    }
    public function dml($sqlstr){
        return $this->sqlTool->execute_dml($sqlstr);
    }
    public function query($field, $param='', $callback=null){
        $sql = "SELECT ".Table::formatField($field)." FROM ".$this->tableName." $param";
//        echo $sql;
        $resList = array();
        $res = null;
        if($this->sqlTool!=null){
            $res = $this->sqlTool->execute_dql($sql);
                while (!!$row = $res->fetch_array()){
//                    if($callback) $callback($row);
                    array_push($resList, $row);
            }
        }
        $res->close();
        return $resList;
    }
    public function multiInsert($field, $value){
        $sql = "INSERT INTO ".$this->tableName."( ".implode(',',$field)." ) VALUES ";
        if(!is_array($value) || count($value) == 0) return -1;
        $valarr = array();
        if(is_array($value[0]))
            foreach ($value as $val){
                array_push($valarr, '( '.implode(',',$val).' )');
            }
        $sql.=implode(',',$valarr);
//        echo $sql;
        return $this->sqlTool->execute_dml($sql);
    }
    public function update($field, $newVal ,$param){
        //TODO
        die("TODO : not support ");
    }

    /**
     * @param $tables  另一个表格实例
     * @param $formula 关联更新公式
     * @param $param   更新行查询条件
     * @return mixed
     */
    public function unionUpdate($tables, $formula, $param){
        $sql = "UPDATE $this->tableName , ".implode(',',$tables)."
        SET $formula
        $param";
//        echo $sql;
        return $this->sqlTool->execute_dml($sql);

    }
    public function delete($param){
        if(!is_array($param) || count($param) == 0) return -1;
        return $this->sqlTool->execute_dml(
            "DELETE FROM $this->tableName $param"
        );
    }

    public function leftJoin($table,$field,$param,$isToList = false){
        if(!is_array($field) || count($field) == 0) return -1;
        $sql = 'SELECT '.Table::formatField($field[0]).' , '.Table::formatField($field[1]).' FROM '.$this->tableName.' LEFT JOIN '.$table." $param";
        $resList = array();
        $res = null;
        if($this->sqlTool!=null){
            $res = $this->sqlTool->execute_dql($sql);
            if(!$isToList) return $res;
            while (!!$row = $res->fetch_array()){
//                    if($callback) $callback($row);
                array_push($resList, $row);
            }
        }
        $res->close();
        return $resList;
    }
}