<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        $this->assign('homeMenu',$this->getMenu());//后台一级导航栏
//        $this->assign('homeMenuTop',$this->getMenuTop($this->_op));//后台一级导航栏
//        $this->assign('homeMenuLeft',$this->getMenuLeft($this->_act,$this->_op));//后台左侧导航栏
        return $this->fetch();
    }

    //异步获取侧边导航html
    public function get_menu_left_html(){
        $_act = input('act');
        returnJson(true,'侧边导航',$this->getMenuLeft($_act));
    }

}
