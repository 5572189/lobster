<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Util\Think\Page;

/**
 * 微信推送
 */
class WxnotifyConfigController extends AdminController {
	/**
	 * 默认方法
	 */
	public function index() {
		// 获取列表
		$map = '1';
		$p = I ('p', 1);
		$model_object = D ("wxnotify_config");
		$data_list = $model_object->page ($p, C ("ADMIN_PAGE_ROWS"))
			->where ($map)
			->order ("id desc")
			->select ();
		$page = new Page ($model_object->where ($map)
			->count (), C ("ADMIN_PAGE_ROWS"));
		
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder ();
		$builder->setMetaTitle ("推送列表")
			->addTopButton ("addnew")
			->addTableColumn ("id", "编号")
			->addTableColumn ("name", "消息推送场景")
			->addTableColumn ("right_button", "操作管理", "btn")
			->setTableDataList ($data_list)
			->setTableDataPage ($page->show ())
			->addRightButton ("edit")
			->addRightButton ("delete")
			->display ();
	}
	
	// 添加微信菜单
	public function add() {
		if (IS_POST) {
			if (D ('wxnotify_config')->add (I ('post.'))) {
				$this->success ('添加成功', U ('index'));
			} else {
				trace (D ('wxnotify_config')->getError ());
				$this->error ('添加失败');
			}
		} else {
			
			// 使用FormBuilder快速建立表单页面
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('新增')
				->setPostUrl (U ('add'))
				->addFormItem ('name', 'text', '消息推送场景', '')
				->addFormItem ('first', 'text', 'first', '')
				->addFormItem ('keyword1', 'text', 'keyword1', '')
				->addFormItem ('keyword2', 'text', 'keyword2', '')
				->addFormItem ('remark', 'textarea', 'remark', '')
				->addFormItem ('link', 'text', '链接', '')
				->display ();
		}
	}
	
	// 编辑微信菜单
	public function edit($id) {
		if (IS_POST) {
			if (false !== D ('wxnotify_config')->where (['id' => $id])
				->save (I ('post.'))) {
				$this->success ('更新成功', U ('index'));
			} else {
				$this->error ('更新失败');
			}
		} else {
			$data = D ('wxnotify_config')->find ($id);
			// 使用FormBuilder快速建立表单页面
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('编辑')
				->setPostUrl (U ('edit'))
				->addFormItem ('name', 'text', '消息推送场景', '')
				->addFormItem ('first', 'text', 'first', '')
				->addFormItem ('keyword1', 'text', 'keyword1', '')
				->addFormItem ('keyword2', 'text', 'keyword2', '')
				->addFormItem ('remark', 'textarea', 'remark', '')
				->addFormItem ('link', 'text', '链接', '')
				->addFormItem ('id', 'hidden', 'id', '')
				->setFormData ($data)
				->display ();
		}
	}
}
