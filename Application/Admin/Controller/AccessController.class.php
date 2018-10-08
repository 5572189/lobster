<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Util\Think\Page;

/**
 * 管理员控制器
 */
class AccessController extends AdminController {
	/**
	 * 管理员列表
	 *
	 * @param $tab 配置分组ID        	
	 *
	 */
	public function index() {
		// 搜索
		$keyword = I ('keyword', '', 'string');
		if (!empty ($keyword)) {
			$condition = array('like', '%' . $keyword . '%');
			$admin_id = M ('admin_user')->where (['username' => $condition])
				->getField ('id', true);
			if (!empty ($admin_id)) {
				$map['uid'] = array('in', $admin_id);
			} else {
				$map['uid'] = 0;
			}
		}
		// 获取所有配置
		$map['status'] = array('egt', '0'); // 禁用和正常状态
		$map['group'] = array('gt', 3);
		$p = !empty ($_GET["p"]) ? $_GET['p'] : 1;
		$access_object = D ('Access');
		$data_list = $access_object->page ($p, C ('ADMIN_PAGE_ROWS'))
			->where ($map)
			->order ('sort asc,id asc')
			->select ();
		$page = new Page ($access_object->where ($map)
			->count (), C ('ADMIN_PAGE_ROWS'));
		
		// 设置Tab导航数据列表
		$group_object = D ('Group');
		$user_object = D ('User');
		foreach ( $data_list as $key => &$val ) {
			$val['username'] = $user_object->getFieldById ($val['uid'], 'username');
			$val['group_title'] = $group_object->getFieldById ($val['group'], 'title');
		}
		
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder ();
		$builder->setMetaTitle ('管理员列表')
			->addTopButton ('addnew')
			->addTopButton ('delete')
			->setSearch ('请输入用户名/手机号', U ('index'))
			->addTableColumn ('id', 'ID')
			->addTableColumn ('uid', 'UID')
			->addTableColumn ('username', '用户名')
			->addTableColumn ('group_title', '用户组')
			->addTableColumn ('status', '状态', 'status')
			->addTableColumn ('right_button', '操作', 'btn')
			->setTableDataList ($data_list)
			->setTableDataPage ($page->show ())
			->addRightButton ('edit')
			->addRightButton ('delete')
			->display ();
	}
	
	/**
	 * 新增
	 */
	public function add() {
		if (IS_POST) {
			$post = I ('post.');
			$access_object = D ('Access');
			// 判断COO
			if ($post['group'] == 5) {
				$count_coo = $access_object->where (['group' => 5])
					->count ();
				if ($count_coo >= 1) {
					$this->error ('COO只能添加一个');
				}
			}
			// 判断财务总监
			if ($post['group'] == 6) {
				$count_fin = $access_object->where (['group' => 6])
					->count ();
				if ($count_fin >= 1) {
					$this->error ('财务总监只能添加一个');
				}
			}
			// 判断总监
			if ($post['group'] == 10) {
				$count_inp = $access_object->where (['group' => 10])
					->count ();
				if ($count_inp >= 10) {
					$this->error ('总监至多添加十个');
				}
			}
			if ($post['group'] == 7 || $post['group'] == 10 || $post['group'] == 11 || $post['group'] == 17) {
				// 生成推荐码 和二维码
				$user_data['num'] = get_recommend_code ();
				$qrcode = get_qrcode ($post['username']);
				if ($qrcode['status'] != 1) {
					$this->error ('生成微信二维码失败,请重新添加');
				}
				$user_data['wxqrcode'] = $qrcode['id'];
			}
			$user_object = M ('admin_user');
			$user_data['username'] = $post['username'];
			// $user_data['email'] =$post['email'];
			$user_data['password'] = user_md5 ($post['password']);
			$user_data['admin_nick'] = $post['admin_nick'];
			$user_data['avatar'] = $post['avatar'];
			$user_data['status'] = 1;
			$user_data['reg_type'] = 'admin';
			$check_mobile = check_mobile ($post['username'], 0);
			if ($check_mobile['status'] == 0) {
				$this->error ($check_mobile['msg']);
			}
			$user = $user_object->create ($user_data);
			if (!$user) {
				$this->error ($user_object->getError ());
			}
			D ()->startTrans ();
			$user_id = $user_object->add ($user);
			if (!$user_id) {
				goto  finished;
			}
			$access_data['uid'] = $user_id;
			$access_data['group'] = $post['group'];
			$access_data = $access_object->create ($access_data);
			$access_id = $access_object->add ($access_data);
			if (!$access_id) {
				goto  finished;
			}
			finished:
			if ($user_id && $access_id) {
				D ()->commit ();
				$this->success ('新增成功', U ('index'));
			} else {
				D ()->rollback ();
				$this->error ('新增失败');
			}
		} else {
			$group = select_list_as_tree ('Group');
			unset ($group[1]);
			unset ($group[2]);
			unset ($group[3]);
			$admin_user = session ('user_auth');
			$access_user = M ('admin_access')->where (['uid' => $admin_user['uid']])
				->find ();
			if ($access_user['group'] == 10) {
				unset ($group[4]);
				unset ($group[5]);
				unset ($group[6]);
				unset ($group[8]);
				unset ($group[9]);
				unset ($group[10]);
			}
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('新增配置')
				->setPostUrl (U ('add'))
				->addFormItem ('group', 'select', '用户组', '不同用户组对应相应的权限', $group)
				->addFormItem ('username', 'text', '用户名', '请填写用户名(手机号码)')
				->addFormItem ('password', 'password', '密码', '请填写密码')
				->addFormItem ('admin_nick', 'text', '昵称', '请填写昵称')
				->addFormItem ('avatar', 'picture', '头像', '请上传头像')
				->display ();
		}
	}
	
	/**
	 * 编辑
	 */
	public function edit($id) {
		if (IS_POST) {
			$post = I ('post.');
			$access_object = D ('Access');
			// 判断COO
			if ($post['group'] == 5) {
				$count_coo = $access_object->where (['group' => 5, 'id' => ['neq', $post['id']]])
					->count ();
				if ($count_coo > 0) {
					$this->error ('COO只能添加一个');
				}
			}
			// 判断财务总监
			if ($post['group'] == 6) {
				$count_fin = $access_object->where (['group' => 6, 'id' => ['neq', $post['id']]])
					->count ();
				if ($count_fin > 0) {
					$this->error ('财务总监只能添加一个');
				}
			}
			// 判断总监
			if ($post['group'] == 10) {
				$count_inp = $access_object->where (['group' => 10, 'id' => ['neq', $post['id']]])
					->count ();
				if ($count_inp > 9) {
					$this->error ('总监至多添加十个');
				}
			}
			$user_object = M ('admin_user');
			$user_info = $user_object->where (['id' => $post['uid']])
				->find ();
			$user_data['username'] = $post['username'];
			// $user_data['email'] =$post['email'];
			if (!empty ($post['password'])) {
				$user_data['password'] = user_md5 ($post['password']);
			}
			$user_data['admin_nick'] = $post['admin_nick'];
			$user_data['avatar'] = $post['avatar'];
			$user_data['status'] = 1;
			$user_data['reg_type'] = 'admin';
			if ($user_info['username'] != $post['username']) {
				$check_mobile = check_mobile ($post['username'], 0);
				if ($check_mobile['status'] == 0) {
					$this->error ($check_mobile['msg']);
				}
			}
			$user = $user_object->create ($user_data);
			if (!$user) {
				$this->error ($user_object->getError ());
			}
			D ()->startTrans ();
			$user_id = $user_object->where (['id' => $post['uid']])
				->save ($user);
			if ($user_id === false) {
				goto  finished;
			}
			$access_data['uid'] = $post['uid'];
			$access_data['group'] = $post['group'];
			$access_data = $access_object->create ($access_data);
			$access_id = $access_object->where (['id' => $post['id']])
				->save ($access_data);
			if ($access_id === false) {
				goto  finished;
			}
			finished:
			if ($user_id !== false && $access_id !== false) {
				D ()->commit ();
				$this->success ('更新成功', U ('index'));
			} else {
				D ()->rollback ();
				$this->error ('更新失败');
			}
		} else {
			$info = D ('Access')->find ($id);
			$admin_user = get_ljuser_info ($info['uid']);
			$info['username'] = $admin_user['username'];
			$info['admin_nick'] = $admin_user['admin_nick'];
			$info['avatar'] = $admin_user['avatar'];
			$group = select_list_as_tree ('Group');
			unset ($group[1]);
			unset ($group[2]);
			unset ($group[3]);
			$admin_user = session ('user_auth');
			$access_user = M ('admin_access')->where (['uid' => $admin_user['uid']])
				->find ();
			if ($access_user['group'] == 10) {
				unset ($group[4]);
				unset ($group[5]);
				unset ($group[6]);
				unset ($group[8]);
				unset ($group[9]);
				unset ($group[10]);
			}
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('编辑配置')
				->setPostUrl (U ('edit'))
				->addFormItem ('id', 'hidden', 'ID', 'ID')
				->addFormItem ('uid', 'hidden', 'ID', 'ID')
				->addFormItem ('group', 'select', '用户组', '不同用户组对应相应的权限', $group)
				->addFormItem ('username', 'text', '用户名', '请填写用户名(手机号码)')
				->addFormItem ('password', 'password', '密码', '请填写密码(不填默认为不修改)')
				->addFormItem ('admin_nick', 'text', '昵称', '请填写昵称')
				->addFormItem ('avatar', 'picture', '头像', '请上传头像')
				->setFormData ($info)
				->display ();
		}
	}
}
