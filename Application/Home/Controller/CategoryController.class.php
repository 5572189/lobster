<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Home\Controller;

/**
 * 分类控制器
 */
class CategoryController extends BaseController {

	public function ajax_getDetail() {
		if (IS_AJAX) {
			$id = I ('post.id', 0);
		} else {
			$this->error ();
		}
		switch ($id) {
			case 1 : // 关于我们
				$data = D ('Cms/Customcms', 'Logic')->aboutUs ();
				break;
			default :
				$data = [];
				break;
		}
		
		$this->ajaxReturn ($data, 'JSON');
		exit ();
	}
	public function ajax_getMenuList() {
		if (IS_AJAX) {
			$data = D ('Cms/Customcms', 'Logic')->menuList ();
			$this->ajaxReturn ($data, 'JSON');
		} else {
			$this->error ();
		}
	}
	public function ajax_getVideoList() {
		if (IS_AJAX) {
			$data = D ('Cms/Customcms', 'Logic')->videoList ();
			$this->ajaxReturn ($data, 'JSON');
		} else {
			$this->error ();
		}
	}
	public function ajax_getNewsList() {
		if (IS_AJAX) {
			$data = D ('Cms/Customcms', 'Logic')->newsList ();
			$this->ajaxReturn ($data, 'JSON');
		} else {
			$this->error ();
		}
	}
	public function ajax_getNextNews() {
		if (IS_AJAX) {
			$curId = I ('post.id', 0);
			$dir = I ('post.dir', 0);
			$data = D ('Cms/Customcms', 'Logic')->getNextNews ($curId, $dir);
			$this->ajaxReturn ($data, 'JSON');
		} else {
			$this->error ();
		}
	}
}
