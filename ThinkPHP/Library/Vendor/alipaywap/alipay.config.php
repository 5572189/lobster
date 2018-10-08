<?php
/* *
 * 配置文件
 * 版本：3.5
 * 日期：2016-06-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['partner']		= '2088421745031753';

//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
$alipay_config['seller_id']	= $alipay_config['partner'];

//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$alipay_config['private_key']	= '
MIICXAIBAAKBgQCsootprpqj0hyVKSW3LyXH/7gk2ajgiUIaEHWE7bgERwWC8hVI
vKO4fimwLL2Y7GRzipAlHuF9r8cPZ09ccHIDvt2PwpORlQQ8CKy4dtQumsIbsBD4
uNZkA+uCyYhfXgksugFM2ryDOzdQh+I8YHqusgXBOiD9Pq1Ik6slihbmiQIDAQAB
AoGAHvbswKDz1cx7GfoObMQFJ9FjSyDLXLLh62DmY1hsOEAw6eLYFHrZdt8SRSpR
O5uzDNJetnnKgkvEDaw/HNqCaIPnvpiNrHo5fky5eeE287KXyt2F23ppRHmPPkCC
spJ7Kou/drF2f3q3B5zFXNltkuVo2/iqSwhc0JDp1FOkKLECQQDkcHaOPmDKpzfj
xV8Ga1Awu/lbR8UQgaG43YibpjqIFgk6zpXaLV8WLytg/zu1QwLFegkRTD81P4xv
zCZdkCr9AkEAwXaEdFUUvh/weVHq5p/F4VtGpmTe5FAqkeH31SOmdE2U+9VMrwpA
1+eqw5n9RqjNEgfuvtT3eQtHPe5CBaRdfQJAElk2LJa2D5D+3DyuNUXJWyC+Fqbd
HUZMRx0EK/xeFzAt7ZtKTgv250FCqrfVg+mt/06eC9Wj/hLspM4xBrLdwQJAUF7G
I/X8igeGxT/M0EZr1HUw4othNYRASx6O8NLAoexhCkXQd59Q1OD/RgdA+wvBNc5p
1oluzbBrxkSm1OU1mQJBAJc9zD/agQYIGtJSgMbDD34QMEeYPTGD1JhRMKJaek0H
f7Yd1yrl8MoTosgK6XqX17irRssheGX+xSCuX6Zk/Gc=';


//支付宝的公钥，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['alipay_public_key']= 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['notify_url'] = "http://a.xilukeji.com/lingjian/index.php?s=/Home/AliPay/notify_url";

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['return_url'] = "http://a.xilukeji.com/lingjian/index.php?s=/Home/AliPay/return_url";

//签名方式
$alipay_config['sign_type']    = strtoupper('RSA');

//字符编码格式 目前支持utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';

// 支付类型 ，无需修改
$alipay_config['payment_type'] = "1";
		
// 产品类型，无需修改
$alipay_config['service'] = "alipay.wap.create.direct.pay.by.user";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


?>