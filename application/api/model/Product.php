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

        public static function getProductsByCategoryID($categoryID){
            $product = self::where('category_id','=',$categoryID)
                ->select();
            return $product;
        }


}