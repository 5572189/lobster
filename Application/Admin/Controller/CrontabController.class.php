<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Util\Queue;

/**
 * 链接控制器
 */
class CrontabController extends AdminController {
	/**
	 * 链接列表
	 */
	public function index() {
		// 搜索
		$queue_names = ['pv', 'pv_new', 'click', 'wechat_send', 'pv_userbehaviour'];
		
		$data = [];
		
		foreach ( $queue_names as $v ) {
			$queue = Queue::getInstance ($v);
			$data[] = ['name' => $v, 'num' => $queue->len ()];
		}
		
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder ();
		$builder->setMetaTitle ('链接列表')
			->addTableColumn ('name', '队列名称')
			->addTableColumn ('num', '队列长度')
			->setTableDataList ($data)
			->display ();
	}
}
