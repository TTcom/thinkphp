<?php


namespace app\api\service;


use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;
use think\Exception;
use think\Request;
use think\Cache;
class Token        //UserToken的基类
{
       public static function generateToken(){
           //32个字符组成一组随机字符串
           $randChars = getRandChar(32);
           //我们用三组字符串进行md5加密

           $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
           //salt盐
           $salt = config('secure.token_salt');
           return md5($randChars . $timestamp . $salt);
       }
       public static function getCurrentTokenVar($key){    //获取缓存
              $token = Request::instance()   //从http头来拿token
                  ->header('token');
              $vars = Cache::get($token);
              if(!$vars){
                  throw new TokenException();
              }else{
                  if(!is_array($vars)){
                      $vars = json_decode($vars,true);
                  }
                  if(array_key_exists($key,$vars)){  //如果数组中存在$key
                      return $vars[$key];
                  }else{
                      throw  new Exception('尝试获取的Token变量并不存在');
                  }

              }

       }
       public  static function  getCurrentUid(){      //获取uid
           //token
          $uid = self::getCurrentTokenVar('uid');
          return $uid;
       }
       // address引用 权限设置
       public static function needPrimaryScope(){

           $scope = self::getCurrentTokenVar('scope');
           if(!$scope){
               throw new TokenException();
           }
           if($scope >= ScopeEnum::User){
               return true;
           }else{
               throw new ForbiddenException();
           }
       }
      // order引用 权限设置
       public static function needExclusiveScope(){
           $scope = self::getCurrentTokenVar('scope');
           if(!$scope){
               throw new TokenException();
           }
           if($scope == ScopeEnum::User){
               return true;
           }else{
               throw new ForbiddenException();
           }
       }
       public static function isValidOperate($checkedUID){   //检测操作是否合法

           if(!$checkedUID){
               throw new Exception('检查UID时必须转入被检查的UID');
           }
           $currentOperateUID = self::getCurrentUid();
           if($currentOperateUID == $checkedUID){
               return true;
           }
           return false;
       }

}