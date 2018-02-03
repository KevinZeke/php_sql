<?php

/************************************************
 **;用户自定义函数:(3.2)数据库查询子模块,返回查询结果为string或int类型类型
 **;序列号 04
 **;函数名:query_db_data_string
 **;功能：数据库查询子模块
 **;参数:$db为创建的数据库,$select为查询语句
 **;返回值:返回查询结果$rows为string类型
 **;*********************************************/
function query_db_data_string($db, $select)
{
    $rows = null;
    $result = $db->query($select);
    list($rows) = $result->fetch_row();
    return $rows;
}

///
///获取淮安支队所有大队列表 不含"所有"
//输入:无
//返回:
//    成功：返回大队列表数组：$dd_name_list  失败：返回0
///
function get_all_ddname_list()
{
    $conn = select_data_base('huaianzhd_db');
    $dadui_name_list = array();
    $avgcmd = "select dadui_name from dadui_name_list;";
    $dd_name_list = query_db_data_array($conn, $avgcmd);
    for ($i = 0, $j = 0; $i < count($dd_name_list); $i++) {
        if ($dd_name_list[$i] != "所有") {
            $dadui_name_list[$j] = $dd_name_list[$i];
            $j++;
        }
    }
    if ($dadui_name_list)
        return $dadui_name_list;

    else return 0;
}


/************************************************
 **;用户自定义函数:返回实际所需的数据库
 **;序列号 02->(1)
 **;函数名:select_data_base
 **;功能：根据传递js参数名字，返回得到的js参数值
 **;参数:$data_base("为实际所需要选取的数据库名字")
 **;返回值:成功,返回连接的数据库$conn;失败,返回值0
 **;*********************************************/
function select_data_base($data_base)
{
    $conn = new mysqli("127.0.0.1", "root", "123456", $data_base);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return 0;
    } else return $conn;
}


/************************************************
 **;用户自定义函数:返回实际所需的数据库
 **;序列号 02->(2)
 **;函数名:connectDBbyddname
 **;功能：根据传递js参数名字，返回得到的js参数值
 **;参数:$data_base("为实际所需要选取的数据库名字")
 **;返回值:成功,返回连接的数据库$conn;失败,返回值0
 **;*********************************************/
function connectDBbyddname($ddname)
{
    ////连接数据库
    $conn = null;

    if ($ddname == '淮安区') {
        $conn = select_data_base("huaianqu_db");
    } else if ($ddname == "淮阴区") {
        $conn = select_data_base("huaiyinqu_db");
    }

    ////
    ////修改于 20170509 cl
    else if ($ddname == "清江") {
        $conn = select_data_base("qingjiang_db");
    } else if ($ddname == "清浦") {
        $conn = select_data_base("qingpu_db");
    } else if ($ddname == "淮安支队") {
        $conn = select_data_base("huaianzhd_db");
    }
    ////
    ////

    else if ($ddname == "涟水县") {
        $conn = select_data_base("lianshuixian_db");
    } else if ($ddname == "盱眙县") {
        $conn = select_data_base("xuyixian_db");
    } else if ($ddname == "开发区") {
        $conn = select_data_base("kaifaqu_db");
    } else if ($ddname == "支队（机关）") {
        $conn = select_data_base("huaian_zdjg_db");
    } else if ($ddname == "金湖县") {
        $conn = select_data_base("jinhuxian_db");
    } else if ($ddname == "水上") {
        $conn = select_data_base("shuishang_db");
    } else if ($ddname == "新城") {
        $conn = select_data_base("xincheng_db");
    } else if ($ddname == "园区") {
        $conn = select_data_base("yuanqu_db");
    } else if ($ddname == "洪泽县") {
        $conn = select_data_base("hongzexian_db");
    } //1月26插入自定义数据库
    else if ($ddname == "zxpg_gzpc_db") {
        $conn = select_data_base("zxpg_gzpc_db");
    } else return null;

    return $conn;
}

/************************************************
 **;用户自定义函数:(3.1)数据库查询子模块,返回查询结果为数组类型
 **;序列号 03
 **;函数名:query_db_array
 **;功能：数据库查询子模块
 **;参数:$db为创建的数据库,$select为查询语句
 **;返回值:返回查询结果为数组类型
 **;*********************************************/
//lihai
function query_db_data_array($db, $select)
{
    $rows = array();
    $i = 0;
    $result = $db->query($select);
    while (list($row1) = $result->fetch_row()) {
        $rows[$i] = $row1; //不是$row[index] ？这是什么用法？
        $i = $i + 1;
    }
    return $rows;
}

/****功能:获取警员名，警员号****/
/***参数名：接收大队名字 DD_name
 * 返回值:警员名 Police_name,警员号 Police_id,
 */


/************************************************
 **;用户自定义函数:(1)接收前端js数据模块
 **;序列号 01
 **;函数名:recived_js_data
 **;功能：根据传递js参数名字，返回得到的js参数值
 **;参数:$js_para("为实际所需要取值的js参数名")
 **;返回值:成功,返回连接的数据库;失败,返回值0
 **;*********************************************/
function recived_js_data($js_para)
{
    if ($js_para != null) {
        return $_GET[$js_para];
    } else return 0;
}

//lihai: add rank not used
/*
function get_Police_ID_by_DD_name()
{
	$conn=null;
	$conn=connectDBbyddname(recived_js_data('DD_name'));

	//获取不同警员名数组
	$Police_name=query_db_data_array($conn,"select DISTINCT (police_name) from personal_information;");
	//获取不同警员号的数组
    $Police_id=query_db_data_array($conn,"select DISTINCT (police_id) from personal_information;");

	//发送数据
	$s1=implode(',',$Police_name);
	$s2=implode(':',$Police_id);
    $s=$s1.":";
	$s=$s.$s2;
	$s=$s.":";

	$callback =isset($_GET['callback']) ? trim($_GET['callback']) : ''; //jsonp回调参数，必需
	$date["msg"]="err";
	$date["info"]=$s;
	$tmp=json_encode($date);
	echo $callback . '(' . $tmp .')';
}
*/

//---------------------------------//
//Only support "淮安支队",otherwise return ''
//20170510 cl 添加清江，清浦 对应的数据库
function getDBName($zhidu_name, $dadui_name)
{
    $DADUIName_Database = [
        '淮安区' => 'huaianqu_db', '淮阴区' => 'huaiyinqu_db', '清江浦区' => 'qingjiangpuqu_db',
        '涟水县' => 'lianshuixian_db', '盱眙县' => 'xuyixian_db', '开发区' => 'kaifaqu_db',
        '支队（机关）' => 'huaian_zdjg_db', '金湖县' => 'jinhuxian_db', '水上' => 'shuishang_db',
        '新城' => 'xincheng_db', '园区' => 'yuanqu_db', '洪泽县' => 'hongzexian_db', '清江' => 'qingjiang_db',
        '清浦' => 'qingpu_db'
    ];

    if ($zhidu_name != '淮安支队') return '';

    return $DADUIName_Database[$dadui_name];

}


//Input:
//	json: DD_name : value
//return PDO connection
function pdoConnect($dbName)
{

    //$conn=new mysqli("127.0.0.1","root","123456",$data_base);

    $dbms = 'mysql';     //数据库类型
    $host = '127.0.0.1'; //数据库主机名
    //$dbName=$DADUIName_Database[$_GET['DD_name']];    //使用的数据库
    $user = 'root';      //数据库连接用户名
    $pass = '123456';          //对应的密码

    $dsn = "$dbms:host=$host;dbname=$dbName";
    $pdo = new PDO($dsn, $user, $pass); //初始化一个PDO对象

    return $pdo;
}

/*
//input:
//	$conn: mysql pdo database connection
//	$json_index_list: //array or string
//	$mysql_input:
//		[
//			'myselect' => selector //array or string
//			'myfrom' => table //array or string
//			'mywhere' => condition //array or string
//		]
//return:
//	json format,including result:value
function mysql_pdo_select($conn,$json_index_list,$mysql_input){
	$rst = 0;
	$ret = array();

	while(true){

		//check input
		if($conn==null) {
			$rst = 101;
			break;
		}

		if(is_array($json_index_list)){

			for($ii=0;$ii<count($json_index_list);$ii++){
				//make mysql script
				$my_select = is_array($mysql_input['myselect'])? $mysql_input['myselect'][$ii]:$mysql_input['myselect'];
				$my_from = is_array($mysql_input['myfrom'])? $mysql_input['myfrom'][$ii]:$mysql_input['myfrom'];

				if($mysql_input['mywhere']==''){
					$ret[$json_index_list[$ii]]= $conn->query(" SELECT ".$my_select." FROM ".$my_from.";")->fetchAll(PDO::FETCH_COLUMN);
				}else{
					$mywhere = is_array($mysql_input['mywhere'])? $mysql_input['mywhere'][$ii]:$mysql_input['mywhere'];
					$ret[$json_index_list[$ii]]= $conn->query(" SELECT ".$my_select." FROM ".$my_from." WHERE ".$my_where.";")->fetchAll(PDO::FETCH_COLUMN);
				}
			}
		}else{
				if($mysql_input['mywhere']==''){
					$ret[$json_index_list]= $conn->query(" SELECT ".$mysql_input['myselect']." FROM ".$mysql_input['myfrom'].";")->fetchAll(PDO::FETCH_COLUMN);
				}else{
					$ret[$json_index_list]= $conn->query(" SELECT ".$mysql_input['myselect']." FROM ".$mysql_input['myfrom']." WHERE ".$mysql_input['mywhere'].";")->fetchAll(PDO::FETCH_COLUMN);
				}
		}

		break;
	}

	$ret["result"] = 1;

	$callback =isset($_GET['callback']) ? trim($_GET['callback']) : ''; //jsonp回调参数，必需
	$tmp=json_encode($ret);
	echo $callback . '(' . $tmp .')';

}
*/

//input:
//	$conn: mysql pdo database connection
//	$json_index_list: //array or string
//	$mysql_input:
//		[
//			'myselect' => selector //array or string
//			'myfrom' => table //array or string
//			'mywhere' => condition //array or string
//			'myorderby' => fieldname //array or string
//		]
//return:
//	json format,including result:value

function mysql_pdo_select($conn, $json_index_list, $mysql_input)
{
    $rst = 0;
    $ret = array();

    while (true) {

        //check input
        if ($conn == null) {
            $rst = 101;
            break;
        }

        if (is_array($json_index_list)) {

            for ($ii = 0; $ii < count($json_index_list); $ii++) {
                //make mysql script
                $my_select = is_array($mysql_input['myselect']) ? $mysql_input['myselect'][$ii] : $mysql_input['myselect'];
                $my_from = is_array($mysql_input['myfrom']) ? $mysql_input['myfrom'][$ii] : $mysql_input['myfrom'];

                $my_orderby = is_array($mysql_input['myorderby']) ? $mysql_input['myorderby'][$ii] : $mysql_input['myorderby'];
                $mysql_orderby = ($mysql_input['myorderby'] == '') ? '' : (' order by ' . $my_orderby);

                $mywhere = is_array($mysql_input['mywhere']) ? $mysql_input['mywhere'][$ii] : $mysql_input['mywhere'];
                $mysql_where = ($mysql_input['mywhere'] == '') ? '' : (' WHERE ' . $mywhere);

                $ret[$json_index_list[$ii]] = $conn->query(" SELECT " . $my_select . " FROM " . $my_from . $mysql_where . $mysql_orderby . ";")->fetchAll(PDO::FETCH_COLUMN);

            }

        } else {

            $mysql_orderby = ($mysql_input['myorderby'] == '') ? '' : (' order by ' . $mysql_input['myorderby']);
            $mysql_where = ($mysql_input['mywhere'] == '') ? '' : (' WHERE ' . $mysql_input['mywhere']);

            $ret[$json_index_list] = $conn->query(" SELECT " . $mysql_input['myselect'] . " FROM " . $mysql_input['myfrom'] . $mysql_where . $mysql_orderby . ";")->fetchAll(PDO::FETCH_COLUMN);

        }

        break;
    }

    $ret["result"] = 1;

    $callback = isset($_GET['callback']) ? trim($_GET['callback']) : ''; //jsonp回调参数，必需
    $tmp = json_encode($ret);
    echo $callback . '(' . $tmp . ')';

}


//---------------------------------//
function get_data_zhd_zfnl()
{
    $tol_dadui = array();
    $list_aver = array();
    $list_namenum = array();
    $list_chuqinlue = array();
    $list_tolscore = array();
    $list_averscore = array();
    $peixun_num = array();
    $temp = array();
    $tol = array();
    $date = recived_js_data('date');

    $date_arr = explode('$', $date);
    if (count($date_arr) == 1) {
        $date_sql = "LIKE '%$date_arr[0]%' ";
    } else {
        $date_sql = "BETWEEN '$date_arr[0]' AND '$date_arr[1]' ";
    }

    $daduiname = get_all_ddname_list();
    for ($i = 0; $i < count($daduiname); $i++) {

        $conn = null;
        $conn = connectDBbyddname($daduiname[$i]);
        if ($conn == null) return;

        //大队总分
        $score = null;
        $score = query_db_data_array($conn, "select score from person_enforce_capacity
        where date $date_sql;");
        //大队总分
        //大队平均分
        $tol[$i] = 0;
        for ($j = 0; $j < count($score); $j++) {
            $tol[$i] = $tol[$i] + $score[$j];
        }
        $tol_dadui[$i] = $tol[$i];


        $score_kaos = query_db_data_array($conn, "select score from person_enforce_capacity
            where category='考试' and date $date_sql;");
        //大队考试总分
        $tol[$i] = 0;
        for ($j = 0; $j < count($score_kaos); $j++) {
            $tol[$i] = $tol[$i] + $score_kaos[$j];
        }
        $list_tolscore[$i] = $tol[$i];

        //大队总考试成绩
        //$list_tolscore[$i]=send_tolscore($conn);
        //大队不同警员名字个数列表
        //lihai: add rank
        //$list_namenum[$i]=query_db_data_string($conn,"select count(distinct police_id) from personal_information;");
        $list_namenum[$i] = query_db_data_string($conn, "select count(distinct police_id) from personal_information where (rank='监督员' or rank='');");

        //echo $list_namenum[$i].'小子';
        //大队平均考试成绩
        if ($list_namenum[$i] > 0)
            $list_averscore[$i] = round($list_tolscore[$i] / $list_namenum[$i]);
        else  $list_averscore[$i] = 0;
        //number_format($number, 2, '.', '');
        //chuqin
        //平均培训分
        $peixun_num[$i] = query_db_data_string($conn, "select count(*) from person_enforce_capacity where category='培训' and date $date_sql;");
        if ($list_namenum[$i] > 0) {
            $chuqinlue[$i] = round($peixun_num[$i] / $list_namenum[$i]);//(30*$list_namenum[$i]);
            $chuqinlue[$i] = number_format($chuqinlue[$i], 2, '.', '');
        } else $chuqinlue[$i] = 0;

        //大队总平均分
        $list_aver[$i] = $list_averscore[$i] + $chuqinlue[$i];
    }
    //发送数据到前端js模块

    $max = 0;
    $temp = $list_averscore;
    sort($temp);
    $min = 0;//考试平均
    for ($i = 0; $i < count($list_averscore); $i++) {
        if ($temp[0] == $list_averscore[$i]) {
            $min = $i;
        }
        if (end($temp) == $list_averscore[$i]) {
            $max = $i;
        }

    }

    $temp1 = $list_aver;
    sort($temp1);
    $max1 = 0;
    $min1 = 0;//总平均
    for ($i1 = 0; $i1 < count($list_aver); $i1++) {
        if ($temp1[0] == $list_aver[$i1]) {
            $min1 = $i1;
        }
        if (end($temp1) == $list_aver[$i1]) {
            $max1 = $i1;
        }
    }

    $temp2 = $chuqinlue;
    sort($temp2);
    $max2 = 0;
    $min2 = 0;//培训平均
    for ($i2 = 0; $i2 < count($chuqinlue); $i2++) {
        if ($temp2[0] == $chuqinlue[$i2]) {
            $min2 = $i2;
        }
        if (end($temp2) == $chuqinlue[$i2]) {
            $max2 = $i2;
        }
    }
    $score_all = array(end($temp2), $temp2[0], end($temp), $temp[0], end($temp1), $temp1[0]);
    $ddname_all = array($daduiname[$max2], $daduiname[$min2], $daduiname[$max], $daduiname[$min], $daduiname[$max1], $daduiname[$min1]);

    $data["dd_name_list"] = $daduiname;//大队名字列表
    $data["dd_total_grade_list"] = $tol_dadui;//大队总成绩列表
    $data["dd_avetol_list"] = $list_aver;//大队总平均分
    $data["dd_avergrade_list"] = $list_averscore;//大队平均考试成绩
    $data["list_namenum"] = $list_namenum;//大队名字个数
    $data["chuqinlue"] = $chuqinlue;//平均培训成绩
    $data["s1"] = $ddname_all;    //信息提示框，培训，考试，总分 max,min对应大队名
    $data["s2"] = $score_all;     //信息提示框，培训，考试，总分 max,min对应值
    //$tmp=json_encode($data);
    return $data;

}

//---------------------------------//
////得到执法能力大队数据
function get_data_dadui_zfnl()
{

    $conn = null;
    $conn = connectDBbyddname(recived_js_data('dadui_name'));
    //$conn= connectDBbyddname('淮安区');
    if ($conn == null) return;

    ////////////////20170503cl
    $date = recived_js_data('date');
    //$date='2017-04';

    $date_arr = explode('$', $date);
    if (count($date_arr) == 1) {
        $date_sql = "LIKE '%$date_arr[0]%' ";
    } else {
        $date_sql = "BETWEEN '$date_arr[0]' AND '$date_arr[1]' ";
    }


    //获取不同警员名数组
    //lihai: add rank
    //$rows=query_db_data_array($conn,"select DISTINCT (police_name) from personal_information;");
    $rows = query_db_data_array($conn, "select DISTINCT (police_name) from personal_information where (rank='监督员' or rank='');");

    //异常处理

    if (count($rows) > 0) {
        $data["result"] = 1;
        //return $data;
    } else {
        $datab["result"] = 20;
        $callback = isset($_GET['callback']) ? trim($_GET['callback']) : '';
        $tmp = json_encode($datab);
        echo $callback . '(' . $tmp . ')';
        die();
    }

    $data["police_name_list"] = $rows;

    //获取不同警员号的数组
    //lihai: add rank
    //$rows_0=query_db_data_array($conn,"select DISTINCT (police_id) from personal_information;");
    $rows_0 = query_db_data_array($conn, "select DISTINCT (police_id) from personal_information where (rank='监督员' or rank='');");
    $data["police_id_list"] = $rows_0;

    //获得不同名字个数
    //lihai: add rank
    //$rows0=query_db_data_string($conn,"select COUNT(DISTINCT police_name) from  personal_information;");
    $rows0 = query_db_data_string($conn, "select COUNT(DISTINCT police_name) from  personal_information where (rank='监督员' or rank='');");


    ////
    /////cl 20170505
    /////

    //获得考试成绩和培训成绩
    //$rows3存放考试成绩
    //$rows4存放培训成绩
    $rows3 = array();
    $px_scoretol_array = array();
    $tol = array();
    for ($cc = 0; $cc < $rows0; $cc++) {
        //取得每个人考试成绩
        $avgcmd = "select sum(score) from person_enforce_capacity where police_id='$rows_0[$cc]' and category='考试' and date $date_sql";
        $result4 = $conn->query($avgcmd);
        list($rows3[$cc]) = $result4->fetch_row();
        $rows3[$cc] = (int)($rows3[$cc]);

        /////判断是否为空
        if (!$rows3[$cc])
            $rows3[$cc] = 0;

        //获得每个人培训成绩
        $avgcmd = "select sum(score) from person_enforce_capacity where police_id='$rows_0[$cc]' and category='培训' and date $date_sql";
        $result4 = $conn->query($avgcmd);
        list($px_scoretol_array[$cc]) = $result4->fetch_row();
        $px_scoretol_array[$cc] = (int)($px_scoretol_array[$cc]);

        /////判断是否为空
        if (!$px_scoretol_array[$cc])
            $px_scoretol_array[$cc] = 0;

        //得到总成绩
        $tol[$cc] = (int)($rows3[$cc] + $px_scoretol_array[$cc]);
    }

    ///////////////////////20170503cl
    //////////////////////20170503cl
    $temp = array();
    $temp = $rows3;
    sort($temp);
    $max = 0;
    $min = 0;//每个人考试分
    for ($i = 0; $i < count($rows3); $i++) {
        if ($temp[0] == $rows3[$i]) {
            $min = $i;
        }
        if (end($temp) == $rows3[$i]) {
            $max = $i;
        }

    }
    $temp1 = array();
    $temp1 = $px_scoretol_array;
    sort($temp1);
    $max1 = 0;
    $min1 = 0;//每个人培训总分
    for ($i1 = 0; $i1 < count($px_scoretol_array); $i1++) {
        if ($temp1[0] == $px_scoretol_array[$i1]) {
            $min1 = $i1;
        }
        if (end($temp1) == $px_scoretol_array[$i1]) {
            $max1 = $i1;
        }
    }
    $temp2 = array();
    $temp2 = $tol;
    sort($temp2);
    $max2 = 0;
    $min2 = 0;//每个人总分
    for ($i2 = 0; $i2 < count($tol); $i2++) {
        if ($temp2[0] == $tol[$i2]) {
            $min2 = $i2;
        }
        if (end($temp2) == $tol[$i2]) {
            $max2 = $i2;
        }
    }
    $score_all = array(end($temp1), $temp1[0], end($temp), $temp[0], end($temp2), $temp2[0],);
    $police_name_all = array($rows[$max1], $rows[$min1], $rows[$max], $rows[$min], $rows[$max2], $rows[$min2]);
    ////////////////////////////////


    //发送数据到前端js
    $data["gr_grade_list"] = $rows3;
    $data["gr_total_grade_list"] = $tol;
    $data["gr_pxgrade_list"] = $px_scoretol_array;

    /////添加组装数据
    //////////////////////20170503
    $data["s1"] = $police_name_all;
    $data["s2"] = $score_all;
    return $data;
    //大队名字代表空
    /////////////////////////////
}

//格式化日期
function format_date($date)
{
    $reg = '/\d{4}-\d{2}/';
    $arr = array();
    preg_match($reg, $date, $arr);
    return $arr[0];
}

function format_date_to_arr(&$date)
{
    $date = explode('$', $date);
    if (count($date) == 2) {
        return true;
    } else {
        $date = [$date[0] . '-01', $date[0] . '-31'];
        return true;
    }
}

function page_count($total, $each)
{
    $pages = ceil($total / $each);
    return $pages;
}

function get_zhidui_police_name()
{
    $dd_name_list = get_all_dd_name_list();
    $police_name_list = array();
    foreach ($dd_name_list as $key => $val) {

        $police_name_list =
            array_merge($police_name_list, get_all_police_name_list($key)["police_name"]);

    }
    return $police_name_list;
}

function get_all_police_name_list($dd_name)
{
    $conn = pdoConnect(getDBName('淮安支队', $dd_name));
    $jsonindexlist = ['police_name'];
    $mysqlinput = [
        'myselect' => ['DISTINCT (police_name)'],
        'myfrom' => 'personal_information',
        'mywhere' => 'rank="监督员"||rank=""',
        'myorderby' => ''
    ];
    $arr = mysql_pdo_select_arr($conn, $jsonindexlist, $mysqlinput);
    $conn = null;
    return $arr;
}

function get_all_dd_name_list()
{
    $DADUINameList = [
        '淮安区' => 'huaianqu_db',
        '淮阴区' => 'huaiyinqu_db',
        '涟水县' => 'lianshuixian_db',
        '盱眙县' => 'xuyixian_db',
        '开发区' => 'kaifaqu_db',
        '支队（机关）' => 'huaian_zdjg_db',
        '金湖县' => 'jinhuxian_db',
        '水上' => 'shuishang_db',
        '新城' => 'xincheng_db',
        '园区' => 'yuanqu_db',
        '洪泽县' => 'hongzexian_db',
        '清江' => 'qingjiang_db',
        '清浦' => 'qingpu_db',
        "zxpg_gzpc_db" => 'zxpg_gzpc_db'
    ];
    return $DADUINameList;
}

function mysql_pdo_select_arr($conn, $json_index_list, $mysql_input)
{
    $rst = 0;
    $ret = array();
    while (true) {
        if ($conn == null) {
            $rst = 101;
            break;
        }
        if (is_array($json_index_list)) {
            for ($ii = 0; $ii < count($json_index_list); $ii++) {
                $my_select = is_array($mysql_input['myselect']) ? $mysql_input['myselect'][$ii] : $mysql_input['myselect'];
                $my_from = is_array($mysql_input['myfrom']) ? $mysql_input['myfrom'][$ii] : $mysql_input['myfrom'];

                $my_orderby = is_array($mysql_input['myorderby']) ? $mysql_input['myorderby'][$ii] : $mysql_input['myorderby'];
                $mysql_orderby = ($mysql_input['myorderby'] == '') ? '' : (' order by ' . $my_orderby);

                $mywhere = is_array($mysql_input['mywhere']) ? $mysql_input['mywhere'][$ii] : $mysql_input['mywhere'];
                $mysql_where = ($mysql_input['mywhere'] == '') ? '' : (' WHERE ' . $mywhere);

                $ret[$json_index_list[$ii]] = $conn->query(" SELECT " . $my_select . " FROM " . $my_from . $mysql_where . $mysql_orderby . ";")->fetchAll(PDO::FETCH_COLUMN);

            }
        } else {

            $mysql_orderby = ($mysql_input['myorderby'] == '') ? '' : (' order by ' . $mysql_input['myorderby']);
            $mysql_where = ($mysql_input['mywhere'] == '') ? '' : (' WHERE ' . $mysql_input['mywhere']);
            $ret[$json_index_list] = $conn->query(" SELECT " . $mysql_input['myselect'] . " FROM " . $mysql_input['myfrom'] . $mysql_where . $mysql_orderby . ";")->fetchAll(PDO::FETCH_COLUMN);
        }
        break;
    }
//	$callback =isset($_GET['callback']) ? trim($_GET['callback']) : ''; //jsonp回调参数，必需
//	$tmp=json_encode($ret);
//	echo $callback . '(' . $tmp .')';
    return $ret;
}

?>
