<?php
namespace app\admin\model;
use think\Db;
use think\Model;
/**
 * 地区model
 * Class User
 */
class City extends Model
{

    protected $name = 'city';
    protected $pk = 'id';

    public function getCitySonlist($pid=0){
        $pid = intval($pid);
        $list = Db::table($this->getTable())
            ->where('pid',$pid)
            ->select();
        return $list;
    }

}