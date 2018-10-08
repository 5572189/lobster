<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
// 模块信息配置
return array(
	// @formatter:off
	'info' => array (
		'name' => 'User',
		'title' => '用户',
		'icon' => 'fa fa-users',
		'icon_color' => '#9933FF',
		'description' => '用户模块',
		'developer' => '诺伯丝聚酿国际贸易（上海）有限公司',
		'website' => 'http://www.noble-spirits.com',
		'version' => '1.0.0',
		'dependences' => array (
			'Admin' => '1.0.0' 
		) 
	),
	// @formatter:on
	'user_nav' => array(), 
	'admin_menu' => array(1 => array('id' => 1, 'pid' => '0', 'title' => '用户', 'url' => '', 'icon' => 'fa fa-users'), 
		2 => array('pid' => '1', 'title' => '用户管理', 'icon' => 'fa fa-users', 'id' => 2), 
		3 => array('pid' => '2', 'title' => '用户列表', 'icon' => 'fa fa-users', 'url' => 'User/user/list_personal_member', 'id' => 3), 
		301 => array('pid' => '3', 'title' => '导出', 'icon' => 'fa fa-users', 'url' => 'User/user/export_personal_member', 'id' => 301), 
		// 4 => array('pid' => '2', 'title' => '用户消费统计', 'icon' => 'fa fa-users', 'url' => 'User/consume/index', 'id' => 4),
		202 => array('id' => 202, 'pid' => '2', 'title' => '新会员统计', 'url' => 'user/user/summary_personal_member', 'icon' => 'fa fa-user')));