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



        }
}