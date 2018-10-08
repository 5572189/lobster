<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Admin\Controller;

/**
 * 管理员控制器
 */
class QrcodeController extends AdminController {
	/**
	 * 管理员列表
	 *
	 * @param $tab 配置分组ID        	
	 *
	 */
	public function gen_qrcode() {
		$this->display ();
	}
	public function ajax_gen_qrcode() {
		if (IS_AJAX) {
			$wechat = new \Home\Controller\WeixinController ();
			$code = $wechat->qrcode (I ('post.val'));
			// writeLog(var_export($code, true), 'qrcode');
		} else {
			$this->error ();
		}
		
		$this->ajaxReturn ($code, 'JSON');
	}
}
