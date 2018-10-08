<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Controller;

/**
 * 需验证登录状态的父控制器
 */
class BaseinfoController extends BaseController
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
		parent::_initialize ();
		
		$this->uid = AuthCode (cookie ('uid'), 'DECODE');
		
	}
}
