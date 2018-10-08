<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Home\Controller;

/**
 * 幻灯片控制器
 */
class SliderController extends BaseController {
	
	public function ajax_getBanner()
	{
		if (IS_AJAX) {
			$type = I('type', 0);
			$limit = I('limit',5);
			
			$data = D('Cms/Slider')->getList($type, $limit);
			$this->ajaxReturn($data,'JSON');
			exit;
		} else {
			$this->error();
		}		
	}
}
