<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Request;

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
    }

    public function getMenuList(){
        $menusList = array(
            //主页
            array('name'=>'主页','power'=>'home','op'=>'Index','child'=>array(
                array('name'=>'主页','power'=>'home','op'=>'Index','act'=>'show')
            )),
            //站点配置
            array('name'=>'站点配置','power'=>'site','op'=>'Site','child'=>array()),
            //管理员管理
            array('name'=>'管理员管理','power'=>'sysuser','op'=>'Sysuser','child'=>array(
                array('name'=>'管理员列表','power'=>'sysuserlist','op'=>'Sysuser','act'=>'index'),
                array('name'=>'权限组管理','power'=>'usergroup','op'=>'Usergroup','act'=>'index')
            )),
            //日志
            array('name'=>'日志','power'=>'log','op'=>'Log','child'=>array(
                array('name'=>'管理员操作日志','power'=>'usergroup','op'=>'Log','act'=>'index')
            ))
        );
        return $menusList;
    }

    /**
     * 顶部导航
     * @param $cont
     * @param $action
     * @return string
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

    public function getMenuLeft($op='',$act=''){
        $menulist = $this->getMenuList();
        $menuHtml = '';
        if( !empty($menulist) ){
            foreach( $menulist as $key => $value ){
                if( $op == $value['op'] ){
                    $menuHtml .= '<dt>'.$value['name'].'</dt>';
                    if( !empty($value['child']) ){
                        foreach( $value['child'] as $k => $v ){
                            $is_act = $v['act'] == $act ? 'on' : '';
                            $menuHtml .= '<dd id="nav_'.($k+1).'" class="'.$is_act.'"><span op="'.$v['op'].'" act="'.$v['act'].'" onclick="menuLeftAction('.($k+1).',\''.url($v['op'].'/'.$v['act']).'\')"><a href="'.url($v['op'].'/'.$v['act']).'" target="main" >'.$v['name'].'</a></span></dd>';
                        }
                    }
                }
            }
        }
        return $menuHtml;
    }

}
