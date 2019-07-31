<?php


namespace app\api\controller\v1;


use app\api\validate\Count;

class Product
{
    public function getRecent($count=15){
        (new Count())->goCheck();
         return 'success';
    }
}