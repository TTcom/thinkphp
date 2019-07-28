<?php


namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * @ /theme?ids=1,2,3
     */
    public function getSimpleList($ids=''){
        (new IDCollection())->goCheck();

        $ids = explode(',',$ids);
        $result = ThemeModel::with('topicImg,headImg')
            ->select($ids);
        if(!$result){
            throw new ThemeException();
        }
        return $result;

         //return 'success';
    }
}