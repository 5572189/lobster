<?php

/**
 * 语言管理
 */
namespace Admin\Controller;

use Admin\Controller\AdminController;
use Common\Builder\FormBuilder;
use Common\Builder\ListBuilder;

class LanguageController extends AdminController {
	public function index() {
		$map = [];
		$keyword = I ('keyword', '', 'string');
		if ($keyword != '') {
			$map['cntitle|entitle|name'] = [['like', "%{$keyword}%"], ['like', "%{$keyword}%"], ['like', "%{$keyword}%"], '_multi' => true];
		}
		list ($data_list, $page, $model_object) = $this->lists ('language', $map);
		$deleteBtn = ['name' => 'delete', 'title' => '删除', 'class' => 'label label-danger-outline label-pill ajax-get confirm', 'model' => CONTROLLER_NAME, 
			'href' => U ('setStatus', ['status' => 'delete', 'ids' => '__data_id__', 'model' => CONTROLLER_NAME, 'ajax' => 1])];
		// 使用Builder快速建立列表页面。
		$builder = new ListBuilder ();
		$builder->setMetaTitle ('语言字段列表')
			->addTopButton ('addnew')
			->addSearchItem ('keyword', 'text', '', '字段|中文|英文名称')
			->addTopButton ('self', array('title' => '更新数据', 'class' => 'btn btn-info-outline btn-pill ajax-get', 'href' => U ('/Admin/Language/update')))
			->addTopButton ('delete')
			->addTableColumn ('name', "字段名")
			->addTableColumn ('cntitle', "中文名称")
			->addTableColumn ('entitle', "英文名称")
			->addTableColumn ('right_button', '操作管理', 'btn')
			->setTableDataList ($data_list)
			->setTableDataPage ($page->show ())
			->addRightButton ('edit')
			->addRightButton ('self', $deleteBtn)
			->display ();
	}
	public function add() {
		if (IS_POST) {
			$model_object = D ('language');
			if (!$data = $model_object->create ()) {
				$this->error ($model_object->getError ());
			} else {
				$data['name'] = $_POST['name']; // 'lg_' .
				$result = M ('language')->where (['name' => $data['name']])
					->find ();
				if ($result) {
					$this->error ('添加失败,字段已经存在');
				} else {
					if ($model_object->add ($data)) {
						$this->success ('添加成功');
					} else {
						trace ($model_object->getError ());
						$this->error ('添加失败');
					}
				}
			}
		} else {
			// 使用FormBuilder快速建立表单页面
			$builder = new FormBuilder ();
			$builder->setMetaTitle ('新增')
				->setPostUrl (U ())
				->addFormItem ('name', 'text', '字段名称', '请输入字段名称')
				->addFormItem ('cntitle', 'text', '中文名称', '请输入中文名称')
				->addFormItem ('entitle', 'text', '英文名称', '请输入英文名称')
				->display ();
		}
	}
	public function edit($id) {
		if (IS_POST) {
			$model_object = D ('language');
			$data = $model_object->create ();
			if ($data) {
				$id = $model_object->save ($data);
				if ($id !== false) {
					$this->success ('更新成功', U ('index'));
				} else {
					$this->error ('更新失败');
				}
			} else {
				$this->error ($model_object->getError ());
			}
		} else {
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('编辑语言')
				->setPostUrl (U ('', ['id' => $id]))
				->addFormItem ('id', 'hidden', 'ID', 'ID')
				->addFormItem ('name', 'hidden', '字段名称', '请输入字段名称')
				->addFormItem ('cntitle', 'text', '中文名称', '请输入中文名称')
				->addFormItem ('entitle', 'text', '英文名称', '请输入英文名称')
				->setFormData (D ('language')->find ($id))
				->display ();
		}
	}
	
	// 更新缓存数据
	public function update() {
		if (IS_AJAX) {
			$reuslt = M ('language')->select ();
			toConfig ($reuslt, 'cn');
			toConfig ($reuslt, 'en');
			if (!$ajax = I ('ajax', 0)) {
				$this->success ('更新成功');
			}
		}
	}
	
	/**
	 * 设置一条或者多条数据的状态
	 *
	 * @param $script 严格模式要求处理的纪录的uid等于当前登陆用户UID        	
	 *
	 */
	public function setStatus($model = CONTROLLER_NAME, $script = false) {
		$ids = I ('request.ids');
		$status = I ('request.status');
		if (empty ($ids)) {
			$this->error ('请选择要操作的数据');
		}
		$model_primary_key = D ($model)->getPk ();
		$map[$model_primary_key] = array('in', $ids);
		if ($script) {
			$map['uid'] = array('eq', is_login ());
		}
		switch ($status) {
			case 'delete' : // 删除条目
				$result = D ($model)->where ($map)
					->delete ();
				if ($result) {
					$this->update ();
					$this->success ('删除成功，不可恢复！');
				} else {
					$this->error ('删除失败');
				}
				break;
			default :
				$this->error ('参数错误');
				break;
		}
	}
}
