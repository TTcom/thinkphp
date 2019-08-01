<?php


namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveint;
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
        if($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    /**
     * @url /theme/:id
     * @param $id
     */
    public function getComplexOne($id){
        (new IDMustBePostiveint())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);

        if(!$theme){
            throw new ThemeException();
        }else{
            return $theme;
        }

    }
}