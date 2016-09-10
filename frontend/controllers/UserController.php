<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/8/16
 * Time: 下午11:08
 */

namespace frontend\controllers;


use Yii;
use yii\web\Response;

/**
 * Class UserController
 * @package frontend\controllers
 */
class UserController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'common\web\ErrorAction',
            ],
        ];
    }

    /**
     * @SWG\Post(path="/user/register",
     *   tags={"用户接口"},
     *   summary="用户注册",
     *   produces={"application/json"},
     *     @SWG\Parameter(
     *            name="username",
     *            description="用户名",
     *            in="query",
     *            required=true,
     *            type="string"
     *        ),
     *         @SWG\Parameter(
     *            name="captcha",
     *            description="验证码",
     *            in="query",
     *            required=true,
     *            type="string",
     *        ),
     *   @SWG\Response(response=200, description="请求成功")
     * )
     */
    public function actionRegister()
    {
        return $this->returnJson([]);
    }
}