<?php
namespace app\Admin\controller;
// 引入Db类
use think\Db;
// 引入控制器类
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
