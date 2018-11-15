<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

class Goods extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->goodsModel = model('Goods');
    }

    //列表主页
    public function index(){
        return $this->fetch();
    }

    public function get_goods_list(){
        $where = [];
        $page_param = [];
        $page = intval(input('page',1));;
        $list = Db::table($this->goodsModel->getTable())->where($where)->paginate(15,false,['page'=>$page,'path'=>url('admin/goods/index',$page_param)]);
        if( !empty($list) ){
            foreach( $list as $key => $value ){
                $value['oldSequence'] = $value['sequence'];
                $list[$key] = $value;
            }
        }
        $info['list'] = $list;
        $pageHtml = $list->render();
        $info['page'] = empty($pageHtml) ? '' : $pageHtml;
        returnJson(true,'success',$info);
    }

    public function get_goods_cate(){
        $cateModel = model('GoodsCategory');
        $where = [];
        $pid = intval(input('post.pid',0));
        $where['pid'] = $pid;
        $cate_list = Db::table($cateModel->getTable())->where($where)->select();
        $info['cate_list'] = $cate_list;
        returnJson(true,'success',$info);
    }

    //添加页面
    public function add(){
        return $this->fetch();
    }

    //获取分类属性选项卡
    public function get_cate_prop_tab(){
        $ids = intval(input('post.cate_id',0));
        if( $ids <= 0 ){
            returnJson(true,'success',[]);
        }
        $cateModel = model('GoodsCategory');
        $catePropModel = model('GoodsCateProp');
        $cate_all = $cateModel->getParentCate($ids);
        $prop_list = $catePropModel->get_prop_list($cate_all,true);
        if( !empty($prop_list) ){
            foreach( $prop_list as $kprop => $prop ){
                $prop['changed'] = false;
                foreach( $prop['child'] as $ckey => $val ){
                    $val['changed'] = false;
                    $prop['child'][$ckey] = $val;
                }
                $prop_list[$kprop] = $prop;
            }
        }
        $info = $prop_list;
        returnJson(true,'success',$info);
    }

    //添加商品
    public function create_goods(){
        $data = input('post.');
        try{
            if( empty($data['goods_name']) ){
                throw new Exception('商品名不能为空');
            }
            $data['goods_cate'] = input('post.goods_cate');
            if( isset($data['goods_cate']) && intval($data['goods_cate']) ){
                throw new Exception('商品名不能为空');
            }
        }catch( Exception $e ){
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //添加提交
    public function create(){
        returnJson(false);
    }

}