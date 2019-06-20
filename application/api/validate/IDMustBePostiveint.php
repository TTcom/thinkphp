<?php


namespace app\api\validate;




class IDMustBePostiveint extends BaseValidate
{
    //定义校验规则id要进行isPositiveInteger的验证
  protected $rule = [
       'id' => 'require|isPositiveInteger'   //id使用isPositiveInteger进行验证
  ];
  //验证方法可以传入的参数共有5个（后面三个根据情况选用），依次为：验证数据、验证规则、全部数据（数组）、字段名、字段描述
  protected function isPositiveInteger($value,$rule='',$data='',$field=''){

      if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
      }else{
          return $field.'必须是正整数';
      }
  }





}