<?php


namespace app\api\model;


class Product extends BaseModel
{
        protected $hidden = [
            'delete_time','category_id','from','create_time','update_time','pivot'
        ];  //stock库存量
        public function getMainImgUrlAttr($value,$data){           //getMainImgUrlAttr:MainImgUrl参数字段名
           return $this->prefixImgUrl($value,$data);
        }

        public static function getMostRecent($count){
            $products = self::limit($count)         //limit指定数量
               ->order('create_time desc')      //order排序create_time排序的依据字段desc降序排列
               ->select();
            return $products;
        }
        public function imgs(){     //商品详情图->一对多的关系
            return  $this->hasMany('ProductImage','product_id','id');
        }
        public function properties(){     //商品的参数->一对多的关系
            return $this->hasMany('ProductProperty','product_id','id');
        }
        public static function getProductsByCategoryID($categoryID){
            $product = self::where('category_id','=',$categoryID)
                ->select();
            return $product;
        }

        public static function getProductDetail($id){
            $products = self::with([
                'imgs' => function($query){
                   $query->with(['imgUrl'])
                   ->order('order','asc');    //asc升序排列
                }
            ])
                ->with(['properties'])
                ->find($id);
            return $products;

        }

}