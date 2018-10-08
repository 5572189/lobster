<?php
namespace Shop\Admin;
use Admin\Controller\AdminController;
/**
 * @title : 后台餐厅消费记录
 * @time  : 2017年11月16日/上午11:15:50
 */
class ConsumeAdmin extends AdminController {
	private $_checkinfo = [ '1' => '未支付' , '2' => '已支付' ] ;
	
	/**
	 * @title : 餐厅消费记录
	 * @time  : 2017年11月16日/上午11:17:42
	 */
	public function index () {
		$where = [] ;
		$where ['p'] = I ( 'get.p' , 1 ) ;
		$shop_id = trim(I ( 'get.shop_id' , null ) );
	
		$this->assign('shops' , $this->_getnsshops() ) ;
		
		if ( empty($shop_id) ) {
		    $this->assign('checkinfo' , $this->_checkinfo ) ;
		    $this->display() ;
		    return;
		}

		$where ['shop_id'] = $shop_id ;
		
		$ordernum = trim(I ( 'get.ordernum' , null ) );
		if ( !empty($ordernum) ) {
			$where ['ordernum'] = $ordernum ; 
		}
		
		$dates = trim(I ( 'get.dates' , null ) );
		if ( !empty($dates) ) {
			$where ['dates'] = $dates ;
		}
		$out_trade_no = trim(I ( 'get.out_trade_no' , null ) );
		if ( !empty($out_trade_no) ) {
			$where ['out_trade_no'] = $out_trade_no ;
		}
		$checkinfo = trim(I ( 'get.checkinfo' , null ) );
		if ( $checkinfo ) {
			$where ['checkinfo'] = $checkinfo ;
		}
		$rest = new \Shop\Controller\IndexController() ;
		$data = $rest->getShopConsume( $where ) ; 
		$this->assign('data' , $data['data']['result']['data'] ) ;
		$pages = new \Common\Util\Think\Page ($data['data']['result']['count'] , C ( "ADMIN_PAGE_ROWS" )) ; 
		$this->assign('pages' , $pages->show()) ; 
		$this->assign('get' ,I ( 'get.') ) ;
		$this->assign('checkinfo' , $this->_checkinfo ) ; 
		$this->display() ; 
	}
	
	/**
	 * @title : 订单导出
	 * @time  : 2017年11月23日/上午10:36:58
	 */
	public function export () {
		$where = [] ;
		
		$shop_id = trim(I ( 'get.shop_id' , null ) );
		if ( empty($shop_id) ) {		
		    return;
		}		
		$where ['shop_id'] = $shop_id ;
		
		$ordernum = trim(I ( 'get.ordernum' , null ) );
		if ( !empty($ordernum) ) {
			$where ['ordernum'] = $ordernum ;
		}
		$dates = trim(I ( 'get.dates' , null ) );
		if ( !empty($dates) ) {
			$where ['dates'] = $dates ;
		}
		$out_trade_no = trim(I ( 'get.out_trade_no' , null ) );
		if ( !empty($out_trade_no) ) {
			$where ['out_trade_no'] = $out_trade_no ;
		}
		$checkinfo = trim(I ( 'get.checkinfo' , null ) );
		if ( $checkinfo ) {
			$where ['checkinfo'] = $checkinfo ;
		}
		$rest = new \Shop\Controller\IndexController() ;
		$data = $rest->exportShopConsume( $where ) ;
		
		$xlsName = "餐厅消费记录";
		$xlsCell = array (
			array('out_trade_no', '餐厅订单号'),
			array('ordernum', 'NS订单号'),
			array('mobile' , '用户手机号') ,
			array('username' , '用户姓名') ,
			array('level_name' , '用户等级') ,
			array('food_info' , '菜单信息') ,
			array('payment' , '订单支付总价') ,
			array('checkinfo' , '订单支付状态') ,
			array('user_coupons' , '优惠券') ,
			array('create_time' , '订单创建时间') 
		);
		$xlsData = [];
		foreach($data['data']['result']['data'] as $k => $v) {
			$xlsData[$k]['out_trade_no'] = $v['out_trade_no'];
			$xlsData[$k]['ordernum'] = $v['ordernum'];
			$xlsData[$k]['mobile'] = $v['mobile'];
			$xlsData[$k]['username'] = $v['username'];
			$xlsData[$k]['level_name'] = $v['level_name'];
			$xlsData[$k]['food_info'] = $v['food_info'];
			$xlsData[$k]['payment'] = $v['payment'];
			$xlsData[$k]['checkinfo'] = $v['checkinfo'];
			$xlsData[$k]['user_coupons'] = $v['user_coupons'];
			$xlsData[$k]['create_time'] = $v['create_time'];
		}
		
		exportExcel($xlsName , $xlsCell , $xlsData);
	}
	
	// 获取NS_shop_id
	function _getnsshops(){
	    $shops = [];
	    // 获取所有餐厅
        $map['status'] = array('neq', '0'); 
        $shops = M('restaurant')->where($map)->select();
        
	    return $shops;
	}
}
