<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Admin\Model;

use Think\Model;
use Common\Util\Tree;

/**
 * 快捷链接模型
 */
class LinkModel extends Model {
	/**
	 * 数据库表名
	 */
	protected $tableName = 'admin_link';
	
	/**
	 * 自动验证规则
	 */
	protected $_validate = array(array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH), 
		array('url', '0,255', '链接长度为0-25个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH));
	
	/**
	 * 自动完成规则
	 */
	protected $_auto = array(array('create_time', 'time', self::MODEL_INSERT, 'function'), array('update_time', 'time', self::MODEL_BOTH, 'function'), array('sort', '0', self::MODEL_INSERT), 
		array('status', '1', self::MODEL_INSERT));
	
	/**
	 * 获取所有快捷链接
	 * 
	 * @param string $addon_dir        	
	 *
	 */
	public function getAll() {
		$con = array();
		$con['status'] = 1;
		$link_list = $this->where ($con)
			->order ('sort asc, id asc')
			->select ();
		foreach ( $link_list as $key => &$value ) {
			if (!stristr ($value['url'], 'http://') && !stristr ($value['url'], 'https://')) {
				$value['url'] = U ($value['url']);
			}
		}
		$tree = new Tree ();
		$link_list = $tree->list_to_tree ($link_list);
		return $link_list;
	}
}
