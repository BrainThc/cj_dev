<?php
namespace app\common\model;
use think\Db;
use think\Model;
/**
 * 商品分类model
 * Class User
 */
class GoodsCategory extends Model
{

    protected $name = 'goods_category';
    protected $pk = 'cate_id';

    public function getCateSonlist($pid=0){
        $pid = intval($pid);
        $list = Db::table($this->getTable())
            ->where('pid',$pid)
            ->order('sequence','desc')
            ->select();
        return $list;
    }

    /**
     * 配置分类树状
     * @param $cate_list        最高级分类列表
     * @return mixed            返回已处理的列表
     */
    public function getCateTree($cate_list){
        if( !empty($cate_list) ){
            foreach( $cate_list as $key => $cate){
                $cate_son = Db::table($this->getTable())
                    ->where('pid',$cate['cate_id'])
                    ->order('sequence','desc')
                    ->select();
                if( !empty($cate_son) ){
                    $cate_son = $this->getCateTree($cate_son);
                }
                $cate_list[$key]['child'] = $cate_son;
            }
        }
        return $cate_list;
    }

    /**
     * 获取所有上级cate_id
     * @param $cate_id          分类索引id
     * @param $m                返回是否有自己id
     * @return array            上级数组 含$cate_id
     */
    public function getParentCate($cate_id,$m=true){
        $cate_id = intval($cate_id);
        if( $cate_id <= 0 ){
            return [];
        }
        $cate_array = [];
        if($m){
            $cate_array[] = $cate_id;
        }
        $pid = $cate_id;
        do{
           $info =  Db::table($this->getTable())
                ->field('pid')
                ->where('cate_id',$pid)
                ->find();
           if( empty($info) || $info['pid'] == 0 ){
               return $cate_array;
               break;
           }else{
               $cate_array[] = $info['pid'];
               $pid = $info['pid'];
           }
        }while( $pid > 0 );
        return $cate_array;
    }

    public function getChildCate($cate_id,$m=true){
        $cate_id = intval($cate_id);
        if( $cate_id <= 0 ){
            return [];
        }
        $cate_array = [];
        if($m){
            $cate_array[] = $cate_id;
        }
        $pid = $cate_id;
        do{
            $info = Db::table($this->getTable())
                ->field('cate_id')
                ->where('pid',$pid)
                ->find();
            if( empty($info) ){
                return $cate_array;
                break;
            }else{
                $cate_array[] = $info['cate_id'];
                $pid = $info['cate_id'];
            }
        }while( $pid > 0 );
        return $cate_array;
    }

}