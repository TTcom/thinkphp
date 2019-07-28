<?php


namespace app\api\validate;




class IDMustBePostiveint extends BaseValidate
{
    //定义校验规则id要进行isPositiveInteger的验证
  protected $rule = [
       'id' => 'require|isPositiveInteger'   //id使用isPositiveInteger进行验证
  ];
    protected $message = [
        'id' => 'id参数必须为正整数'

    ];
  //验证方法可以传入的参数共有5个（后面三个根据情况选用），依次为：验证数据、验证规则、全部数据（数组）、字段名、字段描述






}