<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace User\Logic;

use Common\Util\Think\Page;
use Common\Builder\ListBuilder;
/**
 * 用户模型
 */
class UseradminLogic {
	private static $logFile = 'UseradminLogic';
	
	/**
	 * 后台个人会员列表/导出
	 *
	 * @param string $isExportData        	
	 * @return multitype:multitype:multitype:string Ambigous <mixed, NULL, unknown, multitype:Ambigous <string, unknown> unknown , object> |multitype:
	 */
	public function getMemberList($isExportData = false) {
// 		writeLog("getMemberList",self::$logFile);
		$where = [];
		$where['u.user_type'] = ['eq', 0];
		// $where['u.ns_uid'] = ['neq', 0];
		$dates = I ('get.dates', '', 'trim');
		if (!empty ($dates)) {
			$where['u.create_time'] = [['egt', strtotime (substr ($dates, 0, 10) . ' 00:00:00')], ['lt', strtotime (substr ($dates, 11, 10) . ' 23:59:59')]];
		}
		$mobile = I ('get.mobile', '', 'trim');
		if ($mobile) {
			$where['u.mobile'] = ['eq', $mobile];
		}
		$nickname = I ('get.nickname', '', 'trim');
		if ($nickname) {
			$where['u.nickname'] = ['eq', $nickname];
		}
		$shop_id = I ('get.shop_id', '');
		if ($shop_id) {
			$where['u.shop_id'] = ['eq', $shop_id];
		}
		
		try{
			$shops = M ('restaurant')->where (['status' => 1])
				->field ('ns_shop_id, title')
				->select ();
			
			if ($isExportData) {
				$map['a.status'] = 1;
				// @formatter:off
				$xlsCell = array (array ('id','ID' ),
					array ('nickname','微信昵称' ),
					array ('mobile','用户手机号' ),
					array ('create_time','注册时间' ),
					array ('reg_ip_address','注册地址' ),
					array ('title','餐厅来源' )
				);
				// @formatter:on
				$data_list = M ('admin_user as u')->join ('oc_restaurant as r on r.ns_shop_id = u.shop_id', 'left')
					->where ($where)
					->order ('u.id desc')
					->field ('u.*, r.title')
					->select ();
			} else {
				$p = I ('get.p', 1);
				$data_list = M ('admin_user as u')->join ('oc_restaurant as r on r.ns_shop_id = u.shop_id', 'left')
					->where ($where)
					->page ($p, C ("ADMIN_PAGE_ROWS"))
					->order ('u.id desc')
					->field ('u.*, r.title')
					->select ();
				$page = new Page (
					M ('admin_user as u')->where ($where)
						->count (), C ('ADMIN_PAGE_ROWS'));
				$builder = new ListBuilder ();
				$builder->setMetaTitle ('会员列表')
					->addTopButton ('self', generate_export_btn ('export_personal_member'))
					->addSearchItem ('dates', 'dateranger', '注册时间', '', 90)
					->addSearchItem ('nickname', 'text', '微信昵称', '')
					->addSearchItem ('username', 'text', '姓名', '')
					->addSearchItem ('mobile', 'text', '用户手机号', '')
					->addSearchItem ('shop_id', 'select', '', '', ['' => '餐厅来源'] + $shops)
					->addTableColumn ('id', 'id')
					->addTableColumn ('nickname', '微信昵称')
					->addTableColumn ('headimgurl', '微信头像', 'callback', [D ('User'), 'getimg'])
					->addTableColumn ('mobile', '用户手机号')
					->addTableColumn ('create_time', '注册时间')
					->addTableColumn ('reg_ip_address', '注册地址')
					->addTableColumn ('title', '餐厅来源')
					->addTableColumn ('status', '状态', 'status')
					->addTableColumn ("right_button", "操作管理", "btn");
			}
		}catch(\Exception $e){
			writeLog($e->getMessage(),self::$logFile);
		}
		
		// $data_list = array_unset ( $data_list, 'id' );
		
		foreach ( $data_list as $key => $v ) {
			$data_list[$key]['nickname'] = filterEmoji ($v['nickname']);
// 			$data_list[$key]['level'] = get_card_level ($data_list[$key]['card_level']);
// 			$data_list[$key]['username'] = $v['surname'] . $v['nick'];
// 			$data_list[$key]['create_time'] = date ('Y-m-d H:i:s', $v['create_time']);
// 			if ((empty ($v['shop_name']) && empty ($v['shopbrand_name'])) || $v['shop_bind_time'] == 0) {
// 				$data_list[$key]['shop_bind_time'] = '';
// 			} else {
// 				$data_list[$key]['shop_bind_time'] = date ('Y-m-d H:i:s', $v['shop_bind_time']);
// 			}
// 			$rec = M ('admin_user')->where (['id' => $v['recUid']])
// 				->find ();
// 			if ($isExportData) {
// 				$data_list[$key]['recUidinfo'] = $rec['admin_nick'];
// 				$data_list[$key]['recUidinfomobile'] = $rec['username'];
// 			} else {
// 				$data_list[$key]['recUidinfo'] = $rec['username'] . "<br/>" . $rec['admin_nick'];
// 			}
			
// 			$data_list[$key]['shop_name'] = M ('shop')->where (['id' => $v['shop_id']])
// 				->getField ('title');
		}
// 		writeLog(var_export($data_list,true),self::$logFile);
		
		if (!$data_list)
			$data_list = [];
		
		if ($isExportData) {
			return [$data_list, $xlsCell];
		} else {
			$builder->setTableDataList ($data_list)
				->setTableDataPage ($page->show ())
// 				->addRightButton ('self', array('title' => '查看消费记录', 'class' => 'label label-primary', 'href' => U ('list_consumption', ['id' => '__data_id__'])))
// 				->addRightButton ('self', array('title' => '修改用户余额', 'class' => 'label label-primary', 'href' => U ('edit_balance', ['id' => '__data_id__'])))
// 				->addRightButton ('self', array('title' => '分配销售员', 'class' => 'label label-primary', 'href' => U ('edit_salesman', ['id' => '__data_id__'])))
// 				->addRightButton ('self', array('title' => '后台购买', 'class' => 'label label-primary', 'href' => U ('add_purchase_record', ['id' => '__data_id__'])))
// 				->addRightButton ('self', array('title' => '手机号码变更', 'class' => 'label label-primary', 'href' => U ('change_mobile', ['id' => '__data_id__'])))
// 				->addRightButton ('self', array('title' => '账号合并', 'class' => 'label label-primary', 'href' => U ('merge_account', ['id' => '__data_id__'])))
				->display ();
		}
		// @formatter:on
	}
	
	/**
	 * 后台新会员统计
	 *
	 * @return string
	 */
	public function getNewMemberSummary() {
		$retValue = [];
		$map = [];
		$today = strtotime (date ('Y-m-d', time ())); // 今天
		$start_date = I ('get.start_date') ? strtotime (I ('get.start_date')) : $today - 7 * 86400;
		$end_date = I ('get.end_date') ? (strtotime (I ('get.end_date')) + 86400) : $today + 86400;
		$count_day = ($end_date - $start_date) / 86400; // 查询最近n天
		$model_object = M ('admin_user');
		$number = 0;
		
		$map['id'] = ['not in', testUID ()];
		// $map ['status'] = 1;
		// ===================按日期分布===================
		for($i = 0; $i < $count_day; $i++) {
			$day = $start_date + $i * 86400; // 第n天日期
			$day_after = $start_date + ($i + 1) * 86400; // 第n+1天日期
			$map['create_time'] = array(array('egt', $day), array('lt', $day_after));
			// $this->addActiveUserMap ( $map );
			$user_reg_date[] = date ('m月d日', $day);
			$count = $model_object->where ($map)
				->count ();
			// writeLog($model_object->getLastSql(), self::$logFile);
			$user_reg_count[] = $count;
			$number = $number + $count;
		}
		$retValue['search']['start_date'] = date ('Y-m-d', $start_date);
		$retValue['search']['end_date'] = date ('Y-m-d', $end_date - 1);
		$retValue['total']['number'] = $number;
		$retValue['total']['count_day'] = $count_day;
		$retValue['total']['list'] = json_encode ($user_reg_date, JSON_UNESCAPED_UNICODE);
		$retValue['total']['count'] = json_encode ($user_reg_count);
		$retValue['meta_title'] = "会员增长统计图";
		
		$map['create_time'] = array(array('egt', $start_date), array('lt', $end_date));
		// ===================按门店分布===================
		// $map ['shop_id'] = array ('gt','0' );
		// $this->addActiveUserMap ( $map );
		$sum = $model_object->where ($map)
			->count ();
		
		$list = $model_object->field ('shop_id, COUNT(id) as num, count(case when mobile <> "" then id else null end) as num_mobile')
			->where ($map)
			->group ('shop_id')
			->select ();
		$total = 0;
		$total_mobile = 0;
		foreach ( $list as $k => $v ) {
			if ($v['shop_id'] != 0) {
				$shopDesc = M ('restaurant')->where (['ns_shop_id' => $v['shop_id']])
					->getField ('title');
			} else {
				$shopDesc = '未归入门店';
			}
			$group[] = $shopDesc;
			$num[] = ['value' => $v['num'], 'name' => $shopDesc . "({$v['num']})", 'name_origin' => $shopDesc, 'value_mobile' => $v['num_mobile'], 
				'value_unmobile' => intval ($v['num']) - intval ($v['num_mobile'])];
			$total += intval ($v['num']);
			$total_mobile += intval ($v['num_mobile']);
		}
		
		$retValue['total']['mobile_number'] = $total_mobile;
		$retValue['total']['unmobile_number'] = $number - $total_mobile;
		
		$retValue['shop']['sum'] = $sum;
		$retValue['shop']['group'] = json_encode ($group, JSON_UNESCAPED_UNICODE);
		$retValue['shop']['num'] = json_encode ($num);
		$retValue['shop']['num_origin'] = $num;
		unset ($map['shop_id']);
		unset ($num);
		unset ($group);
		// // ===================按门店分布查看有积分会员===================
		// // $map ['shop_id'] = array ('gt','0' );
		// $map1 = [ 'u.id' => [ 'not in',testUID () ],'u.status' => 1,'u.create_time' => array (array ('egt',$start_date ),array ('lt',$end_date ) ) ];
		// // $this->addActiveUserMap ( $map1, 'u' );
		// $list = M ( 'admin_user as u' )->field ( 'u.shop_id,
		// count(case when p.total is not null then u.id else null end) as hasPoints,
		// count(case when p.total is null then u.id else null end) as noPoints' )
		// ->join ( 'oc_user_points as p on p.uid = u.id', 'left' )
		// ->where ( $map1 )
		// ->group ( 'u.shop_id' )
		// ->select ();
		// foreach ( $list as $k => $v ) {
		// $shopDesc = M ( 'shop' )->where ( [ 'id' => $v ['shop_id'] ] )
		// ->getField ( 'title' );
		// $group [] = $shopDesc;
		// $num [] = [ 'value_p' => $v ['hasPoints'],'value_np' => $v ['noPoints'],'name_origin' => $shopDesc ];
		// }
		// $retValue ['shop_points'] ['num_origin'] = $num;
		// // unset ( $map ['shop_id'] );
		// unset ( $num );
		// unset ( $group );
		// // // ===================按地区分布===================
		// // $map ['comprehensive_province'] = array ('neq','' );
		// $sum = $model_object->where ( $map )
		// ->count ();
		// $list = $model_object->field ( 'COUNT(id) as num,comprehensive_province' )
		// ->where ( $map )
		// ->group ( 'comprehensive_province' )
		// ->select ();
		// foreach ( $list as $k => $v ) {
		// $group [] = $v ['comprehensive_province'] . "({$v['num']})";
		// $num [] = [ 'value' => $v ['num'],'name' => $v ['comprehensive_province'] . "({$v['num']})",'name_origin' => $v ['comprehensive_province'] ];
		// }
		// $retValue ['region'] ['sum'] = $sum;
		// $retValue ['region'] ['group'] = json_encode ( $group, JSON_UNESCAPED_UNICODE );
		// $retValue ['region'] ['num'] = json_encode ( $num );
		// $retValue ['region'] ['num_origin'] = $num;
		// // unset ( $map ['comprehensive_province'] );
		// unset ( $num );
		// unset ( $group );
		// // ===================按新媒体分布===================
		// $map ['new_media_id'] = array ('gt','0' );
		// $sum = $model_object->where ( $map )
		// ->count ();
		
		// $list = $model_object->field ( 'recUid, COUNT(id) as num' )
		// ->where ( $map )
		// ->group ( 'recUid' )
		// ->select ();
		// foreach ( $list as $k => $v ) {
		// $kolName = M ( 'admin_user' )->where ( [ 'id' => $v ['recUid'] ] )
		// ->getField ( 'admin_nick' ) . "({$v['num']})";
		// $group [] = $kolName;
		// $num [] = [ 'value' => $v ['num'],'name' => $kolName ];
		// }
		// $retValue ['kol'] ['sum'] = $sum;
		// $retValue ['kol'] ['group'] = json_encode ( $group, JSON_UNESCAPED_UNICODE );
		// $retValue ['kol'] ['num'] = json_encode ( $num );
		// unset ( $map ['new_media_id'] );
		// unset ( $num );
		// unset ( $group );
		// writeLog(var_export($retValue,true),self::$logFile);
		return $retValue;
	}
}
