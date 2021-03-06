<?php
	// +----------------------------------------------------------------------
	// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
	// +----------------------------------------------------------------------
	namespace Addons\AliPay\Model;

	use Think\Model;

	class AliPayModel extends Model
	{
		protected $tableName = 'alipay_record';

		protected function _initialize()
		{
			parent::_initialize(); // TODO: Change the autogenerated stub

			require("Addons/AliPay/sdk/Autoloader.php");
		}

		public function wapPay($out_trade_no , $subject , $total_amount,$uid = 0,$type='bind',$ali_config = [],$shop_id=0)
		{
			if (!$this->where(['out_trade_no' => $out_trade_no])->getField('id')) {
				$new = $this->data(
				    [
				        'out_trade_no' => $out_trade_no ,
                        'create_time' => time(),
                        'uid'=>$uid,
                        'type'=>$type,
                        'money'=>$total_amount,
                        'shop_id'=>$shop_id,
                        'notify'=>''
                    ])->add();
				if (!$new) {
					return false;
				}
			}

			$cls = new \Addons\AliPay\sdk\AliWapPay($ali_config);
			$cls->setOutTradeNo($out_trade_no);
			$cls->setSubject($subject);
			$cls->setTotalAmount($total_amount);

			return $cls->pay();
		}
		public function wapRefund($out_trade_no , $total_amount,$reason)
		{
			if (!$this->where(['out_trade_no' => $out_trade_no,'status'=>0])->getField('id')) {
				return false;
			}

			$cls = new \Addons\AliPay\sdk\AliWapRefund();
			$cls->setOutTradeNo($out_trade_no);
			$cls->setOutRequestNo('TKA'.microtime(true).rand(10000,99999));
			$cls->setRefundAmount($total_amount);
			$cls->setRefundReason($reason);

			return $cls->refund();
		}
	}
