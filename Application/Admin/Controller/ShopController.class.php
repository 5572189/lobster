<?php

/**
 * 门店管理
 * User: whm
 * Date: 2016/9/19
 * Time: 22:29
 */
namespace Admin\Controller;

use Common\Util\Think\Page;

/**
 * 门店控制器
 */
class ShopController extends AdminController {
	/**
	 * 门店列表
	 */
	public function index() {
		// 搜索
		$keyword = I ('keyword', '', 'string');
		$condition = array('like', '%' . $keyword . '%');
		$map['id|username'] = array($condition, $condition, '_multi' => true);
		
		// 获取所有门店
		$map['status'] = array('egt', '0'); // 禁用和正常状态
		$map['is_shop'] = 1;
		$p = !empty ($_GET["p"]) ? $_GET['p'] : 1;
		$user_object = D ('Shop');
		$data_list = $user_object->page ($p, C ('ADMIN_PAGE_ROWS'))
			->where ($map)
			->order ('id desc')
			->select ();
		$page = new Page ($user_object->where ($map)
			->count (), C ('ADMIN_PAGE_ROWS'));
		
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder ();
		$builder->setMetaTitle ('用户列表')
			->addTopButton ('addnew')
			->addTopButton ('resume')
			->addTopButton ('forbid')
			->addTopButton ('delete')
			->setSearch ('请输入ID/用户名', U ('index'))
			->addTableColumn ('id', 'ID')
			->addTableColumn ('shop_logo', '门店图标', 'picture')
			->addTableColumn ('username', '用户名')
			->addTableColumn ('shop_name', '门店名称')
			->addTableColumn ('shop_phone', '门店电话')
			->addTableColumn ('shop_address', '门店地址')
		   /* ->addTableColumn('level', '门店级别')*/
			->addTableColumn ('status', '状态', 'status')
			->addTableColumn ('right_button', '操作', 'btn')
			->setTableDataList ($data_list)
			->setTableDataPage ($page->show ())
			->addRightButton ('edit')
			->addRightButton ('forbid')
			->addRightButton ('recycle')
			->display ();
	}
	
	/**
	 * 新增门店
	 */
	public function add() {
		if (IS_POST) {
			$user_object = D ('Shop');
			$data = $user_object->create ();
			$return = file_get_contents ("http://apis.map.qq.com/ws/geocoder/v1/?address={$data['shop_address']}&output=json&key=O5BBZ-IUX65-YRBIB-QZRXG-LBFBT-A7FUR");
			$return = json_decode ($return);
			$data['lng'] = $data['lat'] = 0;
			if (isset ($return->result->location->lng)) {
				$data['lng'] = $return->result->location->lng;
			}
			if (isset ($return->result->location->lat)) {
				$data['lat'] = $return->result->location->lat;
			}
			if ($data) {
				$id = $user_object->add ($data);
				if ($id) {
					$wxqrcode = getWxQrcode ('admin_user', $id);
					if ($wxqrcode) {
						$wxqr_url = $wxqrcode['url'];
						$user_object->where (['id' => $id])
							->save (['wxqrcode' => $wxqr_url]);
					}
					$this->success ('新增成功', U ('index'));
				} else {
					$this->error ('新增失败');
				}
			} else {
				$this->error ($user_object->getError ());
			}
		} else {
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('新增门店')
				->setPostUrl (U ('add'))
				->addFormItem ('reg_type', 'hidden', '注册方式', '注册方式')
				->addFormItem ('username', 'text', '用户名', '用户名')
				->addFormItem ('password', 'password', '密码', '密码')
				->addFormItem ('repassword', 'password', '确认密码', '确认密码')
				->addFormItem ('shop_name', 'text', '门店名称', '门店名称')
				->addFormItem ('shop_phone', 'text', '门店电话', '门店电话')
				->addFormItem ('shop_address', 'text', '门店地址', '门店地址')
			 /*   ->addFormItem('shop_addr', 'text', '地址标签', '地址标签')
				->addFormItem('shop_flag', 'text', '类型标签', '类型标签')
				->addFormItem('level', 'radio', '门店级别', '', ['1'=>'1','2'=>'2','3'=>'3'])*/
				->addFormItem ('shop_logo', 'picture', '门店图标', '')
				->addFormItem ('shop_picarr', 'pictures', '店内图片', '')
				->addFormItem ('shop_content', 'kindeditor', '门店详情', '')
				->setFormData (array('reg_type' => 'admin', 'level' => 1))
				->display ();
		}
	}
	
	/**
	 * 编辑门店
	 */
	public function edit($id) {
		if (IS_POST) {
			// 密码为空表示不修改密码
			if ($_POST['password'] === '') {
				unset ($_POST['password']);
			}
			// 提交数据
			$user_object = D ('Shop');
			$data = $user_object->create ();
			$return = file_get_contents ("http://apis.map.qq.com/ws/geocoder/v1/?address={$data['shop_address']}&output=json&key=O5BBZ-IUX65-YRBIB-QZRXG-LBFBT-A7FUR");
			$return = json_decode ($return);
			$data['lng'] = $data['lat'] = 0;
			if (isset ($return->result->location->lng)) {
				$data['lng'] = $return->result->location->lng;
			}
			if (isset ($return->result->location->lat)) {
				$data['lat'] = $return->result->location->lat;
			}
			$wxqrcode = getWxQrcode ('admin_user', $data['id']);
			if ($wxqrcode) {
				$data['wxqrcode'] = $wxqrcode['url'];
			} else {
				writeLog ('二维码生成失败' . json_encode ($wxqrcode), 'ShopController');
			}
			if ($data) {
				$result = $user_object->save ($data);
				if ($result) {
					$this->success ('更新成功', U ('index'));
				} else {
					$this->error ('更新失败', $user_object->getError ());
				}
			} else {
				$this->error ($user_object->getError ());
			}
		} else {
			// 获取账号信息
			$info = D ('Shop')->find ($id);
			unset ($info['password']);
			
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('编辑用户')
				->setPostUrl (U ('edit'))
				->addFormItem ('id', 'hidden', 'ID', 'ID')
				->addFormItem ('username', 'text', '用户名', '用户名')
				->addFormItem ('password', 'password', '密码', '密码')
				->addFormItem ('repassword', 'password', '确认密码', '确认密码')
				->addFormItem ('shop_name', 'text', '门店名称', '门店名称')
				->addFormItem ('shop_phone', 'text', '门店电话', '门店电话')
				->addFormItem ('shop_address', 'text', '门店地址', '门店地址')
				->addFormItem ('shop_addr', 'text', '地址标签', '地址标签')
				->addFormItem ('shop_flag', 'text', '类型标签', '类型标签')
				->addFormItem ('level', 'radio', '门店级别', '', ['1' => '1', '2' => '2', '3' => '3'])
				->addFormItem ('shop_logo', 'picture', '门店图标', '')
				->addFormItem ('shop_picarr', 'pictures', '店内图片', '')
				->addFormItem ('shop_content', 'kindeditor', '门店详情', '')
				->setFormData ($info)
				->display ();
		}
	}
	
	/**
	 * 设置一条或者多条数据的状态
	 */
	public function setStatus($model = CONTROLLER_NAME, $script = false) {
		$ids = I ('request.ids');
		if (is_array ($ids)) {
			if (in_array ('1', $ids)) {
				$this->error ('超级管理员不允许操作');
			}
		} else {
			if ($ids === '1') {
				$this->error ('超级管理员不允许操作');
			}
		}
		parent::setStatus ($model);
	}
}
