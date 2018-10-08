<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
// 模块信息配置
return array(
	// @formatter:off
	'info' => array (
		'name' => 'Cms',
		'title' => 'CMS',
		'icon' => 'fa fa-newspaper-o',
		'icon_color' => '#9933FF',
		'description' => '门户模块',
		'developer' => '诺伯丝聚酿国际贸易（上海）有限公司',
		'website' => 'http://www.noble-spirits.com',
		'version' => '1.0.0',
		'dependences' => array (
			'Admin' => '1.0.0',
		),
	),
	'user_nav' => array('center' => array(0 => array('title' => '我的文档', 'icon' => 'fa fa-list', 'url' => 'Cms/Index/my'))), 
	'config' => array(
		'need_check' => array(
			'title' => '前台发布审核', 
			'type' => 'radio', 
			'options' => array(1 => '需要', 0 => '不需要'), 
			'value' => '0'), 
		'toggle_comment' => array(
			'title' => '是否允许评论文档', 
			'type' => 'radio', 
			'options' => array(1 => '允许', 0 => '不允许'), 
			'value' => '1'), 
		'group_list' => array(
			'title' => '栏目分组', 
			'type' => 'array', 
			'value' => '1:默认'), 
		'cate' => array(
			'title' => '首页栏目自定义', 
			'type' => 'array', 
			'value' => 'a:1'), 
		'taglib' => array(
			'title' => '加载标签库', 
			'type' => 'checkbox', 
			'options' => array('Cms' => 'Cms'), 
			'value' => array(0 => 'Cms'))), 
	// @formatter:on
	'admin_menu' => array(1 => array('id' => 1, 'pid' => '0', 'title' => 'CMS', 'url' => '', 'icon' => 'fa fa-newspaper-o'), 
		101 => array('id' => 101, 'pid' => '1', 'title' => '内容管理', 'icon' => 'fa fa-folder-open-o'), 
		10101 => array('id' => 10101, 'pid' => '101', 'title' => '文档模型', 'icon' => 'fa fa-th-large', 'url' => 'Cms/Type/index'), 
		1010101 => array('id' => 1010101, 'pid' => '10101', 'title' => '新增文档模型', 'url' => 'Cms/Type/add'), 
		1010102 => array('id' => 1010102, 'pid' => '10101', 'title' => '编辑文档模型', 'url' => 'Cms/Type/edit'), 
		1010103 => array('id' => 1010103, 'pid' => '10101', 'title' => '设置文档模型状态', 'url' => 'Cms/Type/setStatus'), 
		1010104 => array('id' => 1010104, 'pid' => '10101', 'title' => '字段管理', 'icon' => 'fa fa-database', 'url' => 'Cms/Attribute/index'), 
		101010401 => array('id' => 101010401, 'pid' => '1010104', 'title' => '新增字段', 'url' => 'Cms/Attribute/add'), 
		101010402 => array('id' => 101010402, 'pid' => '1010104', 'title' => '编辑字段', 'url' => 'Cms/Attribute/edit'), 
		101010403 => array('id' => 101010403, 'pid' => '1010104', 'title' => '设置字段状态', 'url' => 'Cms/Attribute/setStatus'), 
		
		10102 => array('id' => 10102, 'pid' => '101', 'title' => '栏目分类', 'icon' => 'fa fa-navicon', 'url' => 'Cms/Category/index'), 
		1010201 => array('id' => 1010201, 'pid' => '10102', 'title' => '新增栏目', 'url' => 'Cms/Category/add'), 
		1010202 => array('id' => 1010202, 'pid' => '10102', 'title' => '编辑栏目', 'url' => 'Cms/Category/edit'), 
		1010203 => array('id' => 1010203, 'pid' => '10102', 'title' => '设置栏目状态', 'url' => 'Cms/Category/setStatus'), 
		
		10103 => array('id' => 10103, 'pid' => '101', 'title' => '文章管理', 'icon' => 'fa fa-edit', 'url' => 'Cms/Index/index'), 
		1010301 => array('id' => 1010301, 'pid' => '10103', 'title' => '新增文章', 'url' => 'Cms/Index/add'), 
		1010302 => array('id' => 1010302, 'pid' => '10103', 'title' => '编辑文章', 'url' => 'Cms/Index/edit'), 
		1010310 => array('id' => 1010310, 'pid' => '10103', 'title' => '编辑分类', 'url' => 'cms/category/edit_with_tree', 'icon' => 'fa '), 
		1010311 => array('id' => 1010311, 'pid' => '10103', 'title' => '启用文章', 'url' => 'cms/index/setstatus/status/resume', 'icon' => 'fa '), 
		1010312 => array('id' => 1010312, 'pid' => '10103', 'title' => '禁用文章', 'url' => 'cms/index/setstatus/status/forbid', 'icon' => 'fa '), 
		
		10104 => array('id' => 10104, 'pid' => '101', 'title' => '广告管理', 'url' => 'Cms/Slider/index', 'icon' => 'fa fa-image'), 
		1010401 => array('id' => 1010401, 'pid' => '10104', 'title' => '新增广告', 'url' => 'Cms/Slider/add'), 
		1010402 => array('id' => 1010402, 'pid' => '10104', 'title' => '编辑广告', 'url' => 'cms/slider/edit', 'icon' => 'fa '), 
		1010403 => array('id' => 1010403, 'pid' => '10104', 'title' => '设置广告状态', 'url' => 'cms/slider/setstatus/status/forbid', 'icon' => 'fa '))

	);