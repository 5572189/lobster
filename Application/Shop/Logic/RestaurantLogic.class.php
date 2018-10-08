<?php

namespace Shop\Logic;


/**
 * Api默认控制器
 */
class RestaurantLogic {
	public function getRestaurantList($id = null, $autoSwitchData = false) {
		$map['status'] = 1;
		if ($id) {
			$map['id'] = $id;
		}
		$shops = M ('restaurant')->where ($map)
			->field ('id,title,title_en,content,content_en,address,address_en,telephone,index_pic,pics,open_hours,city,city_en')
			->select ();
		if (count($shops,COUNT_NORMAL) > 1 || !$autoSwitchData) {//有多个门店，显示列表
			foreach($shops as $k=>&$v) {
				$v['index_pic'] = getpics($v['index_pic']);
				unset($v['content']);
				unset($v['content_en']);
				unset($v['telephone']);
				unset($v['pics']);
				unset($v['open_hours']);
				
				$v['booking_stat'] = $this->getBookingStat();
			}
		}else{//仅一个门店时，显示门店详情
			foreach($shops as $k=>&$v) {
				$v['pics'] = getpics($v['pics'],'list');
				unset($v['index_pic']);
				unset($v['city']);
				unset($v['city_en']);
				$v['booking_stat'] = $this->getBookingStat();
			}
		}
		return $shops;
	}
	
	/**
	 * return 1 - 可预订  0 - 不可预订
	 */
	public function getBookingStat() {
		return 0;
	}
}