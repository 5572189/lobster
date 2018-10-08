<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace User\Logic;

/**
 * 用户模型
 */
class UserLogic {
	private static $logFile = 'UserLogic';
	public function sendVerifyCode($mobile) {
		if (!isTestDomain ()) {
			try {
				$rand = rand (1000, 9999);
				$existData = M ('sms_log')->where (['create_time' => ['egt', time () + 5], 'mobile' => $mobile])
					->find ();
				if ($existData) {
					return generateCommonErrorMsg ('请求过于频繁，请稍后再试');
				}
				
				$data = sendTemplateSMS ($mobile, [$rand, '5分钟', $rand, '300'], '237562');
				M ('sms_log')->add (['create_time' => time (), 'mobile' => $mobile, 'code' => $rand, 'info' => $data['info']]);
				return true;
			}
			catch ( \Exception $e ) {
				return generateCommonErrorMsg ($e->getMessage ());
			}
		} else {
			return generateCommonErrorMsg ('测试服务器不支持发送手机短信');
		}
	}
	private function checkVerifyCode($mobile, $verifyCode) {
		if (!isTestDomain ()) {
			$verify_code = cookie ($mobile . '_codenum');
			if (!$verify_code) {
				return generateCommonErrorMsg ('验证码失效，请重新发送');
			}
			if ($verify_code !== $verifyCode) {
				return generateCommonErrorMsg ('验证码错误');
			}
		}
		return true;
	}
	public function getUserInfo($ns_uid) {
		$userInfo = M ('admin_user')->where (['ns_uid' => $ns_uid, 'user_type' => 0])->field('username, mobile, avatar')
			->find ();
		
		if ($userInfo) {
			$userInfo['avatar'] = get_cover($userInfo['avatar'], 'avatar');
		}
		
		return $userInfo;
	}
	public function login($mobile, $verifyCode, $user_type = 0) {
		if (!isMobileFormat ($mobile)) {
			return generateCommonErrorMsg ('请填写正确的手机号');
		}
		
		$verifyResult = $this->checkVerifyCode ($mobile, $verifyCode);
		if (getCommonErrorMsg ($verifyResult) !== true) {
			return $verifyResult;
		}
		
		$uid = 0;
		$exist = M ('admin_user')->where (['mobile' => $mobile, 'user_type' => $user_type])
			->find ();
		if ((int) $exist['ns_uid'] > 0) {
			$data = [];
			$data['login_ip'] = ip2long (getIp ());
			M ('admin_user')->where (['id' => $exist['id']])
				->save ($data);
			$uid = $exist['ns_uid'];
		} else {
			$this->param = ['source' => 14, 'mobile' => $mobile, 'user_type' => $user_type];
			$this->param['reg_ip'] = ip2long (getIp ());
			
			$result = sendPost ('newmember/login', $this->param);
			$result = json_decode ($result, true);
			if ($result['data']['code'] == 200) {
				$uid = $result['data']['userInfo']['ns_uid'] = $result['data']['userInfo']['id'];
				unset ($result['data']['userInfo']['id']);
				M ('admin_user')->add ($result['data']['userInfo']);
			} else {
				return $result;
			}
		}
		if ($uid) {
			cookie ('uid', AuthCode ($uid, 'ENCODE'), 3600 * 24 * 15);
// 			writeLog("encoded uid:" . cookie ('uid'),self::$logFile);
			if ($openid = cookie ('openid')) {
				$member['openid'] = $openid;
			}
			cookie ('openid', $openid, 3600 * 24 * 15);
			return $uid; // (['status' => 1, 'msg' => '登陆成功', 'refer' => I ('refer', ''), 'uid' => $uid, 'code' => urlencode (nsUCode ($uid))]);
		} else {
			return generateCommonErrorMsg ('登录失败');
		}
	}
	
	public function getLoginUID() {
		$uid = cookie ('uid');
// 		writeLog("encoded uid:{$uid}",self::$logFile);
		if (!$uid) {
			$this->ajaxReturn(['status'=>1,'msg'=>'用户未登录'],'JSON');
			exit();
		}
		$uid = AuthCode($uid);
// 		writeLog("decoded uid:{$uid}",self::$logFile);
		return $uid;
	}
}
