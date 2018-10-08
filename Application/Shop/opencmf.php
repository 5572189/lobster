<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
// 模块信息配置
return array(
	// @formatter:off
	'info' => array (
		'name' => 'Shop',
		'title' => '餐厅管理',
		'icon' => 'fa fa-th',
		'icon_color' => '#9933FF',
		'description' => '餐厅模块',
		'developer' => '诺伯丝聚酿国际贸易（上海）有限公司',
		'website' => '',
		'version' => '1.0.0',
		'dependences' => array (
			'Admin' => '1.0.0',
		),
	),
	// @formatter:on
	'admin_menu' => array(1 => array('id' => 1, 'pid' => '0', 'title' => '餐厅', 'url' => '', 'icon' => 'fa fa-th'), 
		2 => array('pid' => '1', 'title' => '餐厅管理', 'icon' => 'fa fa-folder-open-o', 'id' => 2), 
		3 => array('pid' => '2', 'title' => '餐厅列表', 'icon' => '', 'url' => 'Shop/index/index', 'id' => 3), 
		301 => array('pid' => '3', 'title' => '新增', 'icon' => '', 'url' => 'Shop/index/add', 'id' => 301), 
		302 => array('pid' => '3', 'title' => '编辑', 'icon' => '', 'url' => 'Shop/index/edit', 'id' => 302), 
// 		4 => array('pid' => '2', 'title' => '餐厅消费记录', 'icon' => '', 'url' => 'Shop/consume/index', 'id' => 4), 
// 		401 => array('pid' => '4', 'title' => '导出', 'icon' => '', 'url' => 'Shop/consume/export', 'id' => 401)
	));