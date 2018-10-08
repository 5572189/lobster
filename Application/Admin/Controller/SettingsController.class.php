<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Builder\ListBuilder;

/**
 * 部门控制器
 */
class SettingsController extends AdminController {
	/**
	 * 部门列表
	 */
	public function index() {
	}
	public function list_city() {
		$lang = I ('lang', 'cn');
		$cityObject = M ('city');
		$map = [];
		$data_list = $cityObject->where ($map)
			->select ();
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder ();
		$builder->setMetaTitle ('城市列表')
			->addTopButton ('addnew', ['href' => U ('add_city')])
			->setTabNav (['cn' => ['title' => '中文', 'href' => U ('', ['lang' => 'cn'])], 'en' => ['title' => '英文', 'href' => U ('', ['lang' => 'en'])]], $lang)
			->addTableColumn ('id', 'ID')
			->addTableColumn ('name', '城市名称')
			->addTableColumn ('status', '状态', 'status')
			->addTableColumn ('sort', '排序')
			->addTableColumn ('right_button', '操作', 'btn')
			->setTableDataList ($data_list)
			->addRightButton ('self', array('title' => '编辑', 'class' => 'label label-primary', 'href' => U ('edit_city', ['id' => '__data_id__'])))
			->addRightButton ('forbid', ['model' => 'city'])
			->display ();
	}
	/**
	 * 编辑
	 */
	public function edit_city($id) {
		if (IS_POST) {
			$area_object = D ('Admin/city');
			$data = $area_object->create ();
			if ($data) {
				if (false !== $area_object->save ($data)) {
					$this->success ('更新成功', U ('list_city'));
				} else {
					$this->error ('更新失败');
				}
			} else {
				$this->error ($area_object->getError ());
			}
		} else {
			$info = D ('Admin/city')->find ($id);
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('编辑地域')
				->setPostUrl (U ('edit_city'))
				->addFormItem ('id', 'hidden', 'ID', 'ID')
				->addFormItem ('name', 'text', '城市名称', '城市名称')
				->addFormItem ('sort', 'num', '排序', '用于显示的排序')
				->addFormItem ('status', 'radio', '是否可用', '是否可用', ['1' => '可用', '0' => '禁用'])
				->setFormData ($info)
				->display ();
		}
	}
	
	/**
	 * 添加
	 */
	public function add_city() {
		if (IS_POST) {
			$area_object = D ('Admin/city');
			$data = $area_object->create ();
			if ($data) {
				if ($area_object->add ($data)) {
					// 更新商品表数据，方便执行定时脚本更新城市价格
					M ('shoppingmall_goods')->save (['city_status' => 0]);
					$this->success ('添加成功', U ('list_city'));
				} else {
					$this->error ('添加失败', U ('list_city'));
				}
			} else {
				$this->error ($area_object->getError ());
			}
		}
		$info = ['status' => 1, 'sort' => 1];
		$builder = new \Common\Builder\FormBuilder ();
		$builder->setMetaTitle ('添加城市')
			->setPostUrl (U ('add_city'))
			->addFormItem ('name', 'text', '城市名称', '城市名称')
			->addFormItem ('sort', 'num', '排序', '用于显示的排序')
			->addFormItem ('status', 'radio', '是否可用', '是否可用', ['1' => '可用', '0' => '禁用'])
			->setFormData ($info)
			->display ();
	}
	
	// 商品列表
	public function list_level() {
		$map = [];
		$search_name = I ('card_level_name', '', 'string');
		if ($search_name) {
			$map['card_level_name'] = ['like', "%{$search_name}%"];
		}
		
		/*
		 * $lang = I('lang' , 'cn');
		 * $map['lang'] = $lang;
		 */
		list ($data_list, $page, $model_object) = $this->lists ('user_level_config', $map, 'card_level ASC');
		// 使用Builder快速建立列表页面。
		$builder = new ListBuilder ();
		foreach ( $data_list as $k => $d ) {
			$data_list[$k]['user_type'] = $d['user_type'] == 0 ? '普通用户' : '企业用户';
		}
		$extra_url = U ('add_level');
		$builder->setMetaTitle ('用户等级列表')
			->addTopButton ('addnew', ['href' => $extra_url])
			->addTableColumn ('user_type', '用户类型')
			->addTableColumn ('card_level', '等级')
			->addTableColumn ('card_level_name', '中文名称')
			->addTableColumn ('card_level_name_en', '英文名称')
			->addTableColumn ('need_coins', '所需金币')
			->addTableColumn ('right_button', '操作', 'btn')
			->addRightButton ('self', array('title' => '编辑', 'class' => 'label label-primary', 'href' => U ('edit_level', ['id' => '__data_id__'])))
			->setTableDataList ($data_list)
			->display ();
	}
	
	// 添加
	public function add_level() {
		$model_object = M ('user_level_config');
		// $lang = I('lang','cn');
		if (IS_POST) {
			$post = I ('post.');
			if (!$data = $model_object->create ($post)) {
				$this->error ($model_object->getError ());
			} else {
				if ($model_object->add ($data)) {
					$this->success ('添加成功', U ('list_level'));
				} else {
					$this->error ('添加失败');
				}
			}
		} else {
			// $this->assign('lang',$lang);
			$this->assign ('status', 1);
			$this->display ();
		}
	}
	
	// 修改分类
	public function edit_level($id) {
		$model_object = M ('user_level_config');
		$info = $model_object->find ($id);
		// $lang = $info['lang'];
		// $other = $model_object->where(['card_level'=>$info['card_level']])->find();
		if (IS_POST) {
			$post = I ('post.');
			// $post['canpub_goods'] = implode(',', I('post.canpub_goods/a'));
			if (!$data = $model_object->create ($post)) {
				$this->error ($model_object->getError ());
			} else {
				if (false != $model_object->where (['id' => $id])
					->save ($data)) {
					$this->success ('更新成功', U ('list_level'));
				} else {
					trace ($model_object->getError ());
					$this->error ('更新失败');
				}
			}
		} else {
			// $this->assign('other',$other);
			$this->assign ('info', $info);
			$this->display ();
		}
	}
}
