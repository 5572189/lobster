<?php
	/**
	 * Created by PhpStorm.
	 * User: Kit
	 * Date: 2017/4/24
	 * Time: 12:01
	 */

	namespace Addons\AliPay\sdk;


	class AlipayClient
	{
		//支付宝网关地址
		public $gateway_url = "https://openapi.alipay.com/gateway.do";

		//支付宝公钥
		public $alipay_public_key;

		//商户私钥
		public $private_key;

		//应用id
		public $appid;

		//编码格式
		public $charset = "UTF-8";
		// 表单提交字符集编码
		public $postCharset = "UTF-8";

		public $token = NULL;

		//返回数据格式
		public $format = "json";

		//签名方式
		public $signtype = "RSA2";
		protected $bizContentarr = array();
		private $bizContent = NULL;

		public function __construct($alipay_config = null)
		{
			$this->gateway_url = $alipay_config['gatewayUrl'];
			$this->appid = $alipay_config['app_id'];
			$this->private_key = $alipay_config['merchant_private_key'];
			$this->alipay_public_key = $alipay_config['alipay_public_key'];
			//$this->charset = $alipay_config['charset'];
			//$this->signtype = $alipay_config['sign_type'];

		}
		
		public function setBizContentArr ( $bizContentarr = [] ) {
			$this->bizContentarr = $bizContentarr ; 
		}
		/**
		 * @return null
		 */
		public function getBizContent()
		{
			if (!empty($this->bizContentarr)) {
				$this->bizContent = json_encode($this->bizContentarr , JSON_UNESCAPED_UNICODE);
			}

			return $this->bizContent;
		}

		public function wapPay($sysParams)
		{
			$sysParams["product_code"] = 'QUICK_WAP_PAY';
			$sysParams["charset"] = $this->charset;
			$sysParams["method"] = 'alipay.trade.wap.pay';
			$sysParams["app_id"] = $this->appid;
			$sysParams["format"] = $this->format;
			$sysParams["sign_type"] = $this->signtype;
			$sysParams["timestamp"] = date("Y-m-d H:i:s");
			$sysParams["biz_content"] = $this->getBizContent();
			$sysParams["sign"] = $this->sign($this->getSignContent($sysParams) , $sysParams["sign_type"]);
			$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $this->gateway_url . "?charset=" . trim($sysParams["charset"]) . "' method='POST'>";
			while (list ($key , $val) = each($sysParams)) {
				$val = str_replace("'" , "&apos;" , $val);
				$sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
			}

			//submit按钮控件请不要含有name属性
			$sHtml = $sHtml . "<input type='submit' value='ok' style='display:none;''></form>";
			$sHtml = $sHtml . "<script>document.forms['alipaysubmit'].submit();</script>";

			return $sHtml;
		}

		public function wapRefund()
		{
			$sysParams["charset"] = $this->charset;
			$sysParams["method"] = 'alipay.trade.refund';
			$sysParams["app_id"] = $this->appid;
			$sysParams["format"] = $this->format;
			$sysParams["sign_type"] = $this->signtype;
			$sysParams["timestamp"] = date("Y-m-d H:i:s");
			$sysParams["biz_content"] = $this->getBizContent();
			$sysParams["sign"] = $this->sign($this->getSignContent($sysParams) , $sysParams["sign_type"]);
			//系统参数放入GET请求串
			$requestUrl = $this->gateway_url . "?";
			foreach ($sysParams as $sysParamKey => $sysParamValue) {
				$requestUrl .= "$sysParamKey=" . urlencode($this->characet($sysParamValue , $this->postCharset)) . "&";
			}
			$requestUrl = substr($requestUrl , 0 , -1);

			$res =  $this->curl($requestUrl);
			$res = json_decode($res,true);
			$response = $res['alipay_trade_refund_response'];
			if($response['code'] == 10000){
				return true;
			}else{
				return false;
			}
		}

		protected function sign($data , $signType = "RSA")
		{
			if ($this->checkEmpty($this->rsaPrivateKeyFilePath)) {
				$priKey = $this->private_key;
				$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
					wordwrap($priKey , 64 , "\n" , true) .
					"\n-----END RSA PRIVATE KEY-----";
			} else {
				$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
				$res = openssl_get_privatekey($priKey);
			}
			($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
			if ("RSA2" == $signType) {
				openssl_sign($data , $sign , $res , OPENSSL_ALGO_SHA256);
			} else {
				openssl_sign($data , $sign , $res);
			}

			if (!$this->checkEmpty($this->rsaPrivateKeyFilePath)) {
				openssl_free_key($res);
			}
			$sign = base64_encode($sign);

			return $sign;
		}

		function verify($data , $sign , $rsaPublicKeyFilePath , $signType = 'RSA')
		{

			if ($this->checkEmpty($this->alipayPublicKey)) {

				$pubKey = $this->alipay_public_key;
				$res = "-----BEGIN PUBLIC KEY-----\n" .
					wordwrap($pubKey , 64 , "\n" , true) .
					"\n-----END PUBLIC KEY-----";
			} else {
				//读取公钥文件
				$pubKey = file_get_contents($rsaPublicKeyFilePath);
				//转换为openssl格式密钥
				$res = openssl_get_publickey($pubKey);
			}

			($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

			//调用openssl内置方法验签，返回bool值

			if ("RSA2" == $signType) {
				$result = (bool)openssl_verify($data , base64_decode($sign) , $res , OPENSSL_ALGO_SHA256);
			} else {
				$result = (bool)openssl_verify($data , base64_decode($sign) , $res);
			}

			if (!$this->checkEmpty($this->alipayPublicKey)) {
				//释放资源
				openssl_free_key($res);
			}

			return $result;
		}

		protected function checkEmpty($value)
		{
			if (!isset($value))
				return true;
			if ($value === null)
				return true;
			if (trim($value) === "")
				return true;

			return false;
		}

		function getSignContent($params)
		{
			ksort($params);

			$stringToBeSigned = "";
			$i = 0;
			foreach ($params as $k => $v) {
				if (false === $this->checkEmpty($v) && "@" != substr($v , 0 , 1)) {

					// 转换成目标字符集
					$v = $this->characet($v , 'UTF-8');

					if ($i == 0) {
						$stringToBeSigned .= "$k" . "=" . "$v";
					} else {
						$stringToBeSigned .= "&" . "$k" . "=" . "$v";
					}
					$i++;
				}
			}

			unset ($k , $v);

			return $stringToBeSigned;
		}

		function characet($data , $targetCharset)
		{

			if (!empty($data)) {
				$fileType = 'UTF-8';
				if (strcasecmp($fileType , $targetCharset) != 0) {
					$data = mb_convert_encoding($data , $targetCharset , $fileType);
				}
			}


			return $data;
		}

		function curl($url , $postFields = null)
		{
			$ch = curl_init();
			curl_setopt($ch , CURLOPT_URL , $url);
			curl_setopt($ch , CURLOPT_FAILONERROR , false);
			curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
			curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);

			$postBodyString = "";
			$encodeArray = Array();
			$postMultipart = false;


			if (is_array($postFields) && 0 < count($postFields)) {

				foreach ($postFields as $k => $v) {
					if ("@" != substr($v , 0 , 1)) //判断是不是文件上传
					{

						$postBodyString .= "$k=" . urlencode($this->characet($v , $this->postCharset)) . "&";
						$encodeArray[$k] = $this->characet($v , $this->postCharset);
					} else //文件上传用multipart/form-data，否则用www-form-urlencoded
					{
						$postMultipart = true;
						$encodeArray[$k] = new \CURLFile(substr($v , 1));
					}

				}
				unset ($k , $v);
				curl_setopt($ch , CURLOPT_POST , true);
				if ($postMultipart) {
					curl_setopt($ch , CURLOPT_POSTFIELDS , $encodeArray);
				} else {
					curl_setopt($ch , CURLOPT_POSTFIELDS , substr($postBodyString , 0 , -1));
				}
			}

			if ($postMultipart) {

				$headers = array('content-type: multipart/form-data;charset=' . $this->postCharset . ';boundary=' . $this->getMillisecond());
			} else {

				$headers = array('content-type: application/x-www-form-urlencoded;charset=' . $this->postCharset);
			}
			curl_setopt($ch , CURLOPT_HTTPHEADER , $headers);
			$reponse = curl_exec($ch);
			curl_close($ch);

			return $reponse;
		}
	}