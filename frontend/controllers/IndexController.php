<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/8
 * Time: 下午10:57
 */

namespace frontend\controllers;


use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionWish()
    {
        return $this->render("wish");
    }

    public function actionWishList()
    {
        return $this->render("wish-list");
    }

    public function actionMyWish()
    {
        return $this->render("my-wish-empty");
    }

    public function actionRewardList()
    {
        return $this->render("reward-list");
    }
}