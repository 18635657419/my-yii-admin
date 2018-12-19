<?php
/**
 * Created by PhpStorm.
 * User: billyshen
 * Date: 2018/8/15
 * Time: 上午10:11
 */

namespace api\modules\v2\controllers;

use common\models\api\Category;
use common\models\api\Media;
use yii;
use api\controllers\OffAuthController;
use common\widgets\Helper;
use addons\RfArticle\common\models\Article;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class ArticlesController extends OffAuthController
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
        $params=Yii::$app->request->get();
        $title=isset($params['title'])?$params['title']:"";
        $seo_key=isset($params['seo_key'])?$params['seo_key']:"";
        $seo_content=isset($params['seo_content'])?$params['seo_content']:"";
        $cate_id=isset($params['cate_id'])?$params['cate_id']:"";
        $author=isset($params['author'])?$params['author']:"";

        $models = Article::find()
            ->andFilterWhere(['like','title',$title])
            ->andFilterWhere(['like','seo_key',$seo_key])
            ->andFilterWhere(['like','seo_content',$seo_content])
            ->andFilterWhere(['like','author',$author])
            ->andFilterWhere(['cate_id'=>$cate_id])
            ->all();





        $models = new ActiveDataProvider([
            'query' => Article::find()
                ->andFilterWhere(['like','title',$title])
                ->andFilterWhere(['like','seo_key',$seo_key])
                ->andFilterWhere(['like','seo_content',$seo_content])
                ->andFilterWhere(['like','author',$author])
                ->andFilterWhere(['cate_id'=>$cate_id]),
            'pagination' => [
                'pageSize' => Yii::$app->params['user.pageSize'],
                'validatePage' => false,// 超出分页不返回data
            ],
        ]);
        $list = $models->getModels();


        return $list;

    }

    public function actionView($id){
        $article=Article::find()->where(['id'=>$id])->one();

        if(strpos($article['link'],'?url=')){
            $article['link'] = substr(strstr( $article['link'], '?url='),5); //默认返回查找值@之后的尾部
        }

        if(empty($article)){
            return ["message"=>"Object not found: ".$id,"code"=>1002];
        }
        return $article;
    }

}