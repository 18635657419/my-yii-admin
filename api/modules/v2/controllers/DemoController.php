<?php
namespace api\modules\v2\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\api\AccessToken;
use common\helpers\ResultDataHelper;
use api\controllers\OffAuthController;
use api\modules\v1\models\LoginForm;

/**
 * demo接口
 */
class DemoController extends \yii\rest\ActiveController
{
    public $modelClass = '';
    public function actions(){

        $actions = parent::actions();

        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);

        return $actions;
    }

    public function actionIndex()
    {
        $data= 'https://api.spapps.cn/backend/web/uploads/img/20190801/15646492610.jpg';

        return $data;


//                $banner[$b]['image'] = Yii::$app->request->hostInfo.'/backend/web'.$banner[$b]['url'];
//                $banner[$b]['image'] = 'https://api.spapps.cn'.'/backend/web'.$banner[$b]['url'];


        $banner[]['image']  = 'https://api.spapps.cn/backend/web/uploads/img/20190801/15646492610.jpg';

//        $banner_url =  array_column($banner,'url');



        if(!empty($res_recommend)){
            $data['goods_list_recommend'] = $res_recommend[1];
        }else{
            $data['goods_list_recommend'] = [];
        }
        if(!empty($res_new)){
            $data['goods_list_new'] = $res_new[1];
        }else{
            $data['goods_list_new'] = [];
        }
        if(!empty($res_hot)){
            $data['goods_list_hot'] = $res_hot[1];
        }else{
            $data['goods_list_hot'] = [];
        }


        $data['nav'] = [];

        $data['slideshow'] = $banner;
        return $data;

//        return  ['message' => '获取首页轮播图成功','code' => 1,'data' => $data];
    }
}
