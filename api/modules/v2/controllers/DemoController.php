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
        return ['message'=>'api9哇哇问哇哇1111199999991111哇哇通'];

    }
}
