<?php
	/**
	 * Created by PhpStorm.
	 * User: Kit
	 * Date: 2017/4/25
	 * Time: 11:13
	 */

	namespace Addons\AliPay\sdk;


	class AliWapPay extends AlipayClient
	{
		// 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
		private $body;

		// 订单标题，粗略描述用户的支付目的。
		private $subject;

		// 商户订单号.
		private $outTradeNo;

		// (推荐使用，相对时间) 支付超时时间，5m 5分钟
		private $timeExpress;

		// 订单总金额，整形，此处单位为元，精确到小数点后2位，不能超过1亿元
		private $totalAmount;

		// 如果该字段为空，则默认为与支付宝签约的商户的PID，也就是appid对应的PID
		private $sellerId;

		// 产品标示码，固定值：QUICK_WAP_PAY
		private $productCode;

		protected $bizContentarr = array();

		private $alipay_config = null;

		/**
		 * @return mixed
		 */
		public function getBody()
		{
			return $this->body;
		}

		/**
		 * @param mixed $body
		 */
		public function setBody($body)
		{
			$this->body = $body;
			$this->bizContentarr['body'] = $body;
		}

		/**
		 * @return mixed
		 */
		public function getSubject()
		{
			return $this->subject;
		}

		/**
		 * @param mixed $subject
		 */
		public function setSubject($subject)
		{
			$this->subject = $subject;
			$this->bizContentarr['subject'] = $subject;
		}

		/**
		 * @return mixed
		 */
		public function getOutTradeNo()
		{
			return $this->outTradeNo;
		}

		/**
		 * @param mixed $outTradeNo
		 */
		public function setOutTradeNo($outTradeNo)
		{
			$this->outTradeNo = $outTradeNo;
			$this->bizContentarr['out_trade_no'] = $outTradeNo;
		}

		/**
		 * @return mixed
		 */
		public function getTimeExpress()
		{
			return $this->timeExpress;
		}

		/**
		 * @param mixed $timeExpress
		 */
		public function setTimeExpress($timeExpress)
		{
			$this->timeExpress = $timeExpress;
			$this->bizContentarr['timeout_express'] = $timeExpress;
		}

		/**
		 * @return mixed
		 */
		public function getTotalAmount()
		{
			return $this->totalAmount;
		}

		/**
		 * @param mixed $totalAmount
		 */
		public function setTotalAmount($totalAmount)
		{
			$this->totalAmount = $totalAmount;
			$this->bizContentarr['total_amount'] = $totalAmount;
		}

		/**
		 * @return mixed
		 */
		public function getSellerId()
		{
			return $this->sellerId;
		}

		/**
		 * @param mixed $sellerId
		 */
		public function setSellerId($sellerId)
		{
			$this->sellerId = $sellerId;
			$this->bizContentarr['seller_id'] = $sellerId;
		}


		public function __construct( $ali_config = [])
		{
			$config = M('admin_addon')->where(['name' => 'AliPay'])->getField('config');
			$this->alipay_config = json_decode($config , true);
			parent::__construct($ali_config?$ali_config:$this->alipay_config);
			$this->bizContentarr['productCode'] = "QUICK_WAP_PAY";
			$this->bizContentarr['timeout_express'] = '1m';
		}

		public function pay()
		{
			$sysParams["notify_url"] = $this->alipay_config['notify_url'];
			$sysParams["return_url"] = $this->alipay_config['return_url'];

			return parent::wapPay($sysParams);
		}
	}