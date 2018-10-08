<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
return [
	'AlIPAY' => [
		'PRIVATE_KEY' => 'MIIEpAIBAAKCAQEA4lgbhYaRITo+g5DZpki+QFWHlFbHdYi8cj/L0DWBqi6OD2/YrpsEC6jwJLyDwgsK0wdQDuM/QidxiSZtx+9PcfeHLofCgqsLKpDyLOZz6SDmuw4wXq30nGbJpy/kEFAuZNCuhcezkujpc2HRQteYivifaIpH4hkjaUxle6Y98K7PNuvMe982/9Peim30M2B361tSGkUvBRB0kjqFUuP7RvzM7lNyL5EmCXFmbf0Md//UtD0pqDfoTNHK7y7uMcwL1mPbfRQKPC384WoDiKkcMhvXrZm9HbGrWy68VP09IEkuzw9tt1sQbUNxUqzpnEvM973S15ffq+c77/A+Wte9kQIDAQABAoIBAHGM3hG4lqpiu+XpDyeaqsc/oUrL1jiipldypd8IWMp1nJMl+0BtSDRJRmBHqpn4TC/eJU2yt5OKkizJ+J0q82IrWcgAF5bSFEIAgV4BJvk3pkkFL0LwZhzofBXBstp0PzIYdtVqgC4dZrCZzA+KdV6Sp/YcGT/WeKtkxiyoE77gIggce9EYdz071fnY3PEaaJE+WrV5xoyTYS4MYHKefi9x3q2O9uypss6/oAttZS3O2N7k050chC8N/FQXzoRInj4r3247GxOwbl3GC6qy9Lghqah0jfjO8VLCMqJlE4fTUeMkKSyR0XPEajhacs58AE6zqYzOK5DBjUbfwjmeR4ECgYEA/MvFiY7vaU7jkBPoDwnoeQ15wssa3xeSVtXydnoUqE6c9u/Pe4MjvO4fFYxygOyPGcmK9YYn8hkgmt7nZUcbHTWcOj/pUFsrGbljfijB5kgNcS+AMGjiAGX9zVOd9hKHp9iuOqe6Yu7ceAHFayYjkQGBQEkiPK3D14tdXNnz9AkCgYEA5TaCd9RQZgKj8arnM/XRrnOu+t8RrQzDYrIpo/6k7ctyVdnIPwb+VZ8sJBnrN0F4PxmefBBe58T0A94aYn+GwdG1Wb5ml9Cx5KZVJuuV7O6Zuy0WvkN/N9S5ypt3bnIZl9rwrx+NAlpOQpRoJZSsZM27cQZXLG4s4C1YRawNr0kCgYBb2prjObmKNS0AnAsU88+xtJDKk8wmxcTZopGgNQmugioMm+RzB5qDuq42wTqV197DSvUf82guUq0DOP0xUp3qhiFHFRPsq8PEbBVXsO2LhCDGQLE+Zc3AwU5wPfLGh8Mc3OGp1GooKoyXWmVmYoxH0xkox6oWDDl951i8NUGsKQKBgQCNdjHZQLiJ7LE/0kk04U6SiyUAAbIICit/+xMF+n/RntEmuO0EMQ3AzCbS9QgdJxPOZcJRMU1RX1V2GZpRFgGWFxYEmCT7JzrTMfC1v4ndG3jXc0FpFYErdOdhasev601uUhpfCmrde9x27N7F6tbms64uWEpuymR5yqKDBWfAuQKBgQDmgSZLlOyoX+QmwgTpVfGG3I/Iv8cvJFu8nwdcsUcyoUA9Bde1jpnon+FKOJfPpDwwfn5P3IptJgXnAwv8sXfKw8a3+TNDRKI170m83o9fA6Wi+2qkpQpoD/S9jRWVl6Gedg+ow8/yE+GP8XKHDfX8BNaq19ibOU+0cSDLkaXD/Q==' ,
		'ALIPAY_PUBLIC_KEY' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyEZrdGusDLueuoIwdCFddjOvHOG36sE+FrpsoPa3g7q1VU9O8YTNC7gww4ro1eQqRIqnhEzoyERA9Lfn88nbIQH8OyGr33V+LofmzTyCD3WXJsS/GFxxfiSXs9NkcRnFt4zNWdLdV2DipF/lLgVoWcvDhOMzW6OhfUsTyUcRUGfZ+abin5/54EbQsnAVnvU6zLpDTPrdmgfzYbX2ZJvwkkEo+RY9l/6lTT2cgKh7GF4/FpbKwD4vhCbzvV/sDdsnnw1162Q/IkgiOIin/54Ycoe4D21KfSnfhvAzr6qT71yn7DAOtJQ5jmLyeYn+SiXIu1dUv4QCdBuRkL9W2YQZaQIDAQAB' , 
		'APP_ID' => '2017041206667402' ,
		'METHOD' => 'alipay.trade.app.pay' ,
		'NOTIFY_URL' => 'http://ns.idea580.com/index.php/addon/execute/_addons/ali_pay/_controller/ali_pay/_action/pay.html' ,
		'SIGN_TYPE' => 'RSA2' ,
		'CHAR_SET' => 'utf-8' ,
		'VERSION' => '1.0'
	] ,
	'WECHAT' => [
		'APP_ID' => 'wxac79a6c4e195b025',
		'MERCHANT_Id' => '1489076132' ,
		'KEY' => '13621913488noblespiritsandroid66' ,
		'NOTIFY_URL' => 'http://ns.idea580.com/index.php/Home/Weixin/wxAppOrderNotify' 
	]
] ; 