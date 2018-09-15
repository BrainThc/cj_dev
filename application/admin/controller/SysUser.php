<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
//use app\admin\model\SysUser;

/**
 * Class SysUser
 * @package app\admin\controller
 */

class SysUser extends Controller
{

    //列表主页
    public function index()
    {
        echo '1232';
        exit;
        return $this->fetch();
    }

}
