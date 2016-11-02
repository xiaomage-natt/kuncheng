<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/10/31
 * Time: 下午9:34
 */

namespace frontend\controllers;


use frontend\models\BeidemaForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class BeidemaController extends Controller
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[\yii\web\Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    public function actionForm()
    {
        $params = \Yii::$app->request->post();
        $beidemaForm = new BeidemaForm();
        $beidemaForm->name = ArrayHelper::getValue($params, 'Name');
        $beidemaForm->mobile = ArrayHelper::getValue($params, 'Phone');
        $beidemaForm->address = ArrayHelper::getValue($params, 'Adrress');
        $beidemaForm->marry = ArrayHelper::getValue($params, 'Marry');
        $beidemaForm->child = ArrayHelper::getValue($params, 'Child');
        if($beidemaForm->save()) {
            return "success";
        } else {
            return "err:保存失败";
        }
    }
}