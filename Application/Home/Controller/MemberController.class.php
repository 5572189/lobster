<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Home\Controller;

/**
 * 个人中心控制器
 */
class MemberController extends BaseinfoController {
	protected $checkLogin = ['index', 
		// 'personal',
		'records', 'coupon'];
	protected $notOauth = ['send', 'login', 'check_user', 'ajax_get_bind_stat'];
	public function _initialize() {
		parent::_initialize ();
	}
	public function index() {
		
		$this->display ();
	}
	public function personal() {
		$uid = $this->uid ? $this->uid : I ('get.uid');
		$this->uid = $uid;
// 		if (IS_POST) {
// 			$this->uid = $this->uid ? $this->uid : I ('post.uid');
// 			$userInfo = M ('admin_user')->where (['id' => $this->uid])
// 				->field ('id,mobile,openid,wx_openid,alipay_id')
// 				->find ();
// 			$info = ['uid' => $userInfo['mobile'], 'mobile' => $userInfo['mobile'], 'wx_name' => '', 'ali_name' => '', 'cur_wx_name' => ''];
			
// 			if ($userInfo['wx_openid']) {
// 				$info['wx_name'] = M ('admin_user')->where (['openid' => $userInfo['wx_openid']])
// 					->getField ('nickname');
// 			} elseif ($userInfo['openid']) {
// 				$info['wx_name'] = M ('admin_user')->where (['openid' => $userInfo['openid']])
// 					->getField ('nickname');
// 			} else {
// 				$info['cur_wx_name'] = $this->openid ? strval (M ('admin_user')->where (['openid' => $this->openid])
// 					->getField ('nickname')) : '';
// 			}
			
// 			if ($userInfo['alipay_id']) {
// 				$info['ali_name'] = M ('admin_user')->where (['alipay_id' => $userInfo['alipay_id']])
// 					->getField ('nickname');
// 			} else {
// 			}
			
// 			$this->ajaxReturn (['status' => 1, 'info' => $info])
// 			// 'sql' => M('admin_user')->_sql()
// 			;
// 		}
		if ($this->uid && !I ('get.uid')) {
			redirect (U ('personal', ['uid' => $this->uid]));
		}
		if (!$this->uid) {
			redirect (U ('index/login'));
		}
// 		$userInfo = M ('admin_user')->where (['id' => $this->uid, 'nickname' => ['neq', '']])
// 			->Field ('nickname,headimgurl,mobile')
// 			->find ();
// 		if (!$userInfo['headimgurl']) {
// 			$userInfo['headimgurl'] = '/html/static/images/default_head.png';
// 		}
// 		$this->param = ['uid' => $this->uid];
		
// 		$this->assign ('uid', $this->uid);
		
		// $result = $this->sendPost ('member/information', $this->param);
		// $result = json_decode ($result, true);
		// $userInfo = (array) array_merge ($userInfo, $result['data']['result']);
		// if ($userInfo['alipay_id'] && !M ('admin_user')->where (['ns_uid' => $this->uid, 'alipay_id' => $userInfo['alipay_id']])
		// ->count ('id')) {
		// $exist = M ('admin_user')->where (['alipay_id' => $userInfo['alipay_id']])
		// ->find ();
		// if (!$exist) {
		// $data1 = [];
		
		// $data1['alipay_id'] = $userInfo['alipay_id'];
		// $data1['user_type'] = 0;
		// $data1['nickname'] = strval ($userInfo['ali_name']);
		// $data1['headimgurl'] = '';
		// $data1['ns_uid'] = $userInfo['ali_uid'];
		// $data1['create_time'] = time ();
		// M ('admin_user')->add ($data1);
		// } else {
		// /*
		// * M('admin_user')->where(['alipay_id' => $userInfo['alipay_id']])->save(
		// * [
		// * 'ns_uid' => $this->uid,
		// * 'update_time'=> time()
		// * ]
		// * );
		// */
		// }
		// M ('admin_user')->where (['ns_uid' => $this->uid])
		// ->save (['alipay_id' => strval ($userInfo['alipay_id']), 'update_time' => time ()]);
		// writeLog (var_export ([$exist, $userInfo], true), 'ali_change');
		// }
// 		$userInfo['ns_uid'] = $this->uid;
// 		$this->assign ('pageData', json_encode ($userInfo, JSON_UNESCAPED_UNICODE));
		$this->display ();
	}
	public function ajax_login() {
		if (IS_AJAX) {
			$mobile = I ('post.mobile');
			$verifyCode = I ('post.verify_code');
			$user_type = I ('post.user_type', 0);
			
			$ret = D ('User/User', 'Logic')->login ($mobile, $verifyCode, $user_type);
// 			writeLog(var_export($ret,true), 'ajax_login');
			if (($msg = getCommonErrorMsg ($ret)) !== true) {
				$this->error ($msg);
			} else {
				$this->ajaxReturn (['status' => 1, 'msg' => '登陆成功', 'refer' => I ('refer', ''), 'uid' => $ret, 'code' => urlencode (nsUCode ($ret))],'JSON');
			}
		} else {
			if(isTestDomain()) {
				$mobile = '18930703230';
				$verifyCode = '1234';
				$user_type = 0;
				$ret = D ('User/User', 'Logic')->login ($mobile, $verifyCode, $user_type);
				var_dump($ret);
			}else{
				$this->error ();
			}
		}
	}
	public function ajax_send_verify_code() {
		if (IS_AJAX) {
			$mobile = I ('post.mobile');
			
			//TODO
			
			$this->success();
		} else {
			$this->error ();
		}
	}
	public function ajax_member_info() {
		if (IS_AJAX) {
			$logic = D('User/User','Logic');
			if (!$this->uid) {
				$this->ajaxReturn(['status'=>1,'msg'=>'用户未登录'],'JSON');
				exit();
			}
			$userInfo = $logic->getUserInfo($this->uid);
			$this->ajaxReturn ($userInfo,'JSON');
		}else{
			$this->error();
		}
	}
		
	// 绑定手机号
	public function bound_phone() {
		if (IS_POST) {
			$post = I ('post.');
			if (!$this->uid) {
				$this->ajaxReturn (['status' => 0, 'msg' => '请先登录']);
			}
			$mobile = $post['mobile'];
			$code = I ('post.verify_code');
			if (!isTestDomain ()) {
				$verify_code = cookie ($mobile . '_codenum');
				if (!$verify_code) {
					$this->ajaxReturn (['status' => 0, 'msg' => '验证码失效，请重新发送']);
				}
				if ($verify_code !== $code) {
					$this->ajaxReturn (['status' => 0, 'msg' => '验证码错误']);
				}
			}
			$info = M ('admin_user')->where (['ns_uid' => $this->uid])
				->find ();
			if ($info['mobile']) {
				$this->ajaxReturn (['status' => 0, 'msg' => '您已绑定手机号']);
			}
			// 判断手机号是否已绑定微信
			if (M ('admin_user')->where (['mobile' => $mobile, 'openid' => ['neq', '']])
				->find () || M ('admin_user')->where (['mobile' => $mobile, 'wx_openid' => ['neq', '']])
				->find ()) {
				$this->ajaxReturn (['status' => 0, 'msg' => '该手机号已绑定其他微信']);
			}
			$this->param = ['uid' => $info['ns_uid'], 'openid' => $info['openid'], 'alipay_id' => $info['alipay_id'], 'mobile' => $mobile, 'source' => 19, 'platfrom' => 'tbc', 
				'wx_openid' => $info['openid']];
			writeLog ('sending post : ' . var_export ($this->param, true), 'member');
			$result = $this->sendPost ('member/bound_mobile', $this->param);
			$result = json_decode ($result, true);
			if ($result['data']['uid']) {
				$res = M ('admin_user')->where (['ns_uid' => $this->uid])
					->save (['ns_uid' => $result['data']['uid'], 'mobile' => $mobile]);
				if ($res) {
					$this->uid = $result['data']['uid'];
					cookie ('uid', AuthCode ($this->uid, 'ENCODE'), 3600 * 24 * 15);
				}
			}
			
			$res && $this->ajaxReturn (['status' => 1, 'msg' => '绑定成功']);
			$this->ajaxReturn (['status' => 0, 'msg' => '绑定失败']);
		} else {
			$this->assign ('meta_title', '绑定手机号');
			$this->display ();
		}
	}
	
	// 手机帐号绑定微信
	public function bind_wx() {
		if (IS_POST) {
			$userInfo = M ('admin_user')->where (['ns_uid' => $this->uid])
				->field ('mobile,wx_openid,alipay_id')
				->find ();
			if ($userInfo['wx_openid']) {
				$this->ajaxReturn (['status' => 0, 'msg' => '该帐号已绑定']);
			} else {
				if (!$this->openid) {
					$this->ajaxReturn (['status' => 0, 'msg' => '请在微信中完成该操作']);
				}
				if (M ('admin_user')->where (['ns_uid' => $this->uid])
					->save (['wx_openid' => $this->openid])) {
					$this->ajaxReturn (['status' => 1, 'msg' => '绑定成功']);
				} else {
					$this->ajaxReturn (['status' => 0, 'msg' => '绑定失败请稍后重试']);
				}
			}
		} else {
			$this->ajaxReturn (['status' => 0, 'msg' => '请求失败']);
		}
	}
	public function ajax_get_bind_stat() {
		if (IS_POST) {
			writeLog ('ajax_get_bind_stat', 'test');
			if (empty ($this->uid)) {
				$this->ajaxReturn (['status' => 0]);
				exit ();
			}
			writeLog ('ajax_get_bind_stat[uid]' . $this->uid, 'test');
			$mobile = M ('admin_user')->where (['ns_uid' => $this->uid])
				->getField ('mobile');
			writeLog ('ajax_get_bind_stat[mobile]' . var_export ($mobile, true), 'test');
			if (empty ($mobile)) {
				$this->ajaxReturn (['status' => 1]); // 需要弹框
				exit ();
			} else {
				$this->ajaxReturn (['status' => 0]);
				exit ();
			}
		} else {
			$this->ajaxReturn (['status' => 0, 'msg' => '请求失败']);
		}
	}
	public function clear_popup_cookie() {
		setcookie ('bindPhoneStatus', null);
		echo ('done');
	}
	
	// 解绑微信
	public function unbind_wx() {
		if (IS_POST) {
			$userInfo = M ('admin_user')->where (['ns_uid' => $this->uid])
				->field ('mobile,wx_openid,alipay_id,openid')
				->find ();
			if ($userInfo['wx_openid'] == '' && $userInfo['openid'] == '') {
				$this->ajaxReturn (['status' => 0, 'msg' => '不可解绑微信']);
			} else {
				$post = I ('post.');
				if (!isTestDomain ()) {
					$verify_code = cookie ($userInfo['mobile'] . '_codenum');
					if (!$verify_code) {
						$this->ajaxReturn (['status' => 0, 'msg' => '解绑失败请稍后重试']);
					}
					if ($verify_code !== $post['verify_code']) {
						$this->ajaxReturn (['status' => 0, 'msg' => '解绑失败请稍后重试']);
					}
				}
				
				if (M ('admin_user')->where (['ns_uid' => $this->uid])
					->save (['wx_openid' => '', 'openid' => ''])) {
					
					$this->ajaxReturn (['status' => 1, 'msg' => '解绑成功']);
				} else {
					$this->ajaxReturn (['status' => 0, 'msg' => '解绑失败请稍后重试']);
				}
			}
		} else {
			$this->error ('请求错误');
		}
	}
	// 绑定支付宝
	public function bind_alipay() {
		if (IS_POST) {
			$model = D ('Addons://AliPay/AliPay');
			$order_num = getOrderNo ();
			$sHtml = $model->wapPay ($order_num, C ('WEB_SITE_TITLE') . '', 0.01, I ('post.uid'));
			$this->ajaxReturn (['status' => 1, 'html' => $sHtml]);
		} else {
			$this->error ('请求错误');
		}
	}
	// 手机帐号绑定支付宝
	public function unbind_alipay() {
		if (IS_POST) {
			if (!$this->uid) {
				$this->error ('请先登录');
			}
			if ($this->userInfo['alipay_id'] == '') {
				$this->ajaxReturn (['status' => 0, 'msg' => '该帐号未绑定支付宝']);
			} else {
				$post = I ('post.');
				
				if (!isTestDomain ()) {
					$verify_code = cookie ($this->userInfo['mobile'] . '_codenum');
					if (!$verify_code) {
						$this->ajaxReturn (['status' => 0, 'msg' => '解绑失败请稍后重试']);
					}
					if ($verify_code !== $post['verify_code']) {
						$this->ajaxReturn (['status' => 0, 'msg' => '解绑失败请稍后重试']);
					}
				}
				
				if (M ('admin_user')->where (['ns_uid' => $this->uid])
					->save (['alipay_id' => ''])) {
					$this->param = ['uid' => $this->uid];
					$this->sendPost ('member/unbind_alipay', $this->param);
					
					$this->ajaxReturn (['status' => 1, 'msg' => '解绑成功']);
				} else {
					$this->ajaxReturn (['status' => 0, 'msg' => '解绑失败请稍后重试']);
				}
			}
		} else {
			$this->error ('请求错误');
		}
	}
	// 发送短信验证码
	public function send() {
		if (IS_AJAX) {
			// writeLog('sending verify code.. ' ,'send');
			$mobile = $_POST['mobile'];
			$ret = D ('User/User', 'Logic')->sendVerifyCode ($mobile);
			if (($msg = getCommonErrorMsg ($ret)) !== true) {
				$this->error ($msg);
			} else {
				$this->success ();
			}
			exit ();
		} else {
			$this->error ('请求错误');
		}
	}
	public function ajax_get_share_info() {
		if (IS_AJAX) {
			// $claire_uid = 12851;
			// if (in_array ( $_SERVER ['HTTP_HOST'], testDomain () )) {
			// $claire_uid = 1607;
			// }
			$current_url = I ('post.url'); // http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			writeLog ('currenturl:' . $current_url, 'wechat');
			$title = '【堡爵仕送好礼】10=11？这是一道送汉堡/牛排的算术题！';
			$desc = '满10赠1等你来享！';
			
			// $config = D ( 'Events/Guess' )->getEventData ( I ( 'id', 1 ) );
			
			$link = 'http://' . $_SERVER['HTTP_HOST'];
			$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/html/static/images/wx_share.png';
			
			$data = ['jsapi' => R ('Home/Weixin/jsapi', [['onMenuShareAppMessage', 'onMenuShareTimeline'], $current_url]), 'title' => $title, 'desc' => $desc, 'link' => $link, 
				'imgUrl' => $imgUrl];
			
			$this->ajaxReturn (['status' => 1, 'info' => $data]);
		} else {
			$this->ajaxReturn (['status' => 0]);
			$this->error ();
		}
	}
}
