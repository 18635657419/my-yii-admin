<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\api\AccessToken;
use common\helpers\ResultDataHelper;
use api\controllers\OffAuthController;
use api\modules\v1\models\LoginForm;

/**
 * 登录接口
 *
 * Class SiteController
 * @package api\modules\v1\controllers
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
        return ['message'=>'通通'];

    }
}
