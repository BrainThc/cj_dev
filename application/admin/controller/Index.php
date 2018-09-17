<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        $this->assign('homeMenuTop',$this->getMenuTop($this->_op));//后台一级导航栏
        $this->assign('homeMenuLeft',$this->getMenuLeft($this->_op,$this->_cat));//后台左侧导航栏
        return $this->fetch();
    }

    //异步获取侧边导航html
    public function getMenuLeftHtml(){
        $_op = input('op');
        retrunJosn(true,'侧边导航',$this->getMenuLeft($_op));
    }

    public function show(){
        echo '这里是首页信息展示页<br />';
        return $this->fetch();
    }

}
