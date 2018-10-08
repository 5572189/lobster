<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Home\Controller;

/**
 * 前台默认控制器
 */
class IndexController extends BaseController {
	public $uid = 0;
	public function _initialize() {
		parent::_initialize ();
		
		$this->uid = AuthCode (cookie ('uid'), 'DECODE');
		$this->assign ('nsWebHost', C ('nsWebHost'));
		if (!cookie ('openid')) {
			// wechatAuth();
		}
	}
	
	/**
	 * 首页
	 */
	public function index() {
		if (IS_AJAX){
			$data = [];
			$data['coupon'] = [];
			$data['restaurant'] = D('Shop/Restaurant','Logic')->getRestaurantList();
			$data['news'] = D('Cms/Customcms','Logic')->newsList(3);
			$this->ajaxReturn($data, 'JSON');
		}else{
			$current_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			if (!cookie ('target_url')) {
				cookie ('target_url', $current_url, 3600 * 24 * 5);
			}
			if ((!cookie ('openid') || !$this->uid) && is_weixin ()) {
				redirect (U ('home/Oauth/wechat'));
			}
			
	// 		// writeLog('index','index');
	// 		$shop_list = D ('shop')->get_shop_list ();
	// 		$news_list = D ('news')->get_news_list ();
			
	// 		$this->assign ('shop_list', json_encode ($shop_list, JSON_UNESCAPED_UNICODE));
	// 		$this->assign ('news_list', json_encode ($news_list, JSON_UNESCAPED_UNICODE));
			
			$jsapi = R ('Home/Weixin/jsapi', [['previewImage', 'onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone']]);
			$this->assign ('jsapi', $jsapi);
			$this->assign ('meta_title', '首页 | Home');
			$this->display ();
		}
	}
	
	/**
	 * 关于简介
	 */
	public function about() {
		$this->assign('meta_title', '关于我们 | Our Story');
		$this->display ();
	}
		
	/**
	 * 菜单
	 */
	public function menu() {
		$list_menu = M ('cms_menu a')->join ('left join oc_cms_index b on a.id = b.id ')
			->where (['b.status' => '1'])
			->field ('a.*')
			->order ('b.sort desc')
			->select ();
		foreach ( $list_menu as $k => &$v ) {
			$list_menu[$k]['pic'] = getpics ($v['pic']);
		}
		
// 		$list_video = M ('cms_video a')->join ('left join oc_cms_index b on a.id = b.id ')
// 			->where (['b.status' => '1'])
// 			->field ('a.*')
// 			->order ('b.sort desc')
// 			->select ();
// 		foreach ( $list_video as $k => &$v ) {
// 			$list_video[$k]['file'] = getvideo ($v['file']);
// 			$list_video[$k]['cover'] = getpics ($v['cover']);
// 		}
		
// 		$list_shop = D ('shop')->get_shop_list ();
		
		$this->assign ('list_menu', json_encode ($list_menu, JSON_UNESCAPED_UNICODE));
// 		$this->assign ('list_video', json_encode ($list_video, JSON_UNESCAPED_UNICODE));
// 		$this->assign ('list_shop', json_encode ($list_shop, JSON_UNESCAPED_UNICODE));
		
		$this->assign ('tab', I ('get.tab', 1));
		
		$this->display ();
	}
	
	/**
	 * 环境详情
	 */
	public function shop_pics() {
		$shop_id = I ('id', 0);
		$shop = M ('cms_shop')->where (['id' => $shop_id])
			->field ('pics')
			->find ();
		$list = getpics ($shop['pics'], 'all');
		$size = ceil (count ($list) / 2);
		$list = array_chunk ($list, $size);
		
		$this->assign ('list', json_encode ($list, JSON_UNESCAPED_UNICODE));
		$this->display ();
	}
	
	/**
	 * 餐厅详情
	 */
	public function shop_detail() {
		$id = I ('id', 0);
		// $data = M('cms_shop a')
		// ->join('left join oc_cms_index b on a.id = b.id ')
		// ->where(['b.status' => '1' , 'a.id' => $id])
		// ->field('a.id,a.picture,a.title,a.content,a.open_hours,a.address,a.telephone')
		// ->find();
		// $data['picture'] = getpics($data['picture'] , 'all');
		
		$data = M ('restaurant')->where (['status' => '1', 'id' => $id])
			->find ();
		$data['picture'] = getpics ($data['picture'], 'all');
		
		$list = M ('restaurant')->where (['status' => '1', 'id' => array('neq', $id)])
			->order ('sort asc')
			->select ();
		
		foreach ( $list as $k => &$v ) {
			$list[$k]['index_pic'] = getpics ($v['index_pic']);
			$list[$k]['list_pic'] = getpics ($v['list_pic']);
			$list[$k]['picture'] = getpics ($v['picture'], 'all');
			$list[$k]['pics'] = getpics ($v['pics'], 'all');
		}
		
		$this->assign ('data', json_encode ($data, JSON_UNESCAPED_UNICODE));
		$this->assign ('list', json_encode ($list, JSON_UNESCAPED_UNICODE));
		$this->display ();
	}
	
	/**
	 * 新闻列表
	 */
	public function news() {
// 		$list = D ('news')->get_news_list ();
		
// 		$this->assign ('list', json_encode ($list, JSON_UNESCAPED_UNICODE));
// 		if ($this->uid) {
// 			M ('cms_read_log')->add (['uid' => $this->uid, 'create_time' => time ()]);
// 		}
		$this->assign('meta_title', '新闻 | News');
		$this->display ();
	}
	
	/**
	 * 新闻详情
	 */
	public function news_detail() {
// 		$id = I ('id', 0);
// 		$data = D ('news')->get_news_data ($id);
// 		$next = D ('news')->get_news_nextdata ($id);
// 		$next_id = '';
// 		if (!empty ($next)) {
// 			$next_id = $next['next_id'];
// 		}
		
// 		$this->assign ('data', json_encode ($data, JSON_UNESCAPED_UNICODE));
// 		$this->assign ('next_id', $next_id);
// 		$this->assign ('nextdata', json_encode ($next, JSON_UNESCAPED_UNICODE));
		
		$this->display ();
	}
	
	/**
	 * 门店列表
	 */
	public function store() {
		
		$this->display ();
	}
	
	public function logout() {
		cookie ('uid', null);
		cookie ('target_url', null);
		// cookie('openid' , null);
		redirect (U ('login'));
	}

	public function login() {
		cookie ('uid', null);
		cookie ('target_url', null);
		if ($this->uid) {
			// redirect('/index.php/member/personal');
		}
		$type = I ('type', 0);
		$this->assign ('type', $type);
		$this->assign ('refer', I ('refer', ''));
		$this->display ();
	}
}
