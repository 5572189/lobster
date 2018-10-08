<?php
namespace Addons\AliPay\sdk;
class Autoloader{
  
  /**
     * 类库自动加载，写死路径，确保不加载其他文件。
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class) {
        $filename = str_replace('\\','/',$class).'.php';
        if(is_file($filename)) {
            include $filename;
            return;
        }
    }
}

spl_autoload_register('Addons\AliPay\sdk\Autoloader::autoload');
?>