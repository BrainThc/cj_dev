<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        $_op = request()->controller();
        $_cat = request()->action();
        $this->assign('homeMenuTop',$this->getMenuTop($_op));//后台一级导航栏
        $this->assign('homeMenuLeft',$this->getMenuLeft($_op,$_cat));//后台左侧导航栏
        return $this->fetch();
    }

    //异步获取侧边导航html
    public function getMenuLeftHtml(){
        $_op = input('op');
        exitJosn(true,'侧边导航',$this->getMenuLeft($_op));
    }

    public function show(){
        exitJosn(false,'奥术大师');
        echo '这里是后台首页信息展示';
    }

}
