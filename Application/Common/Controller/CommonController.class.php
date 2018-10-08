<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Common\Controller;
use Think\Controller;
/**
 * 公共控制器
 *
 */
class CommonController extends Controller {
	/**
	 * 模板显示 调用内置的模板引擎显示方法，
	 * @access protected
	 * @param string $templateFile 指定要调用的模板文件
	 * 默认为空 由系统自动定位模板文件
	 * @param string $charset 输出编码
	 * @param string $contentType 输出类型
	 * @param string $content 输出内容
	 * @param string $prefix 模板缓存前缀
	 * @return void
	 */
	protected function display($template = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
		$depr     = C('TMPL_FILE_DEPR');
		$template = str_replace(':', $depr, $template);
		if ('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = CONTROLLER_NAME . $depr . ACTION_NAME;
		} elseif (false === strpos($template, $depr)) {
			$template = CONTROLLER_NAME . $depr . $template;
		}

		// 后台模板路径在View文件夹下自动加一层Admin
		if (!(is_file($template)) && MODULE_NAME !== 'Admin' && MODULE_MARK === 'Admin') {
			$template = 'Admin/' . $template;
		}
		elseif (in_array(cookie('lang'), ['en'])&& MODULE_NAME != 'Admin' && MODULE_MARK != 'Admin'&&!in_array(CONTROLLER_NAME, ['Director','Service','Recommend','Restaurant'])) {//排除后台模板和商户登陆管理模板
			//if(file_exists($template."_en")){
			if (!in_array($template, ['./Application/Home/View/Public/mobile_jump.html'])) {
				$template .= "_en";
			}
		}
		$this->view->display($template, $charset, $contentType, $content, $prefix);
	}
}
