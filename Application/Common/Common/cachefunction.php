<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
// 开发者二次开发公共函数统一写入此文件，不要修改function.php以便于系统升级。
function setSeeLog() {
	$datei = fopen ("countlog.txt", "r");
	$count = fgets ($datei, 1000);
	fclose ($datei);
	$count = $count + 1;
	echo "$count";
	echo " hits";
	echo "\n";
	// opens countlog.txt to change new hit number
	$datei = fopen ("countlog.txt", "w");
	fwrite ($datei, $count);
	fclose ($datei);
}

/**
 * 获取用户信息
 */
function getUserInfoCache($uid = 0, $implement = 1) {
	$data = [];
	$key = 'UserInfo_' . $uid;
	$time = 60;
	if ($implement != 0) {
		$result = D ('Admin/user')->find ($uid);
		if ($result) {
			$data = $result;
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = D ('Admin/user')->find ($uid);
			if ($result) {
				$data = $result;
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 缓存shoppingmall_goodstype
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getGoodsTypeCache($implement = 0) {
	$data = [];
	$key = 'GoodsType';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		$result = M ('shoppingmall_goodstype')->where (['status' => 1])
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('shoppingmall_goodstype')->where (['status' => 1])
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 缓存country
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getCountryCache($implement = 0) {
	$data = [];
	$key = 'Country';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		$result = M ('country')->where (['status' => 1])
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('country')->where (['status' => 1])
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 缓存shoppingmall_brand
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getBrandCache($implement = 0) {
	$data = [];
	$key = 'Brand';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		$result = M ('shoppingmall_brand')->where (['status' => 1])
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('shoppingmall_brand')->where (['status' => 1])
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 缓存shoppingmall_breed
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getBreedCache($implement = 0) {
	$data = [];
	$key = 'Breed';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		$result = M ('shoppingmall_breed')->where (['status' => 1])
			->order ('order desc,id asc')
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('shoppingmall_breed')->where (['status' => 1])
				->order ('order desc,id asc')
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 缓存city
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getCityCache($implement = 0) {
	$data = [];
	$key = 'City';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		$result = M ('city')->where (['status' => 1])
			->order ('sort asc')
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('city')->where (['status' => 1])
				->order ('sort asc')
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 缓存cooperation_list
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getCooperationCache($implement = 0) {
	$data = [];
	$key = 'Cooperation';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		// 合作商户
		$result = M ('cms_adver a')->field ('a.*')
			->join ('left join oc_cms_index b on a.id = b.id ')
			->where (['b.status' => '1', 'b.cid' => 14, 'a.is_pickup' => 1])
			->order ('b.sort desc')
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('cms_adver a')->field ('a.*')
				->join ('left join oc_cms_index b on a.id = b.id ')
				->where (['b.status' => '1', 'b.cid' => 14, 'a.is_pickup' => 1])
				->order ('b.sort desc')
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 缓存goods_tags
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getGoodsTagsCache($implement = 0) {
	$data = [];
	$key = 'GoodsTags';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		// 商品推荐标签
		$result = M ('goods_tags')->where (['status' => '1'])
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('goods_tags')->where (['status' => '1'])
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 获取购物车商品数量
 */
function getCartNumCache($uid = 0, $implement = 0) {
	if ($uid == 0) {
		return 0;
	}
	$result = 0;
	$key = 'CartNum_' . $uid;
	$time = 120;
	if ($implement != 0) {
		$result = M ('shoppingmall_cart')->where (['uid' => $uid, 'status' => 0])
			->count ("id");
		S ($key, $result, ['expire' => $time, 'type' => 'memcache']);
	} else {
		$result = S ($key, '', ['type' => 'memcache']);
		if (empty ($result)) {
			$result = M ('shoppingmall_cart')->where (['uid' => $uid, 'status' => 0])
				->count ("id");
			S ($key, $result, ['expire' => $time, 'type' => 'memcache']);
		}
	}
	return $result < 1 ? 0 : $result;
}

/**
 * PV访问统计入口 （读取/取出）队列
 * 
 * @param $arr array        	
 * @param $type int
 *        	0加入/1取出/2返回长度
 * @param $listname 队列名
 *        	pv浏览量
 */
function setPV(array $arr, $type = 0, $listname = 'pv_new') {
	// return false;
	$queue = Common\Util\Queue::getInstance ($listname);
	if ($type == 2) {
		return $queue->len ();
	} elseif ($type == 1) {
		// writeLog($queue->len(),'popPv');
		$val = $queue->pop ();
		if ($val)
			return unserialize ($val);
		else
			return null;
	} elseif ($type == 0) {
		// 过滤一些特殊的地址
		$arrUrl = ['/index.php?s=/member/after_scan.html', '/index.php?s=/member/after_scan_status.html', '/index.php?s=/card/get_code_status.html', '/index.php?s=/member/qrcode.html', 
			'/index.php?s=/member/get_coupons_status.html'];
		if (in_array ($arr['url'], $arrUrl)) {
			return true;
		}
		$data = [];
		$ip = getIp ();
		// $ipaddress = getIpLookup($ip);
		$address = ''; // $ipaddress['country']." ".$ipaddress['province']." ".$ipaddress['city'];
		$data = ['uid' => $arr['uid'] != NULL ? $arr['uid'] : 0, 'url' => $arr['url'] != NULL ? $arr['url'] : '', 'module' => $arr['module'] != NULL ? $arr['module'] : '', 
			'controller' => $arr['controller'] != NULL ? $arr['controller'] : '', 'action' => $arr['action'] != NULL ? $arr['action'] : '', 'pram' => serialize (I ('get.')), 'ip' => ip2long ($ip), 
			'address' => $address, 'datetime' => date ('Y-m-d'), 'time' => time (), 'fromurl' => $arr['fromurl'] != NULL ? $arr['fromurl'] : '', 
			'agent' => $arr['agent'] != NULL ? $arr['agent'] : 'weixin']

		;
		// $data['tempKey'] = $data['uid'] . '_' . $data['url'] . '_' . $data['pram'] . '_' . $data['ip'] . '_' . $data['fromurl']. '_' . $data['agent'] . '_' . ($data['time']/10);
		$data = serialize ($data);
		$queue->push ($data);
	}
}
function setUserBehaviourData($data, $type = 0, $listname = 'pv_userbehaviour') {
	// return false;
	$queue = Common\Util\Queue::getInstance ($listname);
	if ($type == 2) {
		return $queue->len ();
	} elseif ($type == 1) {
		// writeLog($queue->len(),'popPv');
		$val = $queue->pop ();
		if ($val)
			return unserialize ($val);
		else
			return null;
	} elseif ($type == 0) {
		if ($data)
			$queue->push (serialize ($data));
	}
}

/**
 * click点击事件统计入口 （读取/取出）队列
 * 
 * @param $arr array        	
 * @param $type int
 *        	0加入/1取出/2返回长度
 * @param $listname 队列名
 *        	click浏览量
 */
function setClickPv(array $arr, $type = 0, $listname = 'click') {
	$queue = Common\Util\Queue::getInstance ($listname);
	if ($type == 2) {
		return $queue->len ();
	} elseif ($type == 1) {
		$val = $queue->pop ();
		if ($val)
			return unserialize ($val);
		else
			return null;
	} elseif ($type == 0) {
		$data = [];
		$ip = getIp ();
		// $ipaddress = getIpLookup($ip);
		$address = ''; // $ipaddress['country']." ".$ipaddress['province']." ".$ipaddress['city'];
		$data = ['uid' => $arr['uid'] != NULL ? $arr['uid'] : 0, 'ip' => ip2long ($ip), 'address' => $address, 'datetime' => date ('Y-m-d'), 'time' => time (), 
			'typename' => $arr['typename'] != NULL ? $arr['typename'] : '', 'desc' => $arr['desc'] != NULL ? $arr['desc'] : '', 'aid' => $arr['aid'] != NULL ? $arr['aid'] : ''];
		$data = serialize ($data);
		$queue->push ($data);
	}
}

/**
 * 首页发现的数字是否显示
 */
function setFindNum($uid = 0, $implement = 0) {
	if ($uid == 0) {
		return true;
		if ($implement != 0) {
			cookie ('ufid', 1, 60 * 60 * 24 * 90);
			return true;
		} else {
			if (cookie ('ufid')) {
				return true;
			}
		}
	} else {
		$key = 'Index_findnum_' . $uid;
		$time = 90 * 24 * 3600;
		if ($implement != 0) {
			S ($key, 1, ['expire' => $time, 'type' => 'redis']);
			return true;
		} else {
			$data = S ($key, '', ['type' => 'redis']);
			if ($data == 1) {
				return true;
			}
		}
	}
	return false;
}

/**
 * 提交订单页面链接地址缓存用于修改地址后跳转
 */
function setOrderConfirmUrl($uid = 0, $url = '') {
	$key = 'order_confirm_' . $uid;
	$time = 10 * 60; // 优化为10分钟
	if ($url != '') {
		S ($key, $url, ['expire' => $time, 'type' => 'memcache']);
		return true;
	} else {
		$data = S ($key, '', ['type' => 'memcache']);
		return $data;
	}
}

/**
 * 缓存Shop
 * 
 * @param $implement 0读取/1强制更新缓存        	
 */
function getShopCache($implement = 0) {
	$data = [];
	$key = 'Shop';
	$time = 7 * 24 * 3600;
	if ($implement != 0) {
		$result = M ('shop')->where (['status' => 1])
			->select ();
		if ($result) {
			foreach ( $result as $k => $v ) {
				$data[$v['id']] = $v;
			}
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('shop')->where (['status' => 1])
				->select ();
			if ($result) {
				foreach ( $result as $k => $v ) {
					$data[$v['id']] = $v;
				}
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 门店中英文标题
 * 
 * @param unknown $name        	
 * @param string $lang        	
 * @return unknown
 */
function getShopLangName($name, $lang = "cn") {
	$shops = getShopCache ();
	foreach ( $shops as $k => $v ) {
		if ($v['title'] == $name) {
			if ($lang == "en") {
				return $v['title_en'];
			}
			return $v['title'];
		}
		if ($v['title_en'] == $name) {
			if ($lang == "en") {
				return $v['title_en'];
			}
			return $v['title'];
		}
	}
}

/**
 * 获取企业用户附加信息
 */
function getEnterpriseInfoCache($uid = 0, $implement = 1) {
	$data = [];
	$key = 'Enterprise_' . $uid;
	$time = 60;
	if ($implement != 0) {
		$result = M ('user_info')->field ('nums,status as enterprise_status,deleted as enterprise_deleted,company_name,taxpayer_id')
			->where (['uid' => $uid])
			->find ();
		if ($result) {
			$data = $result;
			S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = json_decode (S ($key, '', ['type' => 'memcache']), true);
		if (empty ($data)) {
			$result = M ('user_info')->field ('nums,status as enterprise_status,deleted as enterprise_deleted,company_name,taxpayer_id')
				->where (['uid' => $uid])
				->find ();
			if ($result) {
				$data = $result;
				S ($key, json_encode ($data), ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}

/**
 * 获取/设置禁用企业/个人账号
 */
function getUserStatus($uid, $status = 1, $type = 0) {
	$check = false;
	$time = 60;
	$key = 'USER_FORBID';
	$cacheVal = S ($key, '', ['type' => 'redis']);
	if ($cacheVal)
		$data = json_decode ($cacheVal, true);
	if (empty ($data)) {
		$result = M ('admin_user')->where (['status' => 2])
			->getField ('id', '2000');
		S ($key, json_encode ($result), ['expire' => $time, 'type' => 'redis']);
		if (in_array ($uid, $result)) {
			$check = true;
		} else {
			return true;
		}
	} else {
		if (in_array ($uid, $data)) {
			$check = true;
		} else {
			return true;
		}
	}
	if ($check == true) {
		$ufid = cookie ('ufid');
		$lang = cookie ('lang');
		session ('user_auth', null);
		session ('user_auth_sign', null);
		cookie ('uid', null);
		$forward = Cookie ('__forward__');
		session_destroy ();
		cookie (null, 'NOBLES_');
		// 退出状态下不需要清空的cookie，重新设置
		cookie ('lang', $lang, 86400 * 30);
		if ($ufid) {
			cookie ('ufid', $ufid, 86400 * 90);
		}
	}
}

/**
 * 获取微信分享的token
 */
function getJsApi($implement = 0) {
	$data = [];
	$key = 'jsapi_' . md5 ("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
	$time = 10 * 60;
	if ($implement != 0) {
		$result = R ('Home/Weixin/jsapi', [['onMenuShareAppMessage', 'onMenuShareTimeline', 'scanQRCode']]);
		if ($result) {
			$data = $result;
			S ($key, $data, ['expire' => $time, 'type' => 'memcache']);
		}
	} else {
		$data = S ($key, '', ['type' => 'memcache']);
		if (empty ($data)) {
			$result = R ('Home/Weixin/jsapi', [['onMenuShareAppMessage', 'onMenuShareTimeline', 'scanQRCode']]);
			if ($result) {
				$data = $result;
				S ($key, $data, ['expire' => $time, 'type' => 'memcache']);
			}
		}
	}
	return $data;
}