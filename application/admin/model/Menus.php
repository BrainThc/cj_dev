<?php
namespace app\admin\model;
use think\Db;
use think\Model;
/**
 * 菜单model
 * Class User
 */
class Menus extends Model{

    protected $name = 'menus';
    protected $pk = 'id';

    /**
     * 配置树状结构
     * @param $menulist
     * @param $type
     */
    public function getMenuTree($menuSt,$type){
        if( !empty($menuSt) ){
            foreach( $menuSt as $key => $list ){
                $where['pid'] = ['=',$list['id']];
                if( $type > 0 ){
                    $where['menus_type'] = ['=',$type];
                }
                $nav_son = Db::table($this->getTable())
                    ->where($where)
                    ->order('sequence','desc')
                    ->select();
                if( !empty($nav_son) ){
                    $nav_son = $this->getMenuTree($nav_son,$type);
                }
                $menuSt[$key]['child'] = $nav_son;
            }
        }
        return $menuSt;
    }
}

?>