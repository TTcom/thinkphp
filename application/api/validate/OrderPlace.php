<?php


namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{

          protected $rule = [
            'products' => 'checkProducts'
          ];
          protected $singleRule = [
              'product_id' => 'require|isPositiveInteger',
              'count' => 'require|isPositiveInteger'
          ];
          protected function checkProducts($values){
              if(empty($values)){
                  throw new ParameterException([
                      'msg'=>'商品不可为空'
                  ]);
              }
              if(!is_array($values)){
                  throw new ParameterException([
                      'msg'=>'参数必须为数组'
                  ]);
              }
              foreach ($values as $value){
                $this->checkProduct($value);
                return true;
              }
          }

          protected function checkProduct($value){
                $validate = new BaseValidate($this->singleRule);
                $result = $validate->check($value);
                if(!$result){
                    throw new ParameterException([
                        'msg' => '商品参数错误'
                    ]);
                }
          }

}