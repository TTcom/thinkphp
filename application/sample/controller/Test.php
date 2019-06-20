<?php


namespace app\sample\controller;

use think\Request;
class Test
{

     public function hello(Request $request){
       //  $all = input('param.');
         $all = $request->param();
        // var_dump($all);
//         $name = Request::instance()->param('name');
//         $age = Request::instance()->param('age');
//
//         echo $id;
//         echo '|';
//         echo $name;
//         echo '|';
//         echo $age;
        // return 'hello qiyue';
     }
}