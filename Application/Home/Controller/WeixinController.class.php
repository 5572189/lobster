<?php

namespace Home\Controller;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as EasyOrder;
use Think\Controller;

class WeixinController extends Controller {
	private $option = []; // 微信配置参数
	private $wxpay_config = [];
	private $wechat = []; // 微信配置参数
	protected function _initialize() {
		C ('SHOW_PAGE_TRACE', false);
		
		$TMPL_PARSE_STRING = C ('TMPL_PARSE_STRING');
		$TMPL_PARSE_STRING += ['__HTML__' => __ROOT__ . '/webApp'];
		C ('TMPL_PARSE_STRING', $TMPL_PARSE_STRING);
		
		$options = ['debug' => false, 'app_id' => C ('wechat_appid'), 'secret' => C ('wechat_appsecret'), 'token' => C ('wechat_apptoken'), 
			'log' => ['level' => 'debug', 'file' => LOG_PATH . 'easywechat.log']]; // XXX: 绝对路径！！！！

		
		$this->wxpay_config = array_merge ($options, ['payment' => ['merchant_id' => C ('wechat_merchant_id'), 'key' => C ('wechat_key')]]);
		
		$this->wechat_social_config = array_merge (['wechat' => ['client_id' => C ('wechat_appid'), 'client_secret' => C ('wechat_appsecret')]], $options);
		$this->options = $options;
		$this->app = new Application ($options);
	}
	public function index() {
		writeLog (var_export (I ('echostr'), true));
		echo I ('echostr');
		exit ();
	}
	public function run() {
		$server = $this->app->server;
		$server->setMessageHandler (function ($message) {
			writeLog (var_export ($message, true), 'wechat');
			// 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
			// 当 $message->MsgType 为 event 时为事件
			$h5title = '欢迎同样爱吃肉的你关注堡爵仕
现在您已经是堡爵仕的尊贵会员啦~

请选择右下角菜单<a href="http://' . $_SERVER["HTTP_HOST"] . '/index.php?s=/home/member/personal">「会员」</a>-绑定您的手机
即刻享受<a href="http://' . $_SERVER["HTTP_HOST"] . '">买汉堡牛排10赠1</a>会员福利！ ';
			if ($message->MsgType == 'event') {
				$num = trim ($message->EventKey, 'qrscene_');
				$openid = $message->FromUserName;
				// code...
				switch (strtolower ($message->Event)) {
					case 'subscribe' :
						$eventKey = $message->EventKey;
						
						if (!empty ($eventKey)) { // 非0或null
							if (false !== strpos ($eventKey, 'last_trade_no_')) {
								return $this->after_scan ($num, $openid);
							} elseif (false !== strpos ($eventKey, '__tbc__')) {
								$nums = explode ('__tbc__', $eventKey);
								if (count ($nums, COUNT_NORMAL) > 1) {
									$this->register_openid ($openid, $nums[1]);
									
									$h5title .= '
	                        					
本店免费WI-FI
名称：FWM
密码：fwm@8888';
								} else
									$this->register_openid ($openid, 0);
							}
						}
						
						// $data = [];
						// $data['subscribe'] = 1;
						// $data['openid'] = $openid;
						// $data['update_time'] = datetime();
						
						return $h5title;
						break;
					case 'unsubscribe' :
						// $data = [];
						// $data['subscribe'] = 0;
						// $data['openid'] = $openid;
						// $data['update_time'] = datetime();
						
						return '';
						break;
					case 'scan' :
						$num = $message->EventKey;
						$openid = $message->FromUserName;
						
						return $this->after_scan ($num, $openid);
						break;
					default :
						break;
				}
			} else {
				switch ($message->MsgType) {
					case 'text' : // 公众号自动回复的处理
						if ('wechat_debug' == $message->Content) {
							return U ('/Home/Weixin/debug', [], '', true);
						} else {
						}
						break;
					case 'image' :
						break;
					default :
						return "未处理的回复类型:{$message->MsgType}";
				}
			}
		});
		$response = $server->serve ();
		$response->send ();
		exit ();
	}
	private function register_openid($openid, $shopId) {
		// writeLog('shopid:' . $shopId,'wechat');
		writeLog ('openid:' . $openid, 'wechat');
		$exist = M ('admin_user')->where (['openid' => $openid])
			->find ();
		writeLog ('exist openid:' . var_export ($exist, true), 'wechat');
		if (!$exist) {
			$data = [];
			$data['openid'] = $openid;
			// $data['nickname'] = strval($wechat_userinfo['nickname']);
			// $data['headimgurl'] = strval($wechat_userinfo['headimgurl']);
			$data['platfrom'] = 'tbc';
			$data['source'] = 19;
			$data['shop_id'] = $shopId;
			$data['user_type'] = 0;
			
			$data['reg_ip'] = ip2long (getIp ());
			
			// 汉堡兑换券
			$param = ['data' => json_encode ($data)];
			$result = sendPost ('member/wx_register', $param);
			
			$result = json_decode ($result, true);
			writeLog ('shopid:' . var_export ($result, true), 'wechat');
			
			if ($result['data']['code'] == 200) {
				$data1 = [];
				
				$data1['openid'] = $openid;
				$data1['user_type'] = 0;
				// $data1['nickname'] = strval($wechat_userinfo['nickname']);
				// $data1['headimgurl'] = strval($wechat_userinfo['headimgurl']);
				$data1['shop_id'] = $shopId;
				$data1['ns_uid'] = $result['data']['uid'];
				$data1['create_time'] = time ();
				M ('admin_user')->add ($data1);
			}
		} else if ($exist['isnew'] == 1) {
			$data = [];
			$data['openid'] = $openid;
			// $data['nickname'] = strval($wechat_userinfo['nickname']);
			// $data['headimgurl'] = strval($wechat_userinfo['headimgurl']);
			$data['platfrom'] = 'tbc';
			$data['source'] = 19;
			$data['shop_id'] = $shopId;
			$data['user_type'] = 0;
			$data['reg_ip'] = ip2long (getIp ());
			
			// 汉堡兑换券
			$param = ['data' => json_encode ($data)];
			$result = sendPost ('member/wx_update_user', $param);
			
			$result = json_decode ($result, true);
			writeLog ('shopid:' . var_export ($result, true), 'wechat');
			
			$data1 = [];
			$data1['isnew'] = 0;
			if ($result['data']['code'] == 200) {
				$data1['openid'] = $openid;
				$data1['user_type'] = 0;
				// $data1['nickname'] = strval($wechat_userinfo['nickname']);
				// $data1['headimgurl'] = strval($wechat_userinfo['headimgurl']);
				$data1['shop_id'] = $shopId;
				$data1['ns_uid'] = $result['data']['uid'];
			}
			
			M ('admin_user')->save ($data1);
		}
	}
	
	// 扫码之后的处理
	public function after_scan($id, $openid) {
		$h5title = '欢迎同样爱吃肉的你关注堡爵仕
现在您已经是堡爵仕的尊贵会员啦~

请选择右下角菜单<a href="http://' . $_SERVER["HTTP_HOST"] . '/index.php?s=/home/member/personal">「会员」</a>-绑定您的手机
即刻享受<a href="http://' . $_SERVER["HTTP_HOST"] . '">买汉堡牛排10赠1</a>会员福利！ ';
		
		$nums = explode ('__tbc__', $id);
		if (count ($nums, COUNT_NORMAL) > 1) {
			$h5title .= '
	                        					
本店免费WI-FI
名称：FWM
密码：fwm@8888';
		}
		
		return $h5title;
	}
	public function test() {
		$staff = $this->app->staff;
		
		return $staff->lists ();
	}
	
	// 授权登录后的回调页面
	public function auth_back() {
		writeLog ('auth_back', 'wechat');
		$now = time ();
		$code = I ('code');
		if (empty ($code)) {
			$this->error ('code 参数缺少');
		}
		
		$oauth = $this->app->oauth;
		// 获取 OAuth 授权结果用户信息
		$user = $oauth->user ();
		$wechat_userinfo = $user->toArray ();
		$wechat_userinfo = $wechat_userinfo['original'];
		
		$openid = $wechat_userinfo['openid'];
		
		$exist = M ('admin_user')->where (['openid' => $openid])
			->find ();
		
		if (!$exist['ns_uid']) {
			$data = [];
			$data['openid'] = $openid;
			$data['nickname'] = filterEmoji (strval ($wechat_userinfo['nickname']));
			$data['headimgurl'] = strval ($wechat_userinfo['headimgurl']);
			$data['platfrom'] = 'tbc';
			$data['source'] = 19;
			$data['reg_ip'] = ip2long (getIp ());
			$data['isnew'] = 1;
			$data['user_type'] = 0;
			$data['shop_id'] = intval (I ('get.shop_id'));
			// M('admin_user')->add($data);
			// cookie('openid' , $openid , 3600 * 24 * 7);
			// cookie('uid' , AuthCode($data['ns_uid'] , 'ENCODE') , 3600 * 24 * 7);
			// cookie('openid' , $openid , 3600 * 24 * 7);
			// 汉堡兑换券
			$param = ['data' => json_encode ($data)];
			$result = sendPost ('member/wx_register', $param);
			
			$result = json_decode ($result, true);
			
			if ($result['data']['code'] == 200) {
				$data1 = [];
				if (!$exist) {
					$data1['openid'] = $openid;
					$data1['user_type'] = 0;
					$data1['nickname'] = filterEmoji (strval ($wechat_userinfo['nickname']));
					$data1['headimgurl'] = strval ($wechat_userinfo['headimgurl']);
					$data1['ns_uid'] = $result['data']['uid'];
					$data1['isnew'] = 1;
					$data1['create_time'] = time ();
					M ('admin_user')->add ($data1);
				} else {
					M ('admin_user')->where (['openid' => $openid])
						->save (['ns_uid' => $result['data']['uid']]);
				}
				
				cookie ('openid', $openid, 3600 * 24 * 7);
				cookie ('uid', AuthCode ($data1['ns_uid'], 'ENCODE'), 3600 * 24 * 7);
				cookie ('openid', $openid, 3600 * 24 * 7);
			}
		} else {
			$data1['nickname'] = filterEmoji (strval ($wechat_userinfo['nickname']));
			$data1['headimgurl'] = strval ($wechat_userinfo['headimgurl']);
			M ('admin_user')->where (['openid' => $openid])
				->save ($data1);
			
			cookie ('uid', AuthCode ($exist['ns_uid'], 'ENCODE'), 3600 * 24 * 7);
			cookie ('openid', $openid, 3600 * 24 * 7);
		}
		
		$targetUrl = !cookie ('target_url') ? '/' : cookie ('target_url');
		cookie ('target_url', null);
		redirect ($targetUrl);
	}
	
	// 生成jsapi 配置
	public function jsapi($APIs, $url = '') {
		$js = $this->app->js;
		if ($url) {
			$js->setUrl ($url);
		}
		// writeLog('wechat appid:' . $this->options['app_id'],'wechat');
		
		if (isTestDomain ()) {
			return $js->config ($APIs, $debug = false, $beta = false, $json = true);
		} else {
			return $js->config ($APIs, $debug = false, $beta = false, $json = true);
		}
	}
	
	// 生成二维码
	public function qrcode($code, $expire = 0) {
		$app = $this->app;
		$qrcode = $app->qrcode;
		try {
			if ($expire) {
				$result = $qrcode->temporary ($code, $expire);
				$ticket = $result->ticket; // 或者 $result['ticket']
				$expireSeconds = $result->expire_seconds; // 有效秒数
				$url = $result->url; // 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
			} else {
				// 创建永久二维码
				$result = $qrcode->forever ($code); // 或者 $qrcode->forever("foo");
				$ticket = $result->ticket; // 或者 $result['ticket']
			}
			$url = $qrcode->url ($ticket);
			
			return ['status' => 1, 'info' => '生成成功', 'data' => ['ticket' => $ticket, 'url' => $url]];
		}
		catch ( \Exception $e ) {
			writeLog ("生成{$code}, 有效期为{$expire}秒的二维码失败", 'wechat');
			
			return ['status' => 0, 'info' => $e->getMessage ()];
		}
	}
	
	// 创建微信统一订单
	public function union_order($orderInfo) {
		if ($orderInfo['money'] * 100 < 1) {
			writeLog ($orderInfo, 'WeixinController');
			writeLog ("创建订单前提失败，金额不足1分", 'WeixinController');
			
			return false;
		}
		
		$app = new Application ($this->wxpay_config);
		$order_no = $orderInfo['ordernum'];
		$payment = $app->payment;
		$attributes = ['openid' => $orderInfo['openid'], 'body' => $orderInfo['body'], 'detail' => $orderInfo['detail'], 'out_trade_no' => $order_no, 'total_fee' => $orderInfo['money'] * 100,  // APP_DEBUG ? 1 :
			'trade_type' => 'JSAPI', 'time_start' => date ('YmdHis'), 'time_expire' => date ('YmdHis', strtotime ('+1 year')), 
			'notify_url' => 'http://tbctest.noble-spirits.com/index.php/Home/Weixin/wxOrderNotify']; // 支付结果通知网址，如果不设置则会使用配置里的默认地址
		if (!isTestDomain ()) {
			$attributes['notify_url'] = 'http://tbc.noble-spirits.com/index.php/Home/Weixin/wxOrderNotify/slog_force_client_id/slog_b58071';
		}
		
		$order = new EasyOrder ($attributes);
		
		try {
			$result = $payment->prepare ($order);
			$prepayId = $result->prepay_id;
			$json = $payment->configForPayment ($prepayId);
			
			return $json;
		}
		catch ( \Exception $e ) {
			D ('cardcharge')->delete ($orderInfo['id']);
			
			return false;
		}
	}
	
	// 查询订单
	public function wxOrderQuery($out_trade_no) {
		$app = new Application ($this->wxpay_config);
		$payment = $app->payment;
		$result = $payment->query ($out_trade_no);
		
		return $result;
	}
	
	// 订单支付回调
	public function wxOrderNotify() {
		$app = new Application ($this->wxpay_config);
		$response = $app->payment->handleNotify (function ($notify, $successful) {
			writeLog (var_export ($notify, true), 'wxOrderNotify');
			// 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
			$order = M ('wxpay')->where (['ordernum' => $notify->out_trade_no])
				->find ();
			if (!$order) {
				// 如果订单不存在
				return 'Order not exist.';
				// 告诉微信，我已经处理完了，订单没找到，别再通知我了
			}
			
			// 如果订单存在
			// 检查订单是否已经更新过支付状态
			if (1 == $order['paid'] || 2 == $order['paid']) { // 假设订单字段“支付时间”不为空代表已经支付
				return true; // 已经支付成功了就不再更新了
			}
			M ('wxpay')->where (['ordernum' => $notify->out_trade_no])
				->save (['paid' => 1]);
			// 用户是否支付成功
			if ($successful) {
				$param = ['out_trade_no' => $notify->out_trade_no, 'pay_type' => 3];
				$result = sendPost ('order/order_paid', $param);
				
				$result = json_decode ($result, true);
				
				if ($result['data']['code'] == 200) {
					return M ('wxpay')->where (['ordernum' => $notify->out_trade_no])
						->save (['pushed' => 1, 'paid' => 2, 'update_time' => time ()]);
				}
				
				return false;
			} else {
				return false;
			}
		});
		$response->send ();
	}
	public function get_user_info($openid) {
		$userService = $this->app->user;
		try {
			$info = $userService->get ($openid);
			var_dump ($info);
			return $info;
		}
		catch ( \Exception $e ) {
			writeLog ("获取信息失败", 'WeixinController');
			
			return false;
		}
	}
	
	// 发送微信
	public function send_custom($openid, $message) {
		$staff = $this->app->staff;
		try {
			if ($_SERVER['HTTP_HOST'] != "ns.idea580.com") {
				$ret = $staff->message ($message, 'kf2003@NobleSpiritsChina')
					->to ($openid)
					->send ();
			} else {
				$ret = $staff->message ($message, 'kf2001@gh_c41f4dcb7c74')
					->to ($openid)
					->send ();
			}
			
			return $ret->errcode == 0;
		}
		catch ( \Exception $e ) {
			var_dump ($e->getMessage ());
			
			return false;
		}
	}
	
	// 1. 所有服务号都可以在功能->添加功能插件处看到申请模板消息功能的入口，但只有认证后的服务号才可以申请模板消息的使用权限并获得该权限；
	// 2. 需要选择公众账号服务所处的2个行业，每月可更改1次所选行业；
	// 3. 在所选择行业的模板库中选用已有的模板进行调用；
	// 4. 每个账号可以同时使用15个模板。
	// 5. 当前每个模板的日调用上限为 10 万次【2014年11月18日将接口调用频率从默认的日1万次提升为日10万次，可在MP登录后的开发者中心查看】
	
	/**
	 * 发送模板消息
	 *
	 * @author yangweijie
	 * @param
	 *        	openid openid
	 * @param
	 *        	$templateId
	 * @param $data =
	 *        	array(
	 *        	"first" => "恭喜你购买成功！",
	 *        	"keynote1" => "巧克力",
	 *        	"keynote2" => "39.8元",
	 *        	"keynote3" => "2014年9月16日",
	 *        	"remark" => "欢迎再次购买！",
	 *        	);
	 * @param
	 *        	$link
	 * @param
	 *        	$color
	 */
	public function send_template($openid, $templateId, $data, $link = '', $color = '') {
		$notice = $this->app->notice;
		if ($color) {
			$notice->color ($color);
		}
		if ($link) {
			$notice->url ($link);
		}
		try {
			$messageId = $notice->to ($openid)
				->template ($templateId)
				->data ($data)
				->send ();
			
			return true;
		}
		catch ( \Exception $e ) {
			
			return false;
		}
	}
	
	// 微信cookie调试
	public function debug() {
		$this->display ();
	}
}
