<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Cms\Admin;

use Admin\Controller\AdminController;
use Common\Util\Think\Page;

/**
 * 幻灯片控制器
 */
class SliderAdmin extends AdminController {
	public $disp_position = [];// [0 => '首页', 1 => '关于', 2 => '新闻'];
	public $arr_banner_type = [];
	// 1=>'商品列表',2=>'商品详情', 3=> 'H5嵌套页面' , 4 => '团购' , 5 => '储值' , 6 => '优惠券'
	public $platform_type = [];
	// [1 => '微信/pc', 2 => 'ios/android', 3 => '微信/pc/ios/android']
	/**
	 * 默认方法
	 */
	public function index() {
		// 搜索
		$keyword = I ('keyword', '', 'string');
		$condition = array('like', '%' . $keyword . '%');
		$map['id|title'] = array($condition, $condition, '_multi' => true);
		
		$type = I ('type', 'weixin');
		
		// 获取所有分类
		$p = !empty ($_GET["p"]) ? $_GET["p"] : 1;
		$map['status'] = array('egt', '0'); // 禁用和正常状态
		
		if (I ('disp_position', 0) != -1) {
			$map['disp_position'] = I ('disp_position', 0);
		}
		
		$slider_object = D ('Slider');
		$data_list = $slider_object->page ($p, C ('ADMIN_PAGE_ROWS'))
			->where ($map)
			->order ('status desc,sort desc,id desc')
			->select ();
		$page = new Page ($slider_object->where ($map)
			->count (), C ('ADMIN_PAGE_ROWS'));
		// 使用Builder快速建立列表页面。
		$builder = new \Common\Builder\ListBuilder ();
		$builder->setMetaTitle ('幻灯列表')
			->addTopButton ('addnew')
			->addTopButton ('resume')
			->addTopButton ('forbid');
		if ($this->disp_position && count ($this->disp_position, COUNT_NORMAL) > 0) {
			$builder->addSearchItem ('disp_position', 'select', '展示位置', '', $this->disp_position);
		}
		$builder->addTableColumn ('id', 'ID')
			->addTableColumn ('title', '标题')
			->addTableColumn ('cover', '图片', 'picture')
			->addTableColumn ('create_time', '创建时间', 'time')
			->addTableColumn ('begin_time', '开始时间')
			->addTableColumn ('end_time', '结束时间')
			->addTableColumn ('sort', '排序')
			->addTableColumn ('status', '状态', 'status')
			->addTableColumn ('right_button', '操作', 'btn')
			->setTableDataList ($data_list)
			->setTableDataPage ($page->show ())
			->addRightButton ('edit')
			->addRightButton ('forbid')
			->addRightButton ('delete')
			->display ();
	}
	
	/**
	 * 新增文档
	 */
	public function add() {
		$slider_object = D ('Slider');
		$banner_limit = C ('shoppingmall_config.banner_limit');
		if (IS_POST) {
			$saveData = I ('post.');
			if ($saveData['disp_position'] == -1) {
				$this->error ('请选择广告展示位置');
			}
			// $saveData['disp_position'] = 0;
			$data = $slider_object->create ($saveData);
			if ($data) {
				$id = $slider_object->add ();
				if ($id) {
					$this->success ('新增成功', U ('index', ['disp_position' => $saveData['disp_position']]));
				} else {
					$this->error ('新增失败');
				}
			} else {
				$this->error ($slider_object->getError ());
			}
		} else {
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('新增幻灯')
				->setPostUrl (U ('add'));
			if ($this->disp_position && count ($this->disp_position, COUNT_NORMAL) > 0) {
				$builder->addFormItem ('disp_position', 'select', '广告展示位置', '默认为首页广告', $this->disp_position);
			}
			$builder->addFormItem ('title', 'text', '标题', '标题')
				->addFormItem ('begin_time', 'datetime', '开始时间', '开始时间')
				->addFormItem ('end_time', 'datetime', '结束时间', '结束时间');
			
			$this->generateLocalizedField ($builder, 'cover', 'picture', '图片', '请上传图片,请上传分类图片,图片尺寸建议:620*480');
			
			if ($this->platform_type && count ($this->platform_type, COUNT_NORMAL) > 0) {
				$builder->addFormItem ('platform', 'radio', '播放平台', '', $this->platform_type);
			}
			
			if ($this->arr_banner_type && count ($this->arr_banner_type, COUNT_NORMAL) > 0) {
				$builder->addFormItem ('jump_page', 'radio', '跳转页面', '', $this->arr_banner_type);
			}
			
			$builder->addFormItem ('url', 'text', '链接', '点击跳转链接')
				->addFormItem ('sort', 'num', '排序', '用于显示的顺序')
				->display ();
		}
	}
	
	/**
	 * 编辑文章
	 */
	public function edit($id) {
		if (IS_POST) {
			$slider_object = D ('Slider');
			$saveData = I ('post.');
			// $saveData['disp_position'] = 0;
			$data = $slider_object->create ($saveData);
			if ($data) {
				// $data['disp_position'] = 0;
				$id = $slider_object->save ();
				if ($id !== false) {
					$this->success ('更新成功', U ('index', ['disp_position' => $saveData['disp_position']]));
				} else {
					$this->error ('更新失败');
				}
			} else {
				$this->error ($slider_object->getError ());
			}
		} else {
			// 使用FormBuilder快速建立表单页面。
			$builder = new \Common\Builder\FormBuilder ();
			$builder->setMetaTitle ('编辑幻灯')
				->setPostUrl (U ('edit'))
				->addFormItem ('id', 'hidden', 'ID', 'ID');
			if ($this->disp_position && count ($this->disp_position, COUNT_NORMAL) > 0) {
				$builder->addFormItem ('disp_position', 'select', '广告展示位置', '默认为首页广告', $this->disp_position);
			}
			$builder->addFormItem ('title', 'text', '标题', '标题')
				->addFormItem ('begin_time', 'datetime', '开始时间', '开始时间')
				->addFormItem ('end_time', 'datetime', '结束时间', '结束时间');
			
			$this->generateLocalizedField ($builder, 'cover', 'picture', '图片', '图片宽高750*570时可获得最佳显示效果');
			
			if ($this->platform_type && count ($this->platform_type, COUNT_NORMAL) > 0) {
				$builder->addFormItem ('platform', 'radio', '播放平台', '', $this->platform_type);
			}
			if ($this->arr_banner_type && count ($this->arr_banner_type, COUNT_NORMAL) > 0) {
				$builder->addFormItem ('jump_page', 'radio', '跳转页面', '', $this->arr_banner_type);
			}
			$builder->addFormItem ('url', 'text', '链接', '点击跳转链接')
				->addFormItem ('sort', 'num', '排序', '用于显示的顺序')
				->setFormData (D ('Slider')->find ($id))
				->display ();
		}
	}
}
