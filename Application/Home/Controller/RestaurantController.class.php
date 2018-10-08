<?php

namespace Home\Controller;


/**
 * Api默认控制器
 */
class RestaurantController extends BaseController {
	public function ajax_getRestaurantList() {
		if (IS_AJAX){
			$id = I('post.id', null);
			$data = D('Shop/Restaurant','Logic')->getRestaurantList($id, true);
			$this->ajaxReturn($data,'JSON');
		}else{
			$this->error();
		}
	}
}