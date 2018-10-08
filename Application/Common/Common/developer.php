<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------

// 开发者二次开发公共函数统一写入此文件，不要修改function.php以便于系统升级。
define ('CURRENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);

define ('DOMAIN', strstr (CURRENT_URL, _PHP_FILE_, true));
function is_admin() {
	return session ('user_auth.uid') == 1;
}

/**
 * 用于生成插入datetime类型字段用的字符串
 */
function datetime($str = 'now') {
	return @date ("Y-m-d H:i:s", strtotime ($str));
}

/**
 * 用于清除web文件缓存
 */
function clear_web() {
	return '201809111617';
}

/**
 * 在数据列表中搜索
 *
 * @access public
 * @param array $list
 *        	数据列表
 * @param mixed $condition
 *        	查询条件
 *        	支持 array('name'=>$value) 或者 name=$value
 * @return array
 */
function list_search($list, $condition) {
	if (is_string ($condition)) {
		parse_str ($condition, $condition);
	}
	
	// 返回的结果集合
	$resultSet = array();
	foreach ( $list as $key => $data ) {
		$find = false;
		foreach ( $condition as $field => $value ) {
			if (isset ($data[$field])) {
				if (0 === strpos ($value, '/')) {
					$find = preg_match ($value, $data[$field]);
				} elseif ($data[$field] == $value) {
					$find = true;
				}
			}
		}
		if ($find) {
			$resultSet[] = &$list[$key];
		}
	}
	
	return $resultSet;
}

/**
 * 对查询结果集进行排序
 *
 * @access public
 * @param array $list
 *        	查询结果
 * @param string $field
 *        	排序的字段名
 * @param array $sortby
 *        	排序类型
 *        	asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc') {
	if (is_array ($list)) {
		$refer = $resultSet = array();
		foreach ( $list as $i => $data ) {
			$refer[$i] = &$data[$field];
		}
		
		switch ($sortby) {
			case 'asc' : // 正向排序
				asort ($refer);
				break;
			case 'desc' : // 逆向排序
				arsort ($refer);
				break;
			case 'nat' : // 自然排序
				natcasesort ($refer);
				break;
		}
		foreach ( $refer as $key => $val ) {
			$resultSet[] = &$list[$key];
		}
		
		return $resultSet;
	}
	
	return false;
}
function http($url, $param, $data = '', $method = 'GET') {
	$opts = array(CURLOPT_TIMEOUT => 30, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false);
	
	/* 根据请求类型设置特定参数 */
	$opts[CURLOPT_URL] = $url . '?' . http_build_query ($param);
	
	if (strtoupper ($method) == 'POST') {
		$opts[CURLOPT_POST] = 1;
		$opts[CURLOPT_POSTFIELDS] = $data;
		
		if (is_string ($data)) {
			// 发送JSON数据
			$opts[CURLOPT_HTTPHEADER] = array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen ($data));
		}
	}
	
	/* 初始化并执行curl请求 */
	$ch = curl_init ();
	curl_setopt_array ($ch, $opts);
	$data = curl_exec ($ch);
	$error = curl_error ($ch);
	curl_close ($ch);
	
	// 发生错误，抛出异常
	if ($error) {
		throw new \Exception ('请求发生错误：' . $error);
	}
	
	return $data;
}

/*
 * 获取图片
 * $pics图片ID
 * $type ：cover获取第一张，all获取所有
 */
function getpics($pics, $type = 'cover') {
	$arrpic = explode (',', $pics);
	if ($type == 'cover' && count ($arrpic, COUNT_NORMAL) == 1) {
		return get_cover ($arrpic[0], 'default');
	} else {
		$get_cover = function ($id) {
			return get_cover ($id, 'default');
		};
		$l = array_map ($get_cover, $arrpic);
		
		return $l;
	}
}

/*
 * 获取视频
 * $video 视频ID
 * Faina 2017.11.29
 */
function getvideo($video) {
	$res = [];
	$file = get_upload_info ($video);
	if ($file) {
		$res = $file['real_path'];
	}
	return $res;
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map
 *        	映射关系二维数组 array(
 *        	'字段名1'=>array(映射关系数组),
 *        	'字段名2'=>array(映射关系数组),
 *        	......
 *        	)
 * @return array array(
 *         array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *         ....
 *         )
 *        
 */
function int_to_string(&$data, $map = array('status' => array(1 => '正常' , -1 => '删除' , 0 => '禁用' , 2 => '未审核' , 3 => '草稿'))) {
	if ($data === false || $data === null) {
		return $data;
	}
	$data = (array) $data;
	foreach ( $data as $key => $row ) {
		foreach ( $map as $col => $pair ) {
			if (isset ($row[$col]) && isset ($pair[$row[$col]])) {
				$data[$key][$col . '_text'] = $pair[$row[$col]];
			}
		}
	}
	
	return $data;
}

/*
 * 参数解释
 * $string： 明文 或 密文
 * $operation：DECODE表示解密,其它表示加密
 * $key： 密匙
 * $expiry：密文有效期
 */
if (!function_exists ('AuthCode')) {
	function AuthCode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
		// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
		// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
		// 当此值为 0 时，则不产生随机密钥
		$ckey_length = 4;
		// 密匙
		$key = md5 ($key ? $key : C ('AUTH_KEY'));
		// 密匙a会参与加解密
		$keya = md5 (substr ($key, 0, 16));
		// 密匙b会用来做数据完整性验证
		$keyb = md5 (substr ($key, 16, 16));
		// 密匙c用于变化生成的密文
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr ($string, 0, $ckey_length) : substr (md5 (microtime ()), -$ckey_length)) : '';
		// 参与运算的密匙
		$cryptkey = $keya . md5 ($keya . $keyc);
		$key_length = strlen ($cryptkey);
		// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
		// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
		$string = $operation == 'DECODE' ? base64_decode (substr ($string, $ckey_length)) : sprintf ('%010d', $expiry ? $expiry + time () : 0) . substr (md5 ($string . $keyb), 0, 16) . $string;
		$string_length = strlen ($string);
		$result = '';
		$box = range (0, 255);
		$rndkey = array();
		
		// 产生密匙簿
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord ($cryptkey[$i % $key_length]);
		}
		
		// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上并不会增加密文的强度
		for($j = $i = 0; $i < 256; $i++) {
			// $j是三个数相加与256取余
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		
		// 核心加解密部分
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			// 在上面基础上再加1 然后和256取余
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256; // $j加$box[$a]的值 再和256取余
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			// 从密匙簿得出密匙进行异或，再转成字符，加密和解决时($box[($box[$a] + $box[$j]) % 256])的值是不变的。
			$result .= chr (ord ($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		
		if ($operation == 'DECODE') {
			// substr($result, 0, 10) == 0 验证数据有效性
			// substr($result, 0, 10) - time() > 0 验证数据有效性
			// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
			// 验证数据有效性，请看未加密明文的格式
			if ((substr ($result, 0, 10) == 0 || substr ($result, 0, 10) - time () > 0) && substr ($result, 10, 16) == substr (md5 (substr ($result, 26) . $keyb), 0, 16)) {
				return substr ($result, 26);
			} else {
				return '';
			}
		} else {
			// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
			// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
			return $keyc . str_replace ('=', '', base64_encode ($result));
		}
	}
}

/**
 * 验证手机格式
 *
 * @param string $string        	
 * @return boolean
 */
function isMobileFormat($string) {
	$pattern = "/^(0|86|17951)?1[0-9]{10}$/"; // '/^(0|86|17951)?(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/';
	return preg_match ($pattern, $string);
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
	$sys_protocal = isset ($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info = isset ($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset ($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset ($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
	
	return $sys_protocal . (isset ($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 获取网站域名
 */
function XILUDomain() {
	$server = $_SERVER['HTTP_HOST'];
	$http = is_ssl () ? 'https://' : 'http://';
	return $http . $server;
}

// 获取用户信息
function get_ljuser_info($uid, $field = '') {
	$user = M ('admin_user')->where (['id' => $uid])
		->find ();
	if (empty ($field)) {
		return $user;
	}
}

// 导出数据
function exportExcel($expTitle, $expCellName, $expTableData) {
	$xlsTitle = iconv ('utf-8', 'gb2312', $expTitle); // 文件名称
	$fileName = date ('_YmdHis'); // or $xlsTitle 文件名称可根据自己情况设定
	$cellNum = count ($expCellName);
	$dataNum = count ($expTableData);
	vendor ("phpexcel.Classes.PHPExcel");
	$objPHPExcel = new \PHPExcel ();
	$cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 
		'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$objPHPExcel->getActiveSheet (0)
		->mergeCells ('A1:' . $cellName[$cellNum - 1] . '1'); // 合并单元格
	$objPHPExcel->getActiveSheet ()
		->getColumnDimension ('A')
		->setWidth (10);
	$objPHPExcel->getActiveSheet ()
		->getColumnDimension ('B')
		->setWidth (30);
	$objPHPExcel->getActiveSheet ()
		->getColumnDimension ('C')
		->setWidth (30);
	$objPHPExcel->getActiveSheet ()
		->getColumnDimension ('D')
		->setWidth (30);
	$objPHPExcel->getActiveSheet ()
		->getColumnDimension ('E')
		->setWidth (30);
	$objPHPExcel->setActiveSheetIndex (0)
		->setCellValue ('A1', $expTitle . '  Export time:' . date ('Y-m-d H:i:s'));
	for($i = 0; $i < $cellNum; $i++) {
		$objPHPExcel->setActiveSheetIndex (0)
			->setCellValue ($cellName[$i] . '2', $expCellName[$i][1]);
	}
	// Miscellaneous glyphs, UTF-8
	for($i = 0; $i < $dataNum; $i++) {
		for($j = 0; $j < $cellNum; $j++) {
			$objPHPExcel->getActiveSheet (0)
				->setCellValue ($cellName[$j] . ($i + 3), ' ' . $expTableData[$i][$expCellName[$j][0]]);
		}
	}
	header ('pragma:public');
	header ('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
	header ("Content-Disposition:attachment;filename=$fileName.xls"); // attachment新窗口打印inline本窗口打印
	$objWriter = \PHPExcel_IOFactory::createWriter ($objPHPExcel, 'Excel5');
	$objWriter->save ('php://output');
	exit ();
}
function getIp() {
	$realip = '';
	$unknown = 'unknown';
	if (isset ($_SERVER)) {
		if (isset ($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty ($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp ($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
			$arr = explode (',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ( $arr as $ip ) {
				$ip = trim ($ip);
				if ($ip != 'unknown') {
					$realip = $ip;
					break;
				}
			}
		} else if (isset ($_SERVER['HTTP_CLIENT_IP']) && !empty ($_SERVER['HTTP_CLIENT_IP']) && strcasecmp ($_SERVER['HTTP_CLIENT_IP'], $unknown)) {
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		} else if (isset ($_SERVER['REMOTE_ADDR']) && !empty ($_SERVER['REMOTE_ADDR']) && strcasecmp ($_SERVER['REMOTE_ADDR'], $unknown)) {
			$realip = $_SERVER['REMOTE_ADDR'];
		} else {
			$realip = $unknown;
		}
	} else {
		if (getenv ('HTTP_X_FORWARDED_FOR') && strcasecmp (getenv ('HTTP_X_FORWARDED_FOR'), $unknown)) {
			$realip = getenv ("HTTP_X_FORWARDED_FOR");
		} else if (getenv ('HTTP_CLIENT_IP') && strcasecmp (getenv ('HTTP_CLIENT_IP'), $unknown)) {
			$realip = getenv ("HTTP_CLIENT_IP");
		} else if (getenv ('REMOTE_ADDR') && strcasecmp (getenv ('REMOTE_ADDR'), $unknown)) {
			$realip = getenv ("REMOTE_ADDR");
		} else {
			$realip = $unknown;
		}
	}
	$realip = preg_match ("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
	
	return $realip;
}
function getIpLookup($ip = '') {
	if (empty ($ip)) {
		$ip = GetIp ();
	}
	$res = @file_get_contents ('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
	if (empty ($res)) {
		return false;
	}
	$jsonMatches = array();
	preg_match ('#\{.+?\}#', $res, $jsonMatches);
	if (!isset ($jsonMatches[0])) {
		return false;
	}
	$json = json_decode ($jsonMatches[0], true);
	if (isset ($json['ret']) && $json['ret'] == 1) {
		$json['ip'] = $ip;
		unset ($json['ret']);
	} else {
		return false;
	}
	
	return $json;
}

// 拼装语言配置文件
function toConfig($reuslt, $type = 'cn') {
	switch ($type) {
		case 'cn' :
			$setfile = LANG_PATH . 'cn.php';
			$case = 'cntitle';
			break;
		default :
			$setfile = LANG_PATH . 'en.php';
			$case = 'entitle';
	}
	$settingstr = <<<PHP
<?php
\$_lang =
PHP;
	$outArr = [];
	$outArr = array_combine (array_column ($reuslt, 'name'), array_column ($reuslt, $case));
	$settingstr .= var_export ($outArr, 1);
	$settingstr .= ';';
	file_put_contents ($setfile, $settingstr);
}

/**
 * 获取和设置语言定义(不区分大小写)
 *
 * @param string|array $name
 *        	语言变量
 * @param mixed $value
 *        	语言值或者变量
 * @return mixed
 */
global $_lang_cn;
global $_lang_en;
$_lang = [];
$filename = LANG_PATH . 'cn.php';
if (file_exists ($filename)) {
	include_once $filename;
	$_lang_cn = $_lang;
}
$filename = LANG_PATH . 'en.php';
if (file_exists ($filename)) {
	include_once $filename;
	$_lang_en = $_lang;
}
function Y($name = null, $value = null) {
	$lang = cookie ('lang') ? cookie ('lang') : "cn";
	if ($lang == "cn") {
		return $GLOBALS['_lang_cn'][$name];
	} else {
		return $GLOBALS['_lang_en'][$name];
	}
}

/**
 * 取语言数据表字段
 *
 * @param array $data
 *        	数组
 * @param string $key
 *        	键名
 * @param string $lang
 *        	cn/en
 */
function K($data = array(), $key = '', $lang = "cn") {
	$ext = substr ($key, strlen ($key) - 3, 3);
	if ($ext != "_en" && $lang == "en") {
		$key_en = $key . "_en";
		return (isset ($data[$key_en]) && $data[$key_en]) ? $data[$key_en] : $data[$key];
	}
	return (isset ($data[$key]) && $data[$key]) ? $data[$key] : $data[$key];
}
function setPost($url, $post_data = array()) {
	$ch = curl_init ();
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt ($ch, CURLOPT_URL, $url);
	@curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 5);
	$result = curl_exec ($ch);
	$error = curl_error ($ch);
	if ($error) {
		return false;
	}
	return true;
}
function check_mobile($mobile, $type = 1) {
	$rule = "/^1[3|4|5|7|8][0-9]{9}$/";
	if ($type == 1) {
		if (!preg_match ($rule, $mobile)) {
			$result = array('status' => 0, 'msg' => '请填写正确的手机号码');
			
			return $result;
		}
	}
	$user = M ('admin_user')->where (['username' => $mobile])
		->find ();
	if ($user) {
		$result = array('status' => 0, 'msg' => '该手机号码已经被注册');
		
		return $result;
	}
	$result = array('status' => 1);
	
	return $result;
}
function nsUCode($uid = 0) {
	return AuthCode ($uid, 'ENCODE', '_<tPd[A?#~Pe<]$jwIC+}>]X.[l<dJ=o"qFM[;agaVXi+DI<F%TC#WJ:gkKyim{S');
}

// 发送短信
function sendTemplateSMS($to, $datas, $tempId) {
	$data = R ('Addons://YuntxSms/YuntxSms/sendSms', [$to, $datas, $tempId]);
	
	return $data;
}

function writeLog($content, $path = 'kit') {
	error_log ("TIME:" . date ('Y-m-d H:i:s') . "\n" . $content . "\n======================================\n", 3, './Logs/' . $path . '.log');
}
function testDomain() {
	return ['test1.noble-spirits.com'];
}
function isTestDomain() {
	return in_array ($_SERVER['HTTP_HOST'], testDomain ());
}
function tryGetTestPayment($payment) {
	if (isTestDomain ()) {
		return 0.01;
	} else {
		return $payment;
	}
}

// 过滤Emoji表情
function filterEmoji($str) {
	if ($str == null)
		return '';
	$str = preg_replace_callback ('/./u', function (array $match) {
		return strlen ($match[0]) >= 4 ? '' : $match[0];
	}, $str);
	
	return $str;
}
function shopAliConfig($shop_id = 15) {
	$cfg = M ('shop_ali_config')->where (['shop_id' => $shop_id])
		->find ();
	if ($shop_id && $cfg) {
		$config = ['gatewayUrl' => 'https://openapi.alipay.com/gateway.do'];
		return array_merge ($config, (array) $cfg);
	} else {
		$config = M ('admin_addon')->where (['name' => 'AliPay'])
			->getField ('config');
		
		$alipay_config = json_decode ($config, true);
		
		return $alipay_config;
	}
}
/**
 * 生成签名
 *
 * @param array $args        	
 * @return string
 */
function setSign($args) {
	unset ($args['sign']);
	ksort ($args); // 按数组的键排序
	$sign = '';
	foreach ( $args as $k => $v ) {
		$sign .= $k . '=' . $v;
	}
	$sign = sha1 ($sign . '7cf2db5ec261a0fa27a502d3196a6f60');
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
function sendPost($url, $post_data = array()) {
	if (!strlen (strpos ($url, "http"))) {
		if (!isTestDomain ()) {
			$url = "http://www.noble-spirits.com/shop.php?s=/" . $url;
		} else {
			$url = "http://nt.idea580.com/shop.php?s=/" . $url;
		}
	}
	$date = date ('md');
	$post_data['timestamp'] = time ();
	$post_data['sign'] = setSign ($post_data);
	$ch = curl_init ();
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt ($ch, CURLOPT_URL, $url);
	@curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
	$result = curl_exec ($ch);
	writeLog (var_export ($result, true), 'sendPost' . $date);
	$error = curl_error ($ch);
	if ($error) {
		writeLog (var_export ([$url, $error, $post_data], true), 'sendPostError' . $date);
		return false;
	}
	return $result;
}
function order_query($out_trade_no) {
	vendor ("alipay-sdk.aop.AopClient");
	vendor ("alipay-sdk.aop.request.AlipayTradeQueryRequest");
	$config = M ('admin_addon')->where (['name' => 'AliPay'])
		->getField ('config');
	// $out_trade_no = 'oI1D5j2NP998E7a9E4g2_12797';
	$alipay_config = json_decode ($config, true);
	$client = new \AopClient ();
	$client->appId = $alipay_config['app_id'];
	$client->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	$client->rsaPrivateKey = $alipay_config['merchant_private_key'];
	$client->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
	$client->signType = 'RSA2';
	$client->postCharset = 'UTF-8';
	$client->format = 'json';
	$res = new \AlipayTradeQueryRequest ();
	$res->setBizContent (json_encode (['out_trade_no' => $out_trade_no]));
	$response = $client->execute ($res);
	$trade_status = strval ($response->alipay_trade_query_response->trade_status);
	if ($trade_status == 'TRADE_SUCCESS' || $trade_status == 'TRADE_FINISHED') {
		return true;
	}
	return false;
}

function testUID() {
	return [''];
}
// 生成或者获取二维码
function getWxQrcode($type, $type_id) {
	$expire_seconds = 0;
	$model_object = D ('wxqrcode');
	$exist = $model_object->where (['type' => $type, 'relate_id' => $type_id])
		->find ();
	// 存在返回 已有二维码地址
	if ($exist) {
		return ['status' => 1, 'url' => $exist['url'], 'expire_time' => $exist['expire_time'], 'status' => $exist['status']];
	}
	switch ($type) {
		case 'order' :
			$order = D ('order')->find ($type_id);
			if (!$order) {
				return ['status' => 0, 'info' => '原关联记录不存在'];
			}
			$expire_seconds = $order['valid_date_end'] - time ();
			if ($expire_seconds <= 0) {
				return ['status' => 0, 'info' => '商品的有效期小于当前时间，无法创建'];
			}
			
			break;
		case 'appointment' :
			$appointment = D ('appointment')->find ($type_id);
			if (!$appointment) {
				return ['status' => 0, 'info' => '原关联记录不存在'];
			}
			
			$expire_seconds = $appointment['valid_date_end'] - time ();
			if ($expire_seconds <= 0) {
				return ['status' => 0, 'info' => '预约的课程有效期小于当前时间，无法创建'];
			}
			
			// code...
			break;
		default :
			writeLog ("错误的二维码获取类型 type:{$type}", 'getWxQrcode');
			
			return ['status' => 0, 'info' => "错误的二维码获取类型 type:{$type}"];
			break;
	}
	$code = D ('wxqrcode')->max ('id') + 1;
	$res = R ('Course/Weixin/qrcode', [$code, $expire_seconds]);
	if ($res['status']) {
		D ('wxqrcode')->add (['id' => $code, 'type' => $type, 'relate_id' => $type_id, 'status' => 0, 'url' => $res['data']['url'], 'create_time' => datetime (), 
			'expire_time' => $expire_seconds == 0 ? null : time_format (time () + $expire_seconds)]);
	}
	
	return $res;
}

/*
 * 获取二维码
 */
function get_qrcode($mobile, $exprie = 0) {
	$wechat = new \Home\Controller\WeixinController ();
	$qrcode = $wechat->qrcode ($mobile, $exprie);
	if ($qrcode['status'] == 0) {
		$ret = $qrcode;
	} else {
		// 保存图片;
		$url = $qrcode['data']['url'];
		$ret = downloadImageFromWeiXin ($url);
	}
	
	return $ret;
}
function downloadImageFromWeiXin($url) {
	$client = new \GuzzleHttp\Client ();
	$res = $client->request ('GET', $url);
	$ext = 'jpg';
	$tmp_name = tempnam (sys_get_temp_dir (), 'weixin_avatar') . '.' . $ext;
	file_put_contents ($tmp_name, $res->getBody ());
	$url = U ('Home/Upload/upload', ['dir' => 'image'], true, true);
	$url = str_replace ("admin.php", "index.php", $url);
	$uploadModel = new \Admin\Model\UploadModel ();
	$result = $uploadModel->curlUploadFile ($url, $tmp_name, 'image');
	if ($result === false) {
		$ret = ['status' => 0, 'info' => '上传失败'];
	} else {
		$res = json_decode ($result, true);
		if ($res['status']) {
			$ret = ['status' => 1, 'info' => '上传成功', 'id' => $res['id'], 'src' => $res['url']];
		} else {
			$ret = ['status' => 0, 'info' => '上传失败，返回格式不对'];
		}
	}
	
	return $ret;
}

/**
 * 通用的返回数据，status=0代表错误，否则代表成功
 * 
 * @param string $msg
 *        	错误信息
 * @return multitype:number unknown |multitype:number
 */
function generateCommonErrorMsg($msg) {
	return ['status' => 0, 'msg' => $msg];
}

/**
 * 通用的判断返回数据是否正常，===true代表操作成功
 * 
 * @param array $ret
 *        	generateCommonErrorMsg中生成的错误信息，或者正常返回的数据
 * @return boolean|number|string
 */
function getCommonErrorMsg($ret) {
	if (isset ($ret['msg'])) {
		return $ret['msg'];
	} else {
		return true;
	}
}
