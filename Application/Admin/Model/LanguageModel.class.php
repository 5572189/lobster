<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
namespace Admin\Model;

use Think\Model;
class  LanguageModel extends  Model{
	public  $tableName ='language';
	// 自动验证
	protected $_validate = array(
		array('name', 'require', '字段名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('cntitle', 'require', '中文名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('entitle', 'require', '英文名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
	);
}
