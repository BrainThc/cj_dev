<?php
namespace app\wap\controller;
// 引入Db类
use think\Db;
// 引入控制器类
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        echo '这里是移动端<br />';
        return $this->fetch();
    }
}
