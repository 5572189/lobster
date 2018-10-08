<?php

	namespace Addons\AliPay\Controller;

	use Home\Controller\AddonController;
    use Home\Controller\AppController;
    use Think\Controller\RestController;

    /**
	 * 支付宝支付
	 * @author Kit <leishuihe@qq.com>
	 */
	class AliPayController extends AddonController
	{
		public function _initialize()
		{
			require("Addons/AliPay/sdk/Autoloader.php");
		}

		public function pay()
		{
			$params = $_POST;
            writeLog(var_export($params,true),'alipay_callback');

            $out_trade_no = $params['out_trade_no'];
            $order = M('alipay_record')->where(['out_trade_no' => $out_trade_no])->find();

            if (!$order) {
                // 如果订单不存在
                echo 'success';
                exit;
            }

			$cls = new \Addons\AliPay\sdk\AliWapPay(shopAliConfig($order['shop_id']));
			$sign = $params['sign'];
			$sign_type = $params['sign_type'];
			$params['sign'] = null;
			$params['sign_type'] = null;

			if (!$cls->verify($cls->getSignContent($params) , $sign , null , $sign_type)) {
				echo 'success';
				exit;
			}
			if ($params['trade_status'] === 'TRADE_SUCCESS') {
                M('alipay_record')->where(['out_trade_no' => $params['out_trade_no']])->save(
                    [
                        'notify' => $cls->getSignContent($params),
                        'status' => 1
                    ]
                );
                $ali_user_id = trim($params['buyer_id']);

                /*$orderUid = M('admin_user')->where(['alipay_id'=>$ali_user_id])->getField('id');
                if(!$orderUid){
                    $dataForReg = [];
                    $dataForReg['alipay_id']        =   $ali_user_id;
                    $dataForReg['nickname']         =   trim($params['buyer_logon_id']);
                    $dataForReg['reg_ip']           =   ip2long(getIp());

                    $uid = M('admin_user')->add($dataForReg);

                }else{
                    M('admin_user')->where(['alipay_id'=>$ali_user_id])->save([
                        'nickname' => trim($params['buyer_logon_id']),
                        'update_time'=> time()
                    ]);
                }*/

				switch ($order['type']) {
					//  购卡修改状态
					case  'bind':

                        $data = [];
                        $data['alipay_id'] = $ali_user_id;
                        $data['user_type'] = 0;
                        $data['nickname'] = strval($params['buyer_logon_id']);
                        $data['headimgurl'] = '';
                        $data['platfrom'] = 'tbc';
                        $data['source'] = 19;

                        $data['reg_ip'] = ip2long(getIp());
                        $data['uid'] = $order['uid'];

                        //汉堡兑换券
                        $param = [
                            'data' => json_encode($data)
                        ];
                        $result = sendPost('member/alipay_register' , $param);
                        $result = json_decode($result , true);
                        if ( $result['data']['code'] == 200 ) {
                            $exist = M('admin_user')->where(['alipay_id' => $ali_user_id])->find();
                            if (!$exist) {
                                $data1 = [];

                                $data1['alipay_id'] = $ali_user_id;
                                $data1['user_type'] = 0;
                                $data1['nickname'] = strval($params['buyer_logon_id']);
                                $data1['headimgurl'] = '';
                                $data1['ns_uid'] = $result['data']['uid'];
                                $data1['create_time'] = time();
                                M('admin_user')->add($data1);

                            }else{
                                M('admin_user')->where(['alipay_id' => $ali_user_id])->save(
                                    [
                                        'nickname' => strval($params['buyer_logon_id']),
                                        'update_time'=> time()
                                    ]
                                );
                            }

                        }

                        if(M('admin_user')->where(['alipay_id'=>$ali_user_id,'mobile' => ['neq','']])->getField('id')){
                            writeLog(var_export([$ali_user_id,$order['uid']],true),'alipay_refund');
                            /*vendor ( "alipay-sdk.aop.AopClient" );
                            vendor ( "alipay-sdk.aop.request.AlipayTradeRefundRequest" );
                            $config = M ( 'admin_addon' )->where ( [ 'name' => 'AliPay' ] )->getField ( 'config' );
                            $alipay_config = json_decode ( $config , true );
                            $client = new \AopClient ();
                            $client->appId = $alipay_config ['app_id'];
                            $client->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
                            $client->rsaPrivateKey = $alipay_config['merchant_private_key'];
                            $client->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
                            $client->signType = 'RSA2';
                            $client->postCharset = 'UTF-8';
                            $client->format = 'json';
                            $res = new \AlipayTradeRefundRequest();
                            $res->setBizContent(json_encode([
                                'out_trade_no'=>$out_trade_no,
                                'refund_amount'=>0.01
                            ]));
                            $response = $client->execute ( $res );
                            writeLog(var_export($response,true),'alipay_refund');
                            $trade_status = strval($response->alipay_trade_refund_response->code);
                            if( $trade_status == 10000 ){
                                writeLog(var_export([$ali_user_id,$order['uid']],true),'alipay_refund');
                            }*/

                        }else{
                            M('admin_user')->where(['ns_uid' => $order['uid']])->save(
                                [
                                    'alipay_id'=>$ali_user_id,
                                    'nickname' => strval($params['buyer_logon_id']),
                                    'update_time'=> time()
                                ]
                            );
                            M('admin_user')->where(['alipay_id'=>$ali_user_id,'nickname'=>''])->save([
                                'nickname' => trim($params['buyer_logon_id']),
                                'update_time'=> time()
                            ]);

                        }

						break;
					case 'pay':
                        $param = [
                            'out_trade_no'      => $out_trade_no,
                            'pay_type' => 5,
                            'uid'=>$order['uid']
                        ];

                        $result = sendPost('order/order_paid' , $param);

                        $result = json_decode($result,true);

                        if($result['data']['code'] == 200){
                            if( M('alipay_record')->where(['out_trade_no' => $out_trade_no])->save(['status'=>2])){
                                echo 'success';exit;
                            }
                        }
                        break;
                    default:
                        break;

				}
			}
			echo 'success';
			exit;
		}
		public function after_pay()
		{
			$out_trade_no = I('get.out_trade_no');
			$orderinfo = M('alipay_record')->where(['out_trade_no' => $out_trade_no])->find();
			switch ($orderinfo['type']) {
				case 'bind':
					header('location:' . '/index.php?s=/member/personal/uid/'.$orderinfo['uid'].'.html');
					break;
                case 'pay':
                    header('location:' . '/index.php?s=/order/pay_success/out_trade_no/'.$out_trade_no.'.html');
                    break;
			}
		}
	}
