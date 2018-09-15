<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//不要随意改动
define('__COMPANYKEY__','yiguankeji');//公司用户配置秘钥key
define('__HOME__',$_SERVER['SERVER_NAME'].'/');//全局定量
//公共函数
/**
 * 打印查看对象
 * @param null $obj         对象
 * @param bool $seeType     是否显示变量类型
 */
 function p($obj=NULL,$seeType=false){
     if( empty($obj) )
         var_dump(NULL);

     echo '<pre>';
     if($seeType){
         var_dump($obj);
     }else{
         print_r($obj);
     }
     echo '</pre>';
}

