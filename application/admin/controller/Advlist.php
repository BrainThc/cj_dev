<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

/**
 * 广告位控制器
 * Class Sysusergroup
 * @package app\admin\controller
 */
class Advlist extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        $this->advListModel = model('AdvList');
    }

    public function index(){
        return $this->fetch();
    }

}