<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace User\Model;

use Think\Model;
// TODO:合并Common/Util/Member.class.php的内容
/**
 * 用户模型
 */
class UserModel extends Model {
	
	/**
	 * 数据库表名
	 */
	protected $tableName = 'admin_user';
	
	/**
	 * 自动验证规则
	 */
	protected $_validate = array ();
	protected function _after_select(&$result, $options) {
	}
	protected function _before_update(&$data, $options) {
	}
	/**
	 * 自动完成规则
	 */
	protected $_auto = array ();
	
	public function getimg($avatar) {
		if ($avatar) {
			$src = "<img src='$avatar' width='50'/>";
		} else {
			$src = '';
		}
		return $src;
	}
	
}
