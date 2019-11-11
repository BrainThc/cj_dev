<?php
namespace app\admin\model;
use think\Db;
use think\Exception;
use think\Model;
/**
 * 分类属性model
 * Class User
 */
class GoodsCateProp extends Model
{

    protected $name = 'goods_category_prop';
    protected $pk = 'prop_id';

    /**
     * 继承所有上级属性类目
     * @param array $cate_id                                        分类id
     * @param bool $showVal                                         返回是否含属性值
     * @return array
     */
    public function get_prop_list($cate_id=[],$showVal=false){
        $where = '';
        if( is_array($cate_id) && !empty($cate_id)  ){
            $cate_id = implode(',',$cate_id);
            $where .= "p.cate_id in ({$cate_id})";
        }else if( is_int($cate_id) && intval($cate_id) > 0 ){
            $where .= "p.cate_id = {$cate_id}";
        }else{
            return [];
        }
        $prop_list = Db::table($this->getTable().' p')
            ->join($this->getTable('goods_category').' c',' p.cate_id = c.cate_id')
            ->field('p.*,c.cate_name')
            ->where($where)
            ->select();

        if( $showVal && !empty($prop_list) ){
            $catePropValModel = model('GoodsCatePropVal');
            foreach( $prop_list as $pkey => $prop ){
                $prop['child'] = Db::table($catePropValModel->getTable())->where('prop_id',$prop['prop_id'])->select();
                $prop_list[$pkey] = $prop;
            }
        }
        return $prop_list;
    }

    //创建属性类目
    public function create_prop(){
        $data = input('post.');
        try{
            if( empty($data['cate_id']) && !empty($data['']) ){

            }
        }catch( Exception $e ){
            returnJson(false,$e->getMessage());
        }
    }
}