<?php
namespace app\admin\model;
use think\Db;
use think\Model;

/**
 * 权限组model
 * Class Powergroup
 */
class PowerGroupModel extends Model
{
    protected $table = 'sys_user_group';

    public function getAll($whereData=[],$page=1,$size=16){
        if( !empty($whereData) ) {
            foreach ($whereData as $key => $value) {
                DB::where($whereData, $value);
            }
        }
       $list = DB::name($this->getTable())->limit(($page-1),$size)->select();
        return $list;
    }
}