<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Cms\Model;

use Think\Model;

/**
 * 幻灯片模型
 */
class SliderModel extends Model {
	/**
	 * 模块名称
	 */
	public $moduleName = 'Cms';
	
	/**
	 * 数据库真实表名
	 * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
	 * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
	 */
	protected $tableName = 'cms_slider';
	
	/**
	 * 自动验证规则
	 */
	protected $_validate = array(array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH), array('title', '1,80', '标题长度为1-80个字符', self::EXISTS_VALIDATE, 'length'));
	
	/**
	 * 自动完成规则
	 */
	protected $_auto = array(array('create_time', 'time', self::MODEL_INSERT, 'function'), array('update_time', 'time', self::MODEL_BOTH, 'function'), array('status', '1', self::MODEL_INSERT));
	
	/**
	 * 查找后置操作
	 */
	protected function _after_find(&$result, $options) {
		if ($result['cover']) {
			$result['cover_url'] = get_cover ($result['cover'], 'default');
		}
	}
	
	/**
	 * 查找后置操作
	 */
	protected function _after_select(&$result, $options) {
		foreach ( $result as &$record ) {
			$this->_after_find ($record, $options);
		}
	}
	
	/**
	 * 获取幻灯列表
	 */
	public function getList($type = 0, $limit = 10, $page = 1, $order = null, $map = null) {
		$con["status"] = 1;
		$con['disp_position'] = $type;
		if ($map) {
			$con = array_merge($con, $map);
		}
		$cur_time = time();
		$con['_string'] = '(UNIX_TIMESTAMP(begin_time) = 0 or UNIX_TIMESTAMP(begin_time) <= ' . $cur_time . ') 
			and (UNIX_TIMESTAMP(end_time) = 0 or UNIX_TIMESTAMP(end_time) >= ' . $cur_time . ')';
		
		if (!$order) {
			$order = 'sort desc, id desc';
		}
		$slider_list = $this->page($page, $limit)
						->order($order)
						->where($con)
						->select();

		return $slider_list;
	}
}
