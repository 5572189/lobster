<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Admin\Controller;

/**
 * 后台默认控制器
 */
class IndexController extends AdminController {
	/**
	 * 默认方法
	 */
	public function index() {
		if (C ('ADMIN_TABS')) {
			// 获取所有模块信息及后台菜单
			$menu_list = D ('Admin/Module')->getAllMenu ();
			$this->assign ('_menu_list', $menu_list); // 后台左侧菜单
			                                          
			// 获取快捷链接
			$link_list = D ('Admin/Link')->getAll ();
			$this->assign ('_link_list', $link_list); // 后台快捷链接
		}
		
		$this->assign ('meta_title', "首页");
		$this->display ();
	}
	
	/**
	 * 删除缓存
	 */
	public function removeRuntime() {
		$file = new \Common\Util\File ();
		$result = $file->del_dir (RUNTIME_PATH);
		if ($result) {
			$this->success ("缓存清理成功");
		} else {
			$this->error ("缓存清理失败");
		}
	}
}


