<?php


namespace app\api\validate;


class Count extends BaseValidate
{
       protected $rule = [
           'count' => 'isPositiveInteger|between:1,15'       //取值在1至15之间
       ];
}