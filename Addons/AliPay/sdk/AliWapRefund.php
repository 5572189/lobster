<?php
    /**
     * Created by PhpStorm.
     * User: Kit
     * Date: 2017/4/25
     * Time: 11:13
     */

    namespace Addons\AliPay\sdk;


    class AliWapRefund extends AlipayClient
    {
        // 商户订单号.
        private $outTradeNo;

        // 支付宝交易号
        private $tradeNo;

        // 退款的金额
        private $refundAmount;

        // 退款原因说明
        private $refundReason;

        // 标识一次退款请求号，同一笔交易多次退款保证唯一，部分退款此参数必填
        private $outRequestNo;

        protected $bizContentarr = array();

        private $bizContent = NULL;

        private $alipay_config = null;

        public function getBizContent()
        {
            if(!empty($this->bizContentarr)){
                $this->bizContent = json_encode($this->bizContentarr,JSON_UNESCAPED_UNICODE);
            }
            return $this->bizContent;
        }

        public function getTradeNo()
        {
            return $this->tradeNo;
        }

        public function setTradeNo($tradeNo)
        {
            $this->tradeNo = $tradeNo;
            $this->bizContentarr['trade_no'] = $tradeNo;
        }

        public function getOutTradeNo()
        {
            return $this->outTradeNo;
        }

        public function setOutTradeNo($outTradeNo)
        {
            $this->outTradeNo = $outTradeNo;
            $this->bizContentarr['out_trade_no'] = $outTradeNo;
        }

        public function getRefundAmount()
        {
            return $this->refundAmount;
        }

        public function setRefundAmount($refundAmount)
        {
            $this->refundAmount = $refundAmount;
            $this->bizContentarr['refund_amount'] = $refundAmount;
        }

        public function getRefundReason()
        {
            return $this->refundReason;
        }

        public function setRefundReason($refundReason)
        {
            $this->refundReason = $refundReason;
            $this->bizContentarr['refund_reason'] = $refundReason;
        }

        public function getOutRequestNo()
        {
            return $this->outRequestNo;
        }

        public function setOutRequestNo($outRequestNo)
        {
            $this->outRequestNo = $outRequestNo;
            $this->bizContentarr['out_request_no'] = $outRequestNo;
        }

        public function __construct()
        {
            $config = M('admin_addon')->where(['name' => 'AliPay'])->getField('config');

            $this->alipay_config = json_decode($config , true);
            parent::__construct($this->alipay_config);
            $this->bizContentarr['productCode'] = "QUICK_WAP_PAY";
            $this->bizContentarr['timeout_express'] = '1m';
        }

        public function refund()
        {
            return parent::wapRefund();
        }
    }