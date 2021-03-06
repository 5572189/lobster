<?php
//var_dump($_SERVER,$_REQUEST);die;
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
/**
 * Content-type设置
 */
header("Content-type: text/html; charset=utf-8");

/**
 * PHP版本检查
 */
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	die('require PHP > 5.3.0 !');
}
ini_set('display_errors','on');
/**
 * PHP报错设置
 */
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

/**
 * 开发模式环境变量前缀
 */
define('ENV_PRE', 'NOBLES_');

/**
 * 定义前台标记
 */
define('MODULE_MARK', 'Home');

/**
 * 应用目录设置
 * 安全期间，建议安装调试完成后移动到非WEB目录
 */
define('APP_PATH', './Application/');

/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define('RUNTIME_PATH', './Runtime/');

/**
 * 静态缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define('HTML_PATH', RUNTIME_PATH . 'Html/');

/**
 * 包含开发模式数据库连接配置
 */
if (isset($_SERVER[ENV_PRE . 'DEV_MODE']) && $_SERVER[ENV_PRE . 'DEV_MODE'] !== 'true') {
	@include './Data/dev.php';
}

/**
 * 系统安装及开发模式检测
 */
// if (is_file('./Data/install.lock') === false && @$_SERVER[ENV_PRE . 'DEV_MODE'] !== 'true') {
// 	define('BIND_MODULE', 'Install');
// } else {
// 	// 系统调试设置, 项目正式部署后请设置为false
// 	define('APP_DEBUG', (isset($_SERVER[ENV_PRE . 'APP_DEBUG']) && $_SERVER[ENV_PRE . 'APP_DEBUG']) ? $_SERVER[ENV_PRE . 'APP_DEBUG'] : true);
// }
define('APP_DEBUG', true);
defined('LOG_PATH') or define('LOG_PATH', './Logs/');

/**
 * 引入核心入口
 * ThinkPHP亦可移动到WEB以外的目录
 */
require './ThinkPHP/ThinkPHP.php';
