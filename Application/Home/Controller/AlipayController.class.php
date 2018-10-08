<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Controller;

use Common\Controller\CommonController;

class AlipayController extends CommonController {
	public function oauth() {
		vendor ("alipay-sdk.aop.AopClient");
		vendor ("alipay-sdk.aop.request.AlipaySystemOauthTokenRequest");
		vendor ("alipay-sdk.aop.request.AlipayUserInfoShareRequest");
		$config = M ('admin_addon')->where (['name' => 'AliPay'])
			->getField ('config');
		
		$alipay_config = json_decode ($config, true);
		$client = new \AopClient ();
		$client->appId = $alipay_config['app_id'];
		$client->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
		$client->rsaPrivateKey = $alipay_config['merchant_private_key'];
		$client->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
		$client->signType = 'RSA2';
		$client->postCharset = 'UTF-8';
		$client->format = 'json';
		$res = new \AlipaySystemOauthTokenRequest ();
		$res->setGrantType ('authorization_code');
		$res->setCode (I ('get.auth_code'));
		$response = $client->execute ($res);
		
		$access_token = $response->alipay_system_oauth_token_response->access_token;
		
		$request = new \AlipayUserInfoShareRequest ();
		$response = $client->execute ($request, $access_token);
		$response = objToArr ($response);
		writeLog (var_export ($response, true), 'ali_oauth' . date ('Ymd'));
		if ($response['alipay_user_info_share_response']['code'] == 10000) {
			$alipay_id = $response['alipay_user_info_share_response']['user_id'];
			
			$data = [];
			$data['alipay_id'] = $alipay_id;
			$data['user_type'] = 0;
			$data['nickname'] = strval ($response['alipay_user_info_share_response']['nick_name']);
			if ($data['nickname'] == '') {
				$data['nickname'] = substr_replace ($data['alipay_id'], '***', 0, 10);
			}
			$data['headimgurl'] = strval ($response['alipay_user_info_share_response']['avatar']);
			$data['platfrom'] = 'tbc';
			$data['source'] = 19;
			$data['shop_id'] = intval (I ('get.shop_id', 0));
			
			$data['reg_ip'] = ip2long (getIp ());
			
			// 汉堡兑换券
			$param = ['data' => json_encode ($data)];
			$result = sendPost ('member/alipay_register', $param);
			$result = json_decode ($result, true);
			writeLog (var_export ($result, true), 'ali_oauth' . date ('Ymd'));
			if (in_array ($result['data']['code'], [200, 300])) {
				$exist = M ('admin_user')->where (['alipay_id' => $alipay_id])
					->find ();
				if (!$exist) {
					$data1 = [];
					
					$data1['alipay_id'] = $alipay_id;
					$data1['user_type'] = 0;
					$data1['nickname'] = strval ($response['alipay_user_info_share_response']['nick_name']);
					$data1['headimgurl'] = strval ($response['alipay_user_info_share_response']['avatar']);
					$data1['mobile'] = strval ($result['data']['mobile']);
					$data1['ns_uid'] = $result['data']['uid'];
					$data1['create_time'] = time ();
					$data1['shop_id'] = intval (I ('get.shop_id', 0));
					M ('admin_user')->add ($data1);
					if ($data1['mobile']) {
						M ('admin_user')->where (['mobile' => $data1['mobile']])
							->save (['alipay_id' => $alipay_id]);
					}
				} else {
				}
				
				cookie ('uid', AuthCode ($result['data']['uid'], 'ENCODE'), 3600 * 24 * 7);
			}
			redirect (cookie ('target_url'));
		}
	}
}
