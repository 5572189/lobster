<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------

/**
 * OpenCMF全局配置文件
 */
$_config = array(
	'LOG_RECORD'           => false, //进行日志记录
	'LOG_EXCEPTION_RECORD' => false, //是否记录异常信息日志
	'LOG_LEVEL'            => 'EMERG,ALERT,CRIT,ERR,WARN,NOTIC', //

	'ALIPAY_CONFIG'          => array(
		'app_id' =>'2016090701861932',
		'partner' => '2088421745031753', //合作身份者ID
		'seller_id' => '3445707593@qq.com', //收款支付宝账号
		'key' => 'q69waqpuyoo8nnccjokhkq826c1x3s5h', //key
		'private_key_path' => XILUDomain(). __ROOT__ . '/ThinkPHP/Library/Vendor/Alipay/key/rsa_private_key.pem', //商户私钥
		'ali_public_key_path' => XILUDomain(). __ROOT__ . '/ThinkPHP/Library/Vendor/Alipay/key/alipay_public_key.pem', //支付宝公钥
		'notify_url' => XILUDomain(). __ROOT__ . '/index.php/Home/AliPay/notify_url', //服务器异步通知页面路径
		'return_url' => XILUDomain(). __ROOT__ . '/index.php/Home/AliPay/return_url', //页面跳转同步通知页面路径
		'sign_type' => strtoupper('RSA'), //签名方式
		'input_charset' => strtolower('utf-8'), //字符编码格式
		'cacert' => XILUDomain(). __ROOT__ . '/ThinkPHP/Library/Vendor/Alipay/Alipay/cacert.pem', //ca证书
		'transport' => 'http', //访问模式
		'payment_type' => '1', //支付类型
		'service' => 'alipay.wap.create.direct.pay.by.user' //产品类型
	),
	'FEIGE_CONFIG' => [
		'account' => '14894' ,
		'pwd' => '644d09ad2253493a229f13e77' ,
		'sign_id' => '33635' ,
		'url' => [
			'send_msg_url' => 'http://api.feige.ee/SmsService/Send'
		]
	] ,

	/**
	 * 产品配置
	 * 根据OpenCMF用户协议：
	 * 任何情况下使用OpenCMF均需获取官方授权（除了开源版本即CoreThink），违者追究法律责任
	 */
	'PRODUCT_NAME'         => 'Red Lobster', // 产品名称
	'PRODUCT_LOGO'         => '<b>红龙虾</b>', // 产品Logo
	'CURRENT_VERSION'      => '1.0.0', // 当前版本号
	'DEVELOP_VERSION'      => 'release', // 开发版本号
	'BUILD_VERSION'        => '201608202050', // 编译标记
	'PRODUCT_MODEL'        => 'corethink', // 产品型号
	'PRODUCT_TITLE'        => '定制版', // 产品标题
	'WEBSITE_DOMAIN'       => '', // 官方网址
	'UPDATE_URL'           => '/appstore/home/core/update', // 官方更新网址
	'COMPANY_NAME'         => '诺伯丝聚酿国际贸易（上海）有限公司', // 公司名称
	'DEVELOP_TEAM'         => '诺伯丝聚酿国际贸易（上海）有限公司', // 当前项目开发团队名称

	// 产品简介
	'PRODUCT_INFO'         => '',

	// 公司简介
	'COMPANY_INFO'         => '',
	'WELCOME_WORD'         => "",

	// 'WELCOME_WORD'         => "<h1>欢迎进入管理后台</h1>",

	// 系统主页地址配置
	'HOME_PAGE'            => (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . __ROOT__,

	//'HOME_PAGE'            => (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "/index.php?s=/shoppingmall/index/index.html",
	// URL模式
	'URL_MODEL'            => '3',

	// 全局过滤配置
	'DEFAULT_FILTER'       => '', //TP默认为htmlspecialchars

	// 预先加载的标签库
	'TAGLIB_PRE_LOAD'      => 'Home\\TagLib\\Opencmf',

	// URL配置
	'URL_CASE_INSENSITIVE' => true, // 不区分大小写

	// 应用配置
	'DEFAULT_MODULE'       => 'Home',
	'MODULE_DENY_LIST'     => array('Common'),
	'MODULE_ALLOW_LIST'    => array('Home', 'Install', 'PC'),

	// 模板相关配置
	'TMPL_PARSE_STRING'    => array(
		'__PUBLIC__'     => __ROOT__ . '/Public',
		'__CUI__'        => __ROOT__ . '/Public/libs/cui',
		'__ADMIN_IMG__'  => __ROOT__ . '/' . APP_PATH . 'Admin/View/Public/img',
		'__ADMIN_CSS__'  => __ROOT__ . '/' . APP_PATH . 'Admin/View/Public/css',
		'__ADMIN_JS__'   => __ROOT__ . '/' . APP_PATH . 'Admin/View/Public/js',
		'__ADMIN_LIBS__' => __ROOT__ . '/' . APP_PATH . 'Admin/View/Public/libs',
		'__HOME_IMG__'   => __ROOT__ . '/' . APP_PATH . 'Home/View/Public/img',
		'__HOME_CSS__'   => __ROOT__ . '/' . APP_PATH . 'Home/View/Public/css',
		'__HOME_JS__'    => __ROOT__ . '/' . APP_PATH . 'Home/View/Public/js',
		'__HOME_LIBS__'  => __ROOT__ . '/' . APP_PATH . 'Home/View/Public/libs',
	),

	// 系统功能模板
	'USER_CENTER_SIDE'     => APP_PATH . 'User/View/Index/side.html',
	'USER_CENTER_FORM'     => APP_PATH . 'User/View/Builder/form.html',
	'USER_CENTER_LIST'     => APP_PATH . 'User/View/Builder/list.html',
	'USER_LOGIN_MODAL'     => APP_PATH . 'User/View/User/login_modal.html',
	'HOME_PUBLIC_LAYOUT'   => APP_PATH . 'Home/View/Public/layout.html',
	'ADMIN_PUBLIC_LAYOUT'  => APP_PATH . 'Admin/View/Public/layout.html',

	// 错误页面模板
	'TMPL_ACTION_ERROR'    => APP_PATH . 'Home/View/Public/think/error.html', // 错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'  => APP_PATH . 'Home/View/Public/think/success.html', // 成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'  => APP_PATH . 'Home/View/Public/think/exception.html', // 异常页面的模板文件

	// 文件上传默认驱动
	'UPLOAD_DRIVER'        => 'Local',

	// 文件上传相关配置
	'UPLOAD_CONFIG'        => array(
		'mimes'    => '', // 允许上传的文件MiMe类型
		'maxSize'  => 2 * 1024 * 1024, // 上传的文件大小限制 (0-不做限制，默认为2M，后台配置会覆盖此值)
		'autoSub'  => true, // 自动子目录保存文件
		'subName'  => array('date', 'Y-m-d'), // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => './Uploads/', // 保存根路径
		'savePath' => '', // 保存路径
		'saveName' => array('uniqid', ''), // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', // 文件保存后缀，空则使用原后缀
		'replace'  => false, // 存在同名是否覆盖
		'hash'     => true, // 是否生成hash编码
		'callback' => false, // 检测文件是否存在回调函数，如果存在返回文件信息数组
	),
);

// 获取数据库配置信息，手动修改数据库配置请修改./Data/db.php，这里无需改动
if (is_file('./Data/db.php')) {
	$db_config = include './Data/db.php'; // 包含数据库连接配置
} else {
	// 开启开发部署模式
	if (@$_SERVER[ENV_PRE . 'DEV_MODE'] === 'true') {
		// 数据库配置
		$db_config = array(
			'DB_TYPE'   => $_SERVER[ENV_PRE . 'DB_TYPE'] ?: 'mysql', // 数据库类型
			'DB_HOST'   => $_SERVER[ENV_PRE . 'DB_HOST'] ?: '43.254.240.25', // 服务器地址
			'DB_NAME'   => $_SERVER[ENV_PRE . 'DB_NAME'] ?: 'anzhe', // 数据库名
			'DB_USER'   => $_SERVER[ENV_PRE . 'DB_USER'] ?: 'root', // 用户名
			'DB_PWD'    => $_SERVER[ENV_PRE . 'DB_PWD'] ?: '', // 密码
			'DB_PORT'   => $_SERVER[ENV_PRE . 'DB_PORT'] ?: '3306', // 端口
			'DB_PREFIX' => $_SERVER[ENV_PRE . 'DB_PREFIX'] ?: 'oc_', // 数据库表前缀
		);
	} else {
		// 数据库配置
		$db_config = array(
			'DB_TYPE'   => 'mysql', // 数据库类型
			'DB_HOST'   => '43.254.240.25', // 服务器地址
			'DB_NAME'   => 'anzhe', // 数据库名
			'DB_USER'   => 'root', // 用户名
			'DB_PWD'    => '', // 密码
			'DB_PORT'   => '3306', // 端口
			'DB_PREFIX' => 'oc_', // 数据库表前缀
		);
	}
}
// $db_config = array(
// 	'DB_TYPE' => 'pdo',
// 	'DB_USER' => 'root',
// 	'DB_PWD' => '',
// 	'DB_DSN' => 'mysql:host=43.254.240.25;dbname=nobles;charset=utf8mb4',
// 	'DB_PREFIX' => 'oc_',
// );

$cache_config = array(
// 	/* 数据缓存设置 */
// 	'DATA_CACHE_TIME'        => 300, // 数据缓存有效期 0表示永久缓存
// 	'DATA_CACHE_COMPRESS'    => false, // 数据缓存是否压缩缓存
// 	'DATA_CACHE_CHECK'       => false, // 数据缓存是否校验缓存
// 	'DATA_CACHE_PREFIX'      => 'ANZHE', // 缓存前缀
// 	'DATA_CACHE_TYPE'        => 'Memcache', // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
// 	'DATA_CACHE_PATH'        => TEMP_PATH, // 缓存路径设置 (仅对File方式缓存有效)
// 	'DATA_CACHE_KEY'         => '', // 缓存文件KEY (仅对File方式缓存有效)
// 	'DATA_CACHE_SUBDIR'      => false, // 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)
// 	'DATA_PATH_LEVEL'        => 1, // 子目录缓存级别
);

// 如果数据表字段名采用大小写混合需配置此项
$db_config['DB_PARAMS'] = array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL);

// 返回合并的配置
return array_merge(
	$_config, // 系统全局默认配置
	$db_config, // 数据库配置数组
	$cache_config, // 缓存配置
	include APP_PATH . '/Common/Builder/config.php' // 包含Builder配置
);
