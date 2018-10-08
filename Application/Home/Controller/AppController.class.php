<?php

namespace Home\Controller;

use Think\Controller\RestController;

/**
 * Api默认控制器
 */
class AppController extends RestController {
	public $key = "7cf2db5ec261a0fa27a502d3196a6f60";
	public $uid = '';
	public $requestData = [];
	public $url = 'http://nt.idea580.com/shop.php?s=/';
	public $param = [];
	public $lang = 'cn';
	public $shop_id = 20;
	public $brand_id = 1; // 品牌ID 2018年2月27日15:47:29
	public $data = ['code' => '200', 'msg' => '', 'result' => ''];
	protected $checkLogin = [];
	protected $notOauth = [];
	public $signCheck = true;
	public $userInfo = [];
	public function _initialize() {
		$this->requestData = I ('post.');
		
		if (!isTestDomain ()) {
			$this->url = "http://www.noble-spirits.com/shop.php?s=/";
		} else {
			$this->url = "http://nt.idea580.com/shop.php?s=/";
		}
		$this->userInfo = ['nickname' => '', 'headimgurl' => ''];
		$this->uid = AuthCode (cookie ('uid'), 'DECODE');
		
		if ($this->uid) {
			$this->userInfo = M ('admin_user')->where (['id' => $this->uid, 'mobile' => ['neq', '']])
				->find ();
			if (empty ($this->userInfo)) {
				$this->userInfo = M ('admin_user')->where (['id' => $this->uid])
					->find ();
			}
			if (empty ($this->userInfo)) {
				$this->uid = 0;
				cookie ('uid', null);
			}
		}
		
		$current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		if (CONTROLLER_NAME == 'Order' && ACTION_NAME == 'pay' || !cookie ('target_url') && !in_array (ACTION_NAME, $this->notOauth)) {
			cookie ('target_url', $current_url, 3600 * 24 * 5);
		}
		
		$openid = M ('admin_user')->where (['id' => $this->uid, 'openid' => ['neq', '']])
			->getField ('openid');
		$wx_openid = M ('admin_user')->where (['id' => $this->uid, 'openid' => ['neq', '']])
			->getField ('wx_openid');
		
		if ((!cookie ('openid') || !$this->uid) && is_weixin () && !in_array (ACTION_NAME, $this->notOauth)) {
			redirect (U ('home/Oauth/wechat', ['shop_id' => intval (I ('get.shop_id'))]));
		} elseif ((cookie ('openid') != $openid && cookie ('openid') != $wx_openid) && is_weixin () && !in_array (ACTION_NAME, $this->notOauth)) {
			// redirect(U('home/Oauth/wechat',['shop_id'=>intval(I('get.shop_id'))]));
		}
		
		$this->openid = cookie ('openid');
		$this->assign ('uid', $this->uid);
		$this->assign ('uCode', urlencode (nsUCode ($this->uid)));
		$this->assign ('nsWebHost', C ('nsWebHost'));
		if (in_array (ACTION_NAME, $this->checkLogin) && !$this->uid) {
			redirect ('/index.php/index/login?refer=' . urlencode ($_SERVER['REQUEST_URI']));
		}
		$jsapi = R ('Home/Weixin/jsapi', [['previewImage', 'onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone']]);
		$this->assign ('jsapi', $jsapi);
		$this->assign ('clear_web', clear_web ());
	}
	public function oauth() {
		$this->uid = AuthCode (cookie ('uid'), 'DECODE');
		if (!M ('admin_user')->where (['ns_uid' => $this->uid])
			->find ()) {
			$this->uid = 0;
			cookie ('uid', null);
		} else {
			$uid = M ('admin_user')->where (['ns_uid' => $this->uid, 'mobile' => ['neq', '']])
				->getField ('ns_uid');
			if ($uid && $uid != $this->uid) {
				$this->uid = 0;
				cookie ('uid', null);
			}
		}
		// 支付宝授权
		if (is_alipay () && (!$this->uid || !M ('admin_user')->where (['ns_uid' => $this->uid, 'alipay_id' => ['neq', '']])
			->count ('id'))) {
			$current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			cookie ('target_url', $current_url, 86400 * 15);
			$return_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php/home/alipay/oauth/shop_id/' . intval (I ('get.shop_id'));
			$config = M ('admin_addon')->where (['name' => 'AliPay'])
				->getField ('config');
			$alipay_config = json_decode ($config, true);
			$url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=' . $alipay_config['app_id'] . '&scope=auth_user&redirect_uri=' . urlencode ($return_uri);
			
			redirect ($url);
		}
	}
	
	/**
	 * 统一输出返回
	 * 
	 * @param unknown $info        	
	 * @param string $code        	
	 * @param string $type        	
	 */
	public function returnResponse($info, $code = 'cn', $type = 'JSON') {
		$data['data'] = $info;
		switch (strtoupper ($type)) {
			case 'JSON' :
				// 返回JSON数据格式到客户端 包含状态信息
				header ('Content-Type:application/json; charset=utf-8');
				if ($code == "cn") {
					echo json_encode ($data, JSON_UNESCAPED_UNICODE);
					exit ();
				}
				echo json_encode ($data);
				exit ();
			case 'XML' :
				// 返回xml格式数据
				header ('Content-Type:text/xml; charset=utf-8');
				echo xml_encode ($data);
				exit ();
			case 'JSONP' :
				// 返回JSON数据格式到客户端 包含状态信息
				header ('Content-Type:application/json; charset=utf-8');
				$handler = isset ($_GET[C ('VAR_JSONP_HANDLER')]) ? $_GET[C ('VAR_JSONP_HANDLER')] : C ('DEFAULT_JSONP_HANDLER');
				echo $handler . '(' . json_encode ($data) . ');';
				exit ();
			case 'EVAL' :
				// 返回可执行的js脚本
				header ('Content-Type:text/html; charset=utf-8');
				exit ($data);
		}
	}
	
	/**
	 * 验证签名
	 * 
	 * @param array $args
	 *        	POST
	 * @param string $signature
	 *        	POST
	 * @return boolean
	 */
	public function checkSign($args, $signature) {
		if (!$args || !$signature) {
			return false;
		}
		if (time () - $args['timestamp'] > 300) // 同一签名调用时间限制
{
			return false;
		}
		unset ($args['sign']);
		ksort ($args); // 按数组的键排序
		$sign = '';
		foreach ( $args as $k => $v ) {
			$sign .= $k . '=' . $v;
		}
		$sign = sha1 ($sign . $this->key); // 加密
		if ($sign == $signature) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * 生成签名
	 * 
	 * @param array $args        	
	 * @return string
	 */
	public function setSign($args) {
		unset ($args['sign']);
		ksort ($args); // 按数组的键排序
		$sign = '';
		foreach ( $args as $k => $v ) {
			$sign .= $k . '=' . $v;
		}
		$sign = sha1 ($sign . $this->key);
		
		return $sign;
	}
	
	/**
	 * 发送POST请求
	 * 
	 * @param
	 *        	$url
	 * @param array $post_data        	
	 * @return
	 *
	 */
	public function sendPost($url, $post_data = array()) {
		if (!strlen (strpos ($url, "http"))) {
			$url = $this->url . $url;
		}
		$date = date ('md');
		$post_data['timestamp'] = time ();
		$post_data['sign'] = $this->setSign ($post_data);
		$ch = curl_init ();
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt ($ch, CURLOPT_URL, $url);
		@curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
		$result = curl_exec ($ch);
		writeLog ($url, 'sendPost' . $date);
		writeLog (var_export ($result, true), 'sendPost' . $date);
		if ($error = curl_error ($ch)) {
			writeLog (var_export ([$url, $error, $post_data], true), 'sendPostError' . $date);
			
			return false;
		}
		
		return $result;
	}
}