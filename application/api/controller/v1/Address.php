<?php


namespace app\api\controller\v1;


use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\userException;
use app\lib\enum\ScopeEnum;
use think\Controller;
use think\Exception;


class Address extends Controller
{

    protected $beforeActionList = [
        'checkPrimaryScope'=>['only'=>'createOrUpdateAddress']
    ];
    protected function checkPrimaryScope(){
        $scope = TokenService::getCurrentTokenVar('scope');
        if(!$scope){
            throw new TokenException();
        }
        if($scope >= ScopeEnum::User){
            return true;
        }else{
            throw new ForbiddenException();
        }
    }
//
//    private function  first(){
//        echo 'first';
//    }
//
//    public function second(){
//        echo 'second';
//    }






    public function createOrUpdateAddress(){

        $validate = new AddressNew();

        $validate->goCheck();
        // 根据Token来获取uid
        //根据uid来查找用户数据，判断用户是否存在，如果不存在抛出异常
        // 获取用户从客户端提交来的地址信息
        // 根据用户地址信息是否存在，从而判断是添加地址还是更新地址
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
        $dataArray = $validate->getDataByRule(input('post.'));



        $userAddress = $user->address;
        if(!$userAddress){   //如果用户地址不存在就新增，如果存在就更新
            $user->address()->save($dataArray);
        }else{
            $user->address->save($dataArray);
        }
         //   return $user;
              return json(new SuccessMessage(),201);
    }
}