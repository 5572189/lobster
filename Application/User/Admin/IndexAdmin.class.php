<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace User\Admin;

use Admin\Controller\AdminController;

/**
 * 默认控制器
 */
class IndexAdmin extends AdminController {
	public function index() {
		if (C ('ADMIN_TABS')) {
			// 获取所有模块信息及后台菜单
			$menu_list = D ('Admin/Module')->getAllMenu ();
			$this->assign ('_menu_list', $menu_list); // 后台左侧菜单
			                                             // 获取快捷链接
			$link_list = D ('Admin/Link')->getAll ();
			$this->assign ('_link_list', $link_list); // 后台快捷链接
		}
		
		$this->assign ('meta_title', "");
		$this->display ();
	}
}
