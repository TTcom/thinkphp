<?php


namespace app\api\validate;


class IDCollection extends BaseValidate
{

           protected  $rule=[
             'ids' => 'require|checkIDs'
           ];
           protected $message = [
             'ids' => 'ids参数必须为以逗号分隔的多个正整数'

           ];
           //ids=id1,id2...
           protected function checkIDs($value){
               //ids以逗号分隔
               $values = explode(',',$value);
               if(empty($values)){
                   return false;
               }
               foreach ($values as $id){
                   if(!$this->isPositiveInteger($id)){      //调用基类中的验证函数
                         return false;
                   }
               }
               return true;
           }
}