<?php
namespace app\admin\controller;

/**
 * Class SysUser
 * @package app\admin\controller
 */

class Sysuser extends Base
{

    //列表主页
    public function index()
    {
        echo 123;
        echo '这里是管理员管理列表';
        return $this->fetch();
    }

}
