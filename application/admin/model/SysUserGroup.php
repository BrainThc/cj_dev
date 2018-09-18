<?php
namespace app\admin\model;
use think\Db;
use think\Model;

/**
 * 权限组model
 * Class Powergroup
 */
class SysUserGroup extends Model
{
    protected $name = 'sys_user_group';
    protected $pk = 'group_id';

    const SUPER_STATUS = 2;//超级管理员status值

    /**
     * 过滤菜单power参数
     * @param $menuList         菜单参数集 必须带 power 唯一参数
     * @param array $powerArr   已有power限参数集
     * @param string $where     条件设置
     * @return array            已过滤的power参数集
     */
    public function filterPowerData($menuList,$powerArr=[],$where='change'){
        if( !empty($menuList) ){
            foreach( $menuList as $k => $v ){
                $powerArr[] = $v['power'];
                if( !empty($v['child']) && is_array($v['child']) ){
                    $powerArr = $this->filterPowerData($v['child'],$powerArr);
                }
            }
        }
        return $powerArr;
    }
}