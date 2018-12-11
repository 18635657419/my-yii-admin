<?php
/**
 * Created by PhpStorm.
 * User: billyshen
 * Date: 2018/8/15
 * Time: 上午10:11
 */

namespace api\modules\v1\controllers;

use common\models\api\Category;
use common\models\api\Media;
use yii;
use api\controllers\OffAuthController;
use common\widgets\Helper;
use addons\RfArticle\common\models\Article;

class ArticlesController extends \yii\rest\ActiveController
{
    public $modelClass = 'dons\RfArticle\common\models\Article';
    public function actions()
    {
        $actions = parent::actions();

        // 禁用动作
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    /**
     * 分类接口
     * @return array|yii\db\ActiveRecord[]
     * @params  symbol=goods(商品分类)/
     * @author nwh@caiyoudata.com
     * @time 2018/6/27 17:58
     */
    public function actionIndex(){


        function add_show_sales($sales,$goods_id){

            $count_goods_id = strlen($goods_id);

            if($count_goods_id<=4){
                $num_goods_id = sqrt(intval($goods_id));
            }elseif (4<$count_goods_id || $count_goods_id<=8){
                $num_goods_id = sqrt(sqrt(intval($goods_id)));
            }elseif (8<$count_goods_id || $count_goods_id<=12){
                $num_goods_id = sqrt(sqrt(sqrt(intval($goods_id))));
            }

            $add_count = $num_goods_id+ (time() - 1544532443)/5000;


//            $add_count = sqrt(intval($goods_id))+ (time() - 1544532443)/4000;
            return $sales+round($add_count,0);
        }

        $sales = 0;
        $goods_id = 9;
        return add_show_sales($sales,$goods_id);



        $params=Yii::$app->request->get();
        $symbol=isset($params['symbol'])?$params['symbol']:"";
        $type=isset($params['type'])?$params['type']:"";
        $models = Article::find()
            ->all();

        if(!empty($models)){
            return ["message"=>"成功","code"=>1,'data'=>$models];
        }else{
            return ["message"=>"分类参数symbol错误","code"=>1002];
        }
    }

    public function actionView($id){
        $article=Article::find()->where(['id'=>$id])->one();
        if(empty($article)){
            return ["message"=>"Object not found: ".$id,"code"=>1002];
        }
        return $article;
    }

}