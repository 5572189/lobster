<?php

require dirname(__FILE__) . '/../../include/config.inc.php';
/*
 *  Copyright (c) 2014 The CCP project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a Beijing Speedtong Information Technology Co.,Ltd license
 *  that can be found in the LICENSE file in the root of the web site.
 *
 *   http://www.yuntongxun.com
 *
 *  An additional intellectual property rights grant can be found
 *  in the file PATENTS.  All contributing project authors may
 *  be found in the AUTHORS file in the root of the source tree.
 */
$code   = !empty($_COOKIE['codenum']) ? AuthCode($_COOKIE['codenum']) : '';
$mobile = !empty($_COOKIE['mobile']) ? AuthCode($_COOKIE['mobile']) : '';

if ($code == $codenum && $mobile == $username) {
    echo 1;
} else {
    echo 0;
}
