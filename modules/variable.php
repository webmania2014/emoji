<?php
	$arrMenu = array(
		'admin'				=> array( 'title' => '系统管理人管理',	'show' => true ),
		'company'			=> array( 'title' => '客户公司管理',		'show' => true ),
		'function'			=> array( 'title' => 'API管理',			'show' => true ),
		'order_list'		=> array( 'title' => '订单目录',			'show' => true ),
		'order_failed_list' => array( 'title' => '订单接收失败目录',	'show' => true ),
		'import_order_result' => array( 'title' => '上载订单结果', 'show' => true ),
		'system_setting'	=> array( 'title' => '系统管理',			'show' => true ),
		'change_profile'	=> array( 'title' => '密码变更',			'show' => false ),
		'add_admin'			=> array( 'title' => '新建管理人',		'show' => false ),
		'add_company'		=> array( 'title' => '新建客户公司',		'show' => false ),
		'change_company'	=> array( 'title' => '更改客户公司信息',	'show' => false ),
		'add_function'		=> array( 'title' => '新建API信息',		'show' => false ),
	);

	$arrCompanyOrderListTable = array (
		'SBSC' => 'tblsbscorderlist'
	);
?>