<?php

/**
 * @title : 弹框设置控制器
 * @time  : 2017年11月1日/下午4:43:31
 */
namespace Admin\Controller;

class BombboxController extends AdminController {
	private $_platform = [1 => '微信/pc', 2 => 'ios/android', 3 => '微信/pc/ios/android'];
	private $_position = [1 => '首页'];
	/**
	 * @title : 列表
	 * @time : 2017年11月1日/下午4:44:17
	 */
	public function index() {
		$where = [];
		$where['deleted'] = ['eq', 1];
		$pf = I ('get.pf', 0);
		if ($pf) {
			$where['platform'] = ['eq', $pf];
		}
		$list = M ('bomb_box_config')->where ($where)
			->limit ((I ('get.p', 1) - 1) * C ("ADMIN_PAGE_ROWS"), C ("ADMIN_PAGE_ROWS"))
			->order ('id desc')
			->select ();
		$pages = new \Common\Util\Think\Page (M ('bomb_box_config')->where ($where)
			->order ('id desc')
			->count (), C ("ADMIN_PAGE_ROWS"));
		$this->assign ('list', $list);
		$this->assign ('pages', $pages->show ());
		$this->assign ('platform', $this->_platform);
		$this->assign ('get', I ('get.'));
		$this->assign ('position', $this->_position);
		$this->display ();
	}
	
	/**
	 * @title : 新增或者修改
	 * @time : 2017年11月1日/下午4:50:56
	 */
	public function add() {
		if (IS_POST) {
			$post = I ('post.');
			$id = $post['id'];
			unset ($post['id']);
			if ($id) {
				// 修改
				$post['update_time'] = time ();
				$bool = M ('bomb_box_config')->where (['id' => intval ($id)])
					->save ($post);
			} else {
				// 添加
				$post['deleted'] = 1;
				$post['create_time'] = $post['update_time'] = time ();
				$bool = M ('bomb_box_config')->add ($post);
			}
			if ($bool) {
				$this->success ('操作成功。');
			} else {
				$this->error ('操作失败');
			}
		} else {
			$id = I ('get.id', 0);
			$data = M ('bomb_box_config')->find ($id);
			if (empty ($data)) {
				$data['platform'] = 1;
			}
			$this->assign ('data', $data);
			$this->assign ('platform', $this->_platform);
			$this->assign ('position', $this->_position);
			$this->display ();
		}
	}
	
	/**
	 * @title : 修改状态
	 * @time : 2017年11月3日/下午2:39:51
	 */
	public function update() {
		if (IS_AJAX) {
			$post = I ('get.');
			$values = [];
			$values['update_time'] = time ();
			$values['status'] = $post['status'];
			if (M ('bomb_box_config')->where (['id' => $post['id']])
				->save ($values)) {
				$this->success ('操作成功');
			} else {
				$this->error ('操作失败');
			}
		}
	}
	
	/**
	 * @title : 删除记录
	 * @time : 2017年11月3日/下午2:47:49
	 */
	public function del() {
		if (IS_AJAX) {
			$get = I ('get.');
			$values = [];
			$values['update_time'] = time ();
			$values['deleted'] = $get['deleted'];
			$values['status'] = $get['status'];
			if (M ('bomb_box_config')->where (['id' => $get['id']])
				->save ($values)) {
				$this->success ('操作成功');
			} else {
				$this->error ('操作失败');
			}
		}
	}
}