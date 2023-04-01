<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('SCHEME',$_SERVER['REQUEST_SCHEME'].'://');
define('DOMAIN','tancj.cn');

//移动端检查方法
function is_mobile_request()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) $mobile_browser++;
    if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) $mobile_browser++;
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) $mobile_browser++;
    if (isset($_SERVER['HTTP_PROFILE'])) $mobile_browser++;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');
    if (in_array($mobile_ua, $mobile_agents)) $mobile_browser++;
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) $mobile_browser++;   // Pre-final check to reset everything if the user is on Windows
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) $mobile_browser = 0;   // But WP7 is also Windows, with a slightly different characteristic
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) $mobile_browser++;
    if ($mobile_browser > 0) return true; else  return false;
}


//域名绑定配置
$domain_config = [];
$domain = [
    'lily'=>'lily',// Lily专属
    'www'=>'admin',//PC端
    'm'=>'wap',//WAP端
    'g'=>'admin',//总后台
    'a'=>'api',//接口,
    'linshi' => 'linshi',//临时使用 可以随时改
    'p'=>'api/upload/index'//资源库 仅限文件上传接口 和 图片读取
];
foreach( $domain as $d => $c ){
    $domain_config[SCHEME.$d.'.'.DOMAIN] = ['model'=>$c];
}
if( SCHEME.$_SERVER['SERVER_NAME'] != SCHEME.'www.zlm-lily.cn' ){
    //PC 端 web端识别跳转
    if( SCHEME.$_SERVER['SERVER_NAME'] == SCHEME.'www.'.DOMAIN && is_mobile_request() ){
        // exit(header('location:'.SCHEME.'m.'.DOMAIN));
    }else if( SCHEME.$_SERVER['SERVER_NAME'] == SCHEME.'m.'.DOMAIN && !is_mobile_request() ){
    }
 }else{
    exit(header('location:'.SCHEME.'lily.'.DOMAIN));//这个是表白设定
 }
//模块绑定
$model = isset($domain_config[SCHEME.$_SERVER['SERVER_NAME']]) ? $domain_config[SCHEME.$_SERVER['SERVER_NAME']]['model'] : 'index';
define('BIND_MODULE',$model);

//跨域配置
$allow_origin_config = [];
foreach( $domain_config as $domain => $config ){
    $allow_origin_config[] = $domain;
}
//配置跨域
if(isset($_SERVER['HTTP_ORIGIN'])){
    if(in_array($_SERVER['HTTP_ORIGIN'], $allow_origin_config)){
        header('Access-Control-Allow-Origin:'.$_SERVER['HTTP_ORIGIN']);
    }else{
        exit;
    }
}
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
