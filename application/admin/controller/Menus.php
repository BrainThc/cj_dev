<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

/**
 * 管理员权限组控制器
 * Class Sysusergroup
 * @package app\admin\controller
 */
class Site extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->siteModel = model('Menus');
    }
}
