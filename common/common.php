<?php

require_once __DIR__ . '/base.php';

$DADUIName_Database = [
        '淮安区' => 'huaianqu_db', '淮阴区' => 'huaiyinqu_db', 
        '清江浦区' => 'qingjiangpuqu_db',
        '涟水县' => 'lianshuixian_db', 
        '盱眙县' => 'xuyixian_db', 
        '开发区' => 'kaifaqu_db',
        '支队（机关）' => 'huaian_zdjg_db', 
        '金湖县' => 'jinhuxian_db', '水上' => 'shuishang_db',
        '新城' => 'xincheng_db', 
        '园区' => 'yuanqu_db', '洪泽县' => 'hongzexian_db', 
        '清江' => 'qingjiang_db',
        '清浦' => 'qingpu_db'
    ];

function get_dadui_list()
{   
	$conn=pdoConnect('huaianzhd_db');
	
	$jsonindexlist = [
			//'dadui_no',
			'dadui_name',
			//'dadui_dist'
		];
	$mysqlinput = [
									'myselect'=>[
										//'dadui_no',
										'dadui_name',
										//'dadui_dist'
									],
									'myfrom'=> 'dadui_name_list',
									'mywhere' => '',
									'myorderby' => ''
								];

	return mysql_pdo_select_arr($conn,$jsonindexlist,$mysqlinput);
}

function get_police_name($db_name)
{   
	$conn=pdoConnect($db_name);
	
	$jsonindexlist = ['police_name'];
	$mysqlinput = [
									'myselect'=>['DISTINCT (police_name)'],
									'myfrom'=> 'personal_information',
									'mywhere' => 'rank="监督员"||rank=""',
									'myorderby' => ''
								];

	return mysql_pdo_select_arr($conn,$jsonindexlist,$mysqlinput);
}



$dd_name_list = get_dadui_list()['dadui_name'];

// var_dump($dd_name_list);

foreach( $DADUIName_Database as $dd_name => $dd_db ){
	
	// echo $dd_name;
	// echo "\n";
	print_r(get_police_name($dd_db));	
	//print_r($dd_name);

}

