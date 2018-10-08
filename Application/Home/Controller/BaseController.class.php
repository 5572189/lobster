<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Controller;

use Common\Controller\CommonController;

/**
 * 不需验证登录状态的父控制器
 */
class BaseController extends CommonController
{
	public $data          = [];
	//当前语言版本信息
	public $lang          = 'cn';
	public $cookie_expire = 86400;

	/**
	 * 初始化方法
	 *
	 */
	protected function _initialize()
	{
	     $this->assign('clear_web' , clear_web() );
	}
}
