<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace User\Admin;

use Admin\Controller\AdminController;

/**
 * 用户控制器
 */
class UserAdmin extends AdminController {
	
	/**
	 * @title : 用户列表
	 * @time : 2017年11月13日/下午3:34:48
	 */
	public function list_personal_member() {
		D('Useradmin','Logic')->getMemberList(false);
// 		$where = [];
// 		$where['u.user_type'] = ['eq', 0];
// 		// $where['u.ns_uid'] = ['neq', 0];
// 		$dates = I ('get.dates', '', 'trim');
// 		if (!empty ($dates)) {
// 			$where['u.create_time'] = [['egt', strtotime (substr ($dates, 0, 10) . ' 00:00:00')], ['lt', strtotime (substr ($dates, 11, 10) . ' 23:59:59')]];
// 		}
// 		$mobile = I ('get.mobile', '', 'trim');
// 		if ($mobile) {
// 			$where['u.mobile'] = ['eq', $mobile];
// 		}
// 		$nickname = I ('get.nickname', '', 'trim');
// 		if ($nickname) {
// 			$where['u.nickname'] = ['eq', $nickname];
// 		}
// 		$cnname = I ('get.cnname', '', 'trim');
// 		if ($cnname) {
// 			$where['u.cnname'] = ['eq', $cnname];
// 		}
// 		$shop_id = I ('get.shop_id', '');
// 		if ($shop_id) {
// 			$where['u.shop_id'] = ['eq', $shop_id];
// 		}
// 		$shops = M ('restaurant')->where (['status' => 1])
// 			->field ('ns_shop_id, title')
// 			->select ();
// 		$list = M ('admin_user as u')->join ('oc_restaurant as r on r.ns_shop_id = u.shop_id', 'left')
// 			->where ($where)
// 			->limit ((I ('get.p', 1) - 1) * C ("ADMIN_PAGE_ROWS"), C ("ADMIN_PAGE_ROWS"))
// 			->order ('u.id desc')
// 			->field ('u.*, r.title')
// 			->select ();
// 		$pages = new \Common\Util\Think\Page (M ('admin_user as u')->where ($where)
// 			->order ('u.id desc')
// 			->count (), C ("ADMIN_PAGE_ROWS"));
// 		$this->assign ('shop_list', $shops);
// 		$this->assign ('list', $list);
// 		$this->assign ('pages', $pages->show ());
// 		$this->assign ('get', I ('get.'));
// 		$this->display ();
	}
	
	/**
	 * @title : 用户导出
	 * @time : 2017年11月13日/下午4:25:37
	 */
	public function export_personal_member() {
		list ($data_list, $xlsCell) = D ('Useradmin', 'Logic')->getMemberList (true);
		exportExcel ("会员列表", $xlsCell, $data_list);
// 		$where = [];
// 		$where['u.user_type'] = ['eq', 0];
// 		$where['u.ns_uid'] = ['neq', 0];
// 		$dates = I ('get.dates', '', 'trim');
// 		if (!empty ($dates)) {
// 			$where['u.create_time'] = [['egt', strtotime (substr ($dates, 0, 10) . ' 00:00:00')], ['lt', strtotime (substr ($dates, 11, 10) . ' 23:59:59')]];
// 		}
// 		$mobile = I ('get.mobile', '', 'trim');
// 		if ($mobile) {
// 			$where['u.mobile'] = ['eq', $mobile];
// 		}
// 		$nickname = I ('get.nickname', '', 'trim');
// 		if ($nickname) {
// 			$where['u.nickname'] = ['eq', $nickname];
// 		}
// 		$cnname = I ('get.cnname', '', 'trim');
// 		if ($cnname) {
// 			$where['u.cnname'] = ['eq', $cnname];
// 		}
// 		$shop_id = I ('get.shop_id', '');
// 		if ($shop_id) {
// 			$where['u.shop_id'] = ['eq', $shop_id];
// 		}
// 		$shops = M ('restaurant')->where (['status' => 1])
// 			->field ('ns_shop_id, title')
// 			->select ();
// 		$model = M ('admin_user as u');
// 		$list = $model->join ('oc_restaurant as r on r.ns_shop_id = u.shop_id', 'left')
// 			->where ($where)
// 			->field ('u.*, r.title')
// 			->order ('u.id desc')
// 			->select ();
// 		writeLog ($model->getLastSql (), 'user');
// 		$xlsName = "用户列表";
// 		$xlsCell = array(array('id', 'ID'), array('nickname', '微信昵称'), array('username', '姓名'), array('mobile', '手机号码'), array('create_time', '注册时间'), array('reg_ip_address', '注册地址'), 
// 			array('title', '推荐门店'));
// 		if ($list) {
// 			foreach ( $list as $key => &$record ) {
// 				$xlsData[$key]['id'] = $record['id'];
// 				$xlsData[$key]['nickname'] = $record['nickname'];
// 				$xlsData[$key]['username'] = $record['username'];
// 				$xlsData[$key]['mobile'] = $record['mobile'];
// 				$xlsData[$key]['create_time'] = time_format ($record['create_time']);
// 				$xlsData[$key]['reg_ip_address'] = $record['reg_ip_address'];
// 				$xlsData[$key]['title'] = $record['title'];
// 			}
// 		}
// 		exportExcel ($xlsName, $xlsCell, $xlsData);
	}
	
	/**
	 * 新会员统计
	 */
	public function summary_personal_member() {
		$this->assign ('data', D ('User/Useradmin', 'Logic')->getNewMemberSummary ());
		$this->display (T ('User@Admin:User:summary_personal_member'));
	}
}
