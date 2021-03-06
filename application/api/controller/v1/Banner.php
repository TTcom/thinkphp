<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveint;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;
use app\api\validate\BaseValidate;
class Banner extends BaseController
{
    /*
     * 获取指定id的banner信息
     * @url /banner/:id
     * @id banner的id号
     * @http GET
     */
      public  function getBanner($id)
      {

          (new IDMustBePostiveint())->goCheck();
          $banner = BannerModel::getBannerByID($id);

          if(!$banner){
             throw new BannerMissException();
            //  throw new Exception('内部错误');
          }
          return $banner;

      }
}