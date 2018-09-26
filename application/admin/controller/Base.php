<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    public $arr_limits;
    public $map_power;

    public function _initialize()
    {
        parent::_initialize();
        $this->set_map_power($this->getMenuList());
        $sysUserInfo = session('sys_user');
        $this->sysUserId = $sysUserInfo['sys_user_id'];
        $this->sysUsername = $sysUserInfo['username'];
        $this->group_id = $sysUserInfo['group_id'];
        $this->arr_limits = $sysUserInfo['sys_user_power'];
        $this->is_super = $sysUserInfo['is_super'];
        $this->_act = request()->controller();
        $this->_op = request()->action();
        $this->checkLogin($this->_act,$this->_op);//用户权限检查
        $this->assign('super_user',$this->is_super);//是否超级管理员
        $this->assign('breadCrumb',$this->getBreadCrumb($this->_act,$this->_op,'->'));//菜单面包屑
    }

    public function checkLogin($act,$op){
        $loginModel = model('Login');
        if( empty($this->sysUserId) ){
            $loginModel->signOut();
            $this->redirect('admin/login/index');
        }
        if ( isset($this->map_power[$act][$op]) && in_array($this->map_power[$act][$op],$this->arr_limits) === false ){
            if( $this->map_power[$act][$op] == 'home' ){
                $loginModel->signOut();
                $this->redirect('admin/login/index');
            }
            echo 'You do not have permission';
            exit;
        }
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
            array('name'=>'主页','power'=>'home','act'=>'Index','op'=>'index','child'=>array(
                array('name'=>'系统信息','power'=>'home_show','act'=>'Index','op'=>'show')
            )),
            //系统设置
            array('name'=>'系统设置','power'=>'site','act'=>'Site','child'=>array(
                //站点配置
                array('name'=>'站点配置','power'=>'site_config','act'=>'Site','op'=>'index','child'=>array(
                    array('name'=>'创建配置','power'=>'site_config_create','act'=>'Site','op'=>'create_config'),
                    array('name'=>'编辑配置','power'=>'site_config_update','act'=>'Site','op'=>'update_config')
                )),
                //菜单管理
                array('name'=>'导航管理','power'=>'menus','act'=>'Menus','op'=>'index','child'=>array(
                    array('name'=>'添加导航','power'=>'menus_create','act'=>'Site','op'=>'create_menu'),
                    array('name'=>'编辑导航','power'=>'menus_update','act'=>'Site','op'=>'update_menu'),
                    array('name'=>'删除导航','power'=>'menus_del','act'=>'Site','op'=>'update_menu')
                )),
            )),
            //文章管理
            array('name'=>'文章管理','power'=>'article','act'=>'Article','child'=>array(
                //文章栏目
                array('name'=>'栏目管理','power'=>'article_cate','act'=>'Articlecate','op'=>'index','child'=>array(
                    array('name'=>'添加栏目页','power'=>'article_cate_create_view','act'=>'Articlecate','op'=>'add','child'=>array(
                        array('name'=>'添加栏目','power'=>'article_cate_create','act'=>'Articlecate','op'=>'create_cate')
                    )),
                    array('name'=>'编辑栏目页','power'=>'article_cate_update_view','act'=>'Articlecate','op'=>'edit','child'=>array(
                        array('name'=>'编辑栏目','power'=>'article_cate_update','act'=>'Articlecate','op'=>'update_cate')
                    )),
                )),
                //文章列表
                array('name'=>'文章管理','power'=>'article_list','act'=>'Article','op'=>'index','child'=>array(
                    array('name'=>'添加文章页','power'=>'article_create_view','act'=>'Article','op'=>'add','child'=>array(
                        array('name'=>'添加文章','power'=>'article_create','act'=>'Article','op'=>'create_article')
                    )),
                    array('name'=>'编辑文章页','power'=>'article_create_view','act'=>'Article','op'=>'edit','child'=>array(
                        array('name'=>'编辑栏目','power'=>'article_update','act'=>'Article','op'=>'update_article')
                    )),
                    array('name'=>'文章推荐设置','power'=>'article_recomm','act'=>'Article','op'=>'set_recomm'),
                    array('name'=>'删除/恢复文章','power'=>'article_deleted','act'=>'Article','op'=>'set_deleted'),
                )),
            )),
            //商品管理
            array('name'=>'商品管理','power'=>'goods','act'=>'Goods','child'=>array(
                //商品列表
                array('name'=>'菜单管理','power'=>'goods_list','act'=>'Goods','op'=>'lists')
            )),
            //订单管理
            array('name'=>'订单管理','power'=>'order','act'=>'Order','child'=>array(
                //订单列表
                array('name'=>'订单列表','power'=>'order_list','act'=>'Order','op'=>'lists')
            )),
            //营销管理
            array('name'=>'营销广告','power'=>'market','act'=>'Market','child'=>array(
                //订单列表
                array('name'=>'广告位管理','power'=>'market_banner_pos','act'=>'Advpost','op'=>'index'),
                array('name'=>'广告管理','power'=>'market_banner_content','act'=>'Adv','op'=>'index')
            )),
            //模板配置管理
            array('name'=>'模板管理','power'=>'template','act'=>'Template','child'=>array(
                //各个模板模块
                array('name'=>'PC首页','power'=>'template_pc','act'=>'Template','op'=>'pc'),
                array('name'=>'移动首页','power'=>'template_wap','act'=>'Template','op'=>'wap'),
            )),
            //管理员管理
            array('name'=>'管理员管理','power'=>'sys_user','act'=>'Sysuser','child'=>array(
                //管理员列表
                array('name'=>'管理员列表','power'=>'sys_user_list','act'=>'Sysuser','op'=>'index','child'=>array(
                    array('name'=>'添加管理员','power'=>'sys_user_list_create','act'=>'Sysuser','op'=>'create_user'),
                    array('name'=>'编辑管理员','power'=>'sys_user_list_update','act'=>'Sysuser','op'=>'update_user'),
                    array('name'=>'删除管理员','power'=>'sys_user_list_del','act'=>'Sysuser','op'=>'disable_user')
                )),
                //权限组管理
                array('name'=>'权限组管理','power'=>'sys_user_group','act'=>'Sysusergroup','op'=>'index','child'=>array(
                    array('name'=>'添加权限组信息','power'=>'sys_user_group_create','act'=>'Sysuser','op'=>'create_group'),
                    array('name'=>'编辑权限组信息','power'=>'sys_user_group_update','act'=>'Sysuser','op'=>'update_group'),
                    array('name'=>'更改权限配置','power'=>'sys_user_group_power_update','act'=>'Sysuser','op'=>'update_power'),
                    array('name'=>'禁用权限组','power'=>'sys_user_group_update','act'=>'Sysuser','op'=>'disable_group'),
                    array('name'=>'超级管理员初始化','power'=>'sys_user_group_default','act'=>'Sysuser','op'=>'default_super_group'),
                ))
            )),
            //日志
            array('name'=>'日志','power'=>'log','act'=>'Log','child'=>array(
                //操作日志
                array('name'=>'管理员操作日志','power'=>'sys_user_log','act'=>'Log','op'=>'index')
            ))
        );
        return $menusList;
    }

    /**
     * 顶部导航
     * @param $op           栏目主控制器
     * @return string       html内容
     */
    public function getMenuTop($act=''){
        if( empty($this->arr_limits) ){
            $loginModel = model('Login');
            $loginModel->signOut();
            $this->error('您没有权限操作后台，正在返回~~~',\think\Url::build('admin/index/index'),'',1);
            exit;
        }
        $menulist = $this->getMenuList();
        $menuHtml = '';
        if( !empty($menulist) ){
            foreach( $menulist as $key => $value ){
                if( !empty($value['child']) && in_array($value['power'],$this->arr_limits) === true ){
                    $is_act = ($act == $value['act']) ? 'current' : '';
                    $menuHtml .= '<li id="menu_'.($key+1).'"><span class="'.$is_act.'"><a href="javascript:void(0);" onClick="menuAction('.($key+1).',\''.$value['act'].'\');">'.$value['name'].'</a></span></li>';
                }
            }
        }
        return $menuHtml;
    }

    /**
     * 侧边导航
     * @param string $act        控制器
     * @param string $op       方法
     * @param bool $breadCrumb  是否获取面包屑
     * @return string           html内容
     */
    public function getMenuLeft($act='',$op=''){
        $menulist = $this->getMenuList();
        $menuHtml = '';
        if( !empty($menulist) ){
            foreach( $menulist as $key => $value ){
                if( $act == $value['act'] ){
                    $menuHtml .= '<dt>'.$value['name'].'</dt>';
                    if( !empty($value['child']) ){
                        foreach( $value['child'] as $k => $v ){
                            if( in_array($v['power'],$this->arr_limits) ){
                                $is_act = ( $op == $v['op'] && $act == $v['act'] ) ? 'on' : '';
                                $menuHtml .= '<dd id="nav_'.($k+1).'" class="'.$is_act.'"><span op="'.$v['act'].'" act="'.$v['op'].'" onclick="menuLeftAction('.($k+1).',\''.url($v['act'].'/'.$v['op']).'\')"><a href="'.url($v['act'].'/'.$v['op']).'" target="main" >'.$v['name'].'</a></span></dd>';
                            }
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
     * @param string $act        控制器
     * @param string $op       方法类
     * @return string           html内容
     */
    public function getBreadCrumb($act='',$op='',$separator=''){
        $breakDesc = [];
        $menuList = $this->getMenuList();
        if( !empty($menuList) ){
            foreach( $menuList as $key => $top ){
                if( $top['act'] == $act ){
                    $breakDesc[] = $top['name'];
                    if( !empty($top['child']) ){
                        foreach( $top['child'] as $k => $left ){
                            if( $op == $left['op'] ){
                                $breakDesc[] = $left['name'];
                                break;
                            }else if( !empty($left['child']) ){
                                foreach( $left['child'] as $kc => $contAct ){
                                    if( $contAct['op'] == $op ){
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

    /**
     * 配置权限地图
     * @param $menuList
     */
    private function set_map_power($menuList){
        foreach ($menuList as $value) {
            if (isset($value['act']) && isset($value['op']) && isset($value['power'])) {
                $this->map_power[$value['act']][$value['op']] = $value['power'];
            }
            if (isset($value['child']) && !empty($value['child'])) {
                $this->set_map_power($value['child']);
            }
        }
    }

    /**
     * 页面校验码
     * @param string $name      校验码名 session
     * @return string           检验码串
     */
    public function setViewCode($name='viewCode'){
        $code = str_shuffle(md5(rand(1111,9999)));
        session($name,$code);
        return $code;
    }

    /**
     * 检查页面校验码
     * @param string $name      校验码名 session
     * @param string $code      提交的校验码
     * @return bool             true or false
     */
    public function checkViewCode($name='viewCode',$code=''){
        $viewCode = session($name);
        if( empty($viewCode) || empty($code) )
            return false;

        if( $viewCode == $code ){
            session($name,null);
            return true;
        }
        return false;
    }

}
