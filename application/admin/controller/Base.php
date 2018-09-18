<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    public $arr_limits;
    public $map_power;

    public function __construct()
    {
        parent::__construct();
        $this->sysUserId = session('sys_user_id');
        $this->sysUsername = session('user_name');
        $this->group_id = session('group_id');
        if( empty($this->sysUserId) && empty($this->sysUsername) && empty($this->group_id) ){
            $this->redirect('admin/login/index');
        }
        $this->_op = request()->controller();
        $this->_cat = request()->action();
        //菜单面包屑
        $this->assign('breadCrumb',$this->getBreadCrumb($this->_op,$this->_cat,'->'));
    }

    /**
     * 后台菜单配置方法
     * @return array
     * @action
     * op 网站控制器参数
     * act 控制器方法参数
     * power 必须是唯一值不可重复 命名规范下划线相隔 例如 sys_user_list 用于用户权限处理
     * child 子级目录 最多三级 多余三级的部分只作为接口功能权限使用
     */
    public function getMenuList(){
        $menusList = array(
            //主页
            array('name'=>'主页','power'=>'home','op'=>'Index','child'=>array(
                array('name'=>'系统信息','power'=>'home','op'=>'Index','act'=>'show')
            )),
            //站点配置
            array('name'=>'站点配置','power'=>'site','op'=>'Site','child'=>array()),
            //管理员管理
            array('name'=>'管理员管理','power'=>'sys_user','op'=>'Sysuser','child'=>array(
                array('name'=>'管理员列表','power'=>'sys_user_list','op'=>'Sysuser','act'=>'index','child'=>array(
                    array('name'=>'添加管理员','power'=>'sys_user_list_add','op'=>'Sysuser','act'=>'add')
                )),
                array('name'=>'权限组管理','power'=>'user_group','op'=>'Sysusergroup','act'=>'index')
            )),
            //日志
            array('name'=>'日志','power'=>'log','op'=>'Log','child'=>array(
                array('name'=>'管理员操作日志','power'=>'sys_user_log','op'=>'Log','act'=>'index')
            ))
        );
        return $menusList;
    }

    /**
     * 顶部导航
     * @param $op           栏目主控制器
     * @return string       html内容
     */
    public function getMenuTop($op=''){
        $menulist = $this->getMenuList();
        $menuHtml = '';
        if( !empty($menulist) ){
            foreach( $menulist as $key => $value ){
                if( !empty($value['child']) ){
                    $is_act = $op == $value['op'] ? 'current' : '';
                    $menuHtml .= '<li id="menu_'.($key+1).'"><span class="'.$is_act.'"><a href="javascript:void(0);" onClick="menuAction('.($key+1).',\''.$value['op'].'\');">'.$value['name'].'</a></span></li>';
                }
            }
        }
        return $menuHtml;
    }

    /**
     * 侧边导航
     * @param string $op        控制器
     * @param string $act       方法
     * @param bool $breadCrumb  是否获取面包屑
     * @return string           html内容
     */
    public function getMenuLeft($op='',$act=''){
        $menulist = $this->getMenuList();
        $menuHtml = '';
        if( !empty($menulist) ){
            foreach( $menulist as $key => $value ){
                if( $op == $value['op'] ){
                    $breadCrumb = $value['name'];
                    $menuHtml .= '<dt>'.$value['name'].'</dt>';
                    if( !empty($value['child']) ){
                        foreach( $value['child'] as $k => $v ){
                            $is_act = ( $act == $v['act'] ) ? 'on' : '';
                            $menuHtml .= '<dd id="nav_'.($k+1).'" class="'.$is_act.'"><span op="'.$v['op'].'" act="'.$v['act'].'" onclick="menuLeftAction('.($k+1).',\''.url($v['op'].'/'.$v['act']).'\')"><a href="'.url($v['op'].'/'.$v['act']).'" target="main" >'.$v['name'].'</a></span></dd>';
                        }
                    }
                    break;
                }
            }
        }
        return $menuHtml;
    }

    /**
     * 获取面包屑
     * @param string $op        控制器
     * @param string $act       方法类
     * @return string           html内容
     */
    public function getBreadCrumb($op='',$act='',$separator=''){
        $breakDesc = [];
        $menuList = $this->getMenuList();
        if( !empty($menuList) ){
            foreach( $menuList as $key => $top ){
                if( $top['op'] == $op ){
                    $breakDesc[] = $top['name'];
                    if( !empty($top['child']) ){
                        foreach( $top['child'] as $k => $left ){
                            if( $act == $left['act'] ){
                                $breakDesc[] = $left['name'];
                                break;
                            }else if( !empty($left['child']) ){
                                foreach( $left['child'] as $kc => $contAct ){
                                    if( $contAct['act'] == $act ){
                                        $breakDesc[] = $left['name'];
                                        $breakDesc[] = $contAct['name'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    break;
                }
            }
        }
        if( $separator != '' ){
            return implode($separator,$breakDesc);
        }
        return $breakDesc;
    }

}
